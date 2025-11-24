@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Trang quản trị')
@section('content')
    <style>
        .welcome-card {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            margin-bottom: 24px;
        }
        
        .welcome-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }
        
        .welcome-text {
            font-size: 14px;
            color: #718096;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }
        
        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.2s;
        }
        
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }
        
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 16px;
        }
        
        .stat-icon.purple {
            background: #e8eaff;
        }
        
        .stat-icon.blue {
            background: #dbeafe;
        }
        
        .stat-icon.green {
            background: #d1fae5;
        }
        
        .stat-label {
            font-size: 13px;
            color: #718096;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }
        
        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .chart-container {
            background: white;
            padding: 28px;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }
        
        .chart-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 20px;
        }
        
        .chart-wrapper {
            position: relative;
            height: 300px;
        }
    </style>

    <div class="welcome-card">
        <h3 class="welcome-title">Xin chào, {{ Auth::user()->name }} 👋</h3>
        <p class="welcome-text">Chào mừng bạn đến trang quản trị hệ thống.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon purple">🎓</div>
            <div class="stat-label">Chủ đề</div>
            <div class="stat-value">{{ \App\Models\Topic::count() }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon blue">📘</div>
            <div class="stat-label">Bài học</div>
            <div class="stat-value">{{ \App\Models\Lesson::count() }}</div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon green">👤</div>
            <div class="stat-label">Người dùng</div>
            <div class="stat-value">{{ \App\Models\User::count() }}</div>
        </div>
    </div>

    <div class="chart-container">
        <h3 class="chart-title">Thống kê tổng quan</h3>
        <div class="chart-wrapper">
            <canvas id="statsChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const ctx = document.getElementById('statsChart').getContext('2d');
        
        const data = {
            labels: ['Chủ đề', 'Bài học', 'Người dùng'],
            datasets: [{
                label: 'Số lượng',
                data: [
                    {{ \App\Models\Topic::count() }},
                    {{ \App\Models\Lesson::count() }},
                    {{ \App\Models\User::count() }}
                ],
                backgroundColor: [
                    'rgba(99, 102, 241, 0.8)',
                    'rgba(59, 130, 246, 0.8)',
                    'rgba(16, 185, 129, 0.8)'
                ],
                borderColor: [
                    'rgb(99, 102, 241)',
                    'rgb(59, 130, 246)',
                    'rgb(16, 185, 129)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                barThickness: 60
            }]
        };

        const config = {
            type: 'bar',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        borderRadius: 8,
                        titleFont: {
                            size: 14,
                            weight: '600'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' ' + context.label.toLowerCase();
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 12
                            },
                            color: '#718096',
                            stepSize: 1
                        },
                        grid: {
                            color: '#f0f2f5',
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 13,
                                weight: '500'
                            },
                            color: '#1a1a1a'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        };

        new Chart(ctx, config);
    </script>
@endsection