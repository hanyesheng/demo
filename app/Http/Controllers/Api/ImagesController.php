<?php

namespace App\Http\Controllers\Api;

use App\Image;
use Illuminate\Http\Request;
use App\Transformers\ImageTransformer;
use App\Http\Requests\Api\ImageRequest;

class ImagesController extends Controller
{
    public function store(ImageRequest $request, Image $image)
    {
        $user = $this->user();

        $image->type = $request->type;
        $image->user_id = $user->id;
        if ($request->file('image')) {
            $path = $request->file('image')->storePublicly($user->id);
            $image->path = "/storage/" . $path;
        }
        $image->save();

        return $this->response->item($image, new ImageTransformer())->setStatusCode(201);
    }
}