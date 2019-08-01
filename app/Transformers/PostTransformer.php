<?php

namespace App\Transformers;

use App\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['topic','user'];
    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'topic' => $post->topics,
            'image' => $post->images,
            'user_id' => $post->user_id,
            'hasZan' => $post->haszan(\Auth::guard('api')->user()->id) ? true : false,
            'user_image' => $post->user->image->path ?? NULL,
            'assumed_name' => $post->assumed_name,
            'user_name' => $post->user->name ?? NULL,
            'forward_post_id' => $post->forward_post_id,
            'original_post_id' => $post->original_post_id,
            'reposts_count' => (int)$post->reposts_count,
            'zans_count' => (int)$post->zans_count,
            'level_id' => $post->level_id,
            'created_at' => $post->created_at->toDateTimeString(),
            'updated_at' => $post->updated_at->toDateTimeString(),
        ];
    }
}
