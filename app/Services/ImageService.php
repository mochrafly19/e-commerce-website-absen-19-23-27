<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class ImageService
{
    /**
     * Store an uploaded image.
     *
     * @param  \Illuminate\Http\UploadedFile  $image
     * @return string
     */
    public function store(UploadedFile $image)
    {
        // Store the image in the 'public/images' directory
        $path = $image->store('images', 'public');
        // Return the URL of the stored image
        return Storage::url($path);
    }
}
