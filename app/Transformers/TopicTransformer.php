<?php

namespace App\Transformers;

use App\Topic;
use League\Fractal\TransformerAbstract;

class TopicTransformer extends TransformerAbstract
{
    public function transform(Topic $topic)
    {
        return [
            'id' => $topic->id,
            'name' => $topic->name,
            'users_count' => (int)$topic->users_count,
            'posts_count' => (int)$topic->posts_count,
            'today_posts_count' => (int)$topic->today_posts_count,
            'created_at' => $topic->created_at->toDateTimeString(),
            'updated_at' => $topic->updated_at->toDateTimeString(),
        ];
    }
}
