<?php

namespace App\Storage;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image as Intervention;

class Image
{
    /**
     * Determine whether an image with the given identifier exists.
     *
     */
    public static function assertExists(string $id) : void
    {
        Storage::assertExists("images/{$id}.jpg");
    }

    /**
     * Determine whether an image with the given identifier does not exist.
     *
     */
    public static function assertMissing(string $id) : void
    {
        Storage::assertMissing("images/{$id}.jpg");
    }

    /**
     * Delete one or more images with the given identifier(s).
     *
     */
    public static function delete(string | array | Collection $id = null) : void
    {
        collect($id)->filter()->each(fn($item) => Storage::delete("images/{$item}.jpg"));
    }

    /**
     * Delete the temporary image with the given identifier.
     *
     */
    public static function deleteTemporaryFile(string $id) : void
    {
        Storage::delete("tmp/{$id}");
    }

    /**
     * Generate a fake image and retrieve its URL.
     *
     */
    public static function fake(string $id = '') : string
    {
        $id = $id ? $id : uuid();

        $image = imagecreatetruecolor(10, 10);

        imagejpeg($image, storage_path("framework/testing/fake.jpg"));

        imagedestroy($image);

        static::put($id, File::get(storage_path("framework/testing/fake.jpg")));

        File::delete(storage_path("framework/testing/fake.jpg"));

        return static::url($id);
    }

    /**
     * Retrieve the image with the given identifier.
     *
     */
    public static function get(string $id) : string
    {
        return Storage::get("images/{$id}.jpg");
    }

    /**
     * Retrieve the temporary image with the given identifier.
     *
     */
    public static function getTemporaryFile(string $id) : string
    {
        return Storage::get("tmp/{$id}");
    }

    /**
     * Save the given content to an image with the given identifier.
     *
     */
    public static function put(string $id, string | Intervention $content = '') : void
    {
        Storage::put("images/{$id}.jpg", (string) $content);
    }

    /**
     * Retrieve the URL to an image with the given identifier.
     *
     */
    public static function url(string $id) : string
    {
        return Storage::url("images/{$id}.jpg");
    }
}
