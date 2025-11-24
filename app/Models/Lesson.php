<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Lesson extends Model
{
    /**
     * @property int $id
     * @property int $topic_id
     * @property string $title
     * @property string $content
     * @property string|null $video_url
     */
    use HasFactory;

    protected $fillable = [
        'topic_id',
        'title',
        'content',
        'video_url',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'topic_id', 'id');
    }
    public function progress()
    {
        return $this->hasMany(UserProgress::class, 'lesson_id', 'id');
    }

}
