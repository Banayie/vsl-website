from flask import Flask, request, jsonify
from flask_cors import CORS
import cv2
import numpy as np
import mediapipe as mp
from keras.models import load_model
from sklearn.preprocessing import LabelEncoder
import os

app = Flask(__name__)
CORS(app)

# --- Cấu hình ---
MODEL_PATH = "vsl_transformer_model.keras"
LABEL_PATH = "label_encoder_classes.npy"
MAX_SEQ_LEN = 17
POSE_DIM = 7 * 3
HAND_DIM = 21 * 3 * 2
INPUT_DIM = POSE_DIM + HAND_DIM
PRED_THRESHOLD = 0.5

# --- Load model & labels ---
print("Đang load model...")
model = load_model(MODEL_PATH)
le = LabelEncoder()
le.classes_ = np.load(LABEL_PATH, allow_pickle=True)
print("Model đã sẵn sàng!")

# --- Mediapipe setup ---
mp_pose = mp.solutions.pose
mp_hands = mp.solutions.hands
pose_detector = mp_pose.Pose(static_image_mode=True, min_detection_confidence=0.5)
hands_detector = mp_hands.Hands(static_image_mode=True, max_num_hands=2, min_detection_confidence=0.5)


def extract_features(results_pose, results_hands):
    """Trích xuất đặc trưng từ pose và hands"""
    pose_data = np.zeros(POSE_DIM)
    hand_data = np.zeros(HAND_DIM)

    # Pose landmarks (7 điểm: nose, shoulders, elbows, wrists)
    if results_pose.pose_landmarks:
        pose = [[lm.x, lm.y, lm.z] for i, lm in enumerate(results_pose.pose_landmarks.landmark)
                if i in [0, 11, 12, 13, 14, 15, 16]]
        pose_data = np.array(pose).flatten()

    # Hand landmarks (21 điểm x 2 tay)
    if results_hands.multi_hand_landmarks:
        hands_list = []
        for hand_landmarks in results_hands.multi_hand_landmarks:
            hands_list.extend([[lm.x, lm.y, lm.z] for lm in hand_landmarks.landmark])
        hand_data = np.array(hands_list).flatten()
        
        if hand_data.size < HAND_DIM:
            hand_data = np.pad(hand_data, (0, HAND_DIM - hand_data.size))
        else:
            hand_data = hand_data[:HAND_DIM]

    return np.concatenate([pose_data, hand_data])


def process_video(video_path):
    """Xử lý video và trả về dự đoán"""
    if not os.path.exists(video_path):
        raise FileNotFoundError(f"Video không tồn tại: {video_path}")

    cap = cv2.VideoCapture(video_path)
    if not cap.isOpened():
        raise ValueError("Không thể mở video")

    sequence = []
    frame_count = 0
    total_frames = int(cap.get(cv2.CAP_PROP_FRAME_COUNT))
    
    # Tính step để lấy đúng MAX_SEQ_LEN frames
    step = max(1, total_frames // MAX_SEQ_LEN)

    while cap.isOpened() and frame_count < MAX_SEQ_LEN:
        ret, frame = cap.read()
        if not ret:
            break

        # Skip frames theo step
        if len(sequence) < frame_count:
            cap.set(cv2.CAP_PROP_POS_FRAMES, cap.get(cv2.CAP_PROP_POS_FRAMES) + step - 1)
            continue

        # Convert BGR to RGB
        rgb_frame = cv2.cvtColor(frame, cv2.COLOR_BGR2RGB)

        # Detect pose và hands
        results_pose = pose_detector.process(rgb_frame)
        results_hands = hands_detector.process(rgb_frame)

        # Extract features
        features = extract_features(results_pose, results_hands)
        sequence.append(features)
        frame_count += 1

    cap.release()

    # Kiểm tra số lượng frame
    if len(sequence) < MAX_SEQ_LEN:
        # Padding nếu thiếu frame
        while len(sequence) < MAX_SEQ_LEN:
            sequence.append(sequence[-1] if sequence else np.zeros(INPUT_DIM))
    elif len(sequence) > MAX_SEQ_LEN:
        # Cắt nếu thừa
        sequence = sequence[:MAX_SEQ_LEN]

    # Predict
    input_seq = np.expand_dims(np.array(sequence), axis=0)
    predictions = model.predict(input_seq, verbose=0)[0]
    
    predicted_class = np.argmax(predictions)
    confidence = float(predictions[predicted_class])
    predicted_label = le.inverse_transform([predicted_class])[0]

    return {
        'text': predicted_label,
        'confidence': confidence,
        'threshold_passed': confidence > PRED_THRESHOLD
    }


@app.route('/predict', methods=['POST'])
def predict():
    """API endpoint để dự đoán từ video"""
    try:
        data = request.get_json()
        video_path = data.get('video_path')

        if not video_path:
            return jsonify({'error': 'Thiếu video_path'}), 400

        # Process video
        result = process_video(video_path)

        # Kiểm tra threshold
        if not result['threshold_passed']:
            return jsonify({
                'text': 'Không nhận diện được',
                'confidence': result['confidence']
            })

        return jsonify({
            'text': result['text'],
            'confidence': result['confidence']
        })

    except FileNotFoundError as e:
        return jsonify({'error': str(e)}), 404
    except Exception as e:
        return jsonify({'error': f'Lỗi xử lý: {str(e)}'}), 500


@app.route('/health', methods=['GET'])
def health():
    """Health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'model_loaded': model is not None,
        'labels_count': len(le.classes_)
    })


if __name__ == '__main__':
    print("\n" + "="*50)
    print("VSL Recognition Service")
    print(f"Model: {MODEL_PATH}")
    print(f"Labels: {len(le.classes_)} classes")
    print(f"equence length: {MAX_SEQ_LEN} frames")
    print(f"Threshold: {PRED_THRESHOLD}")
    print("="*50 + "\n")
    
    app.run(host='0.0.0.0', port=5000, debug=False)