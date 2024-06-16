<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Images;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(Request $request)
    {
        $image = $this->storeImage($request);

        return $this->responseWithData($image, 201, "Image created successfully");
    }

    private function storeImage(Request $request)
    {
        return Images::store($request);
    }

    private function responseWithData($data, $status = 200, $message = "")
    {
        return response()->json([
            "success" => true,
            "data" => $data,
            "message" => $message
        ], $status);
    }
}
