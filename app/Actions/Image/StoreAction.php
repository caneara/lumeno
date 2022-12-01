<?php

namespace App\Actions\Image;

use Exception;
use App\Types\Action;
use Intervention\Image\Image;
use App\Storage\Image as Storage;
use Intervention\Image\Facades\Image as Factory;

class StoreAction extends Action
{
    /**
     * Create a new image.
     *
     */
    public static function execute(string $source, string $type) : string
    {
        $image = static::factory($source);

        Storage::put($id = uuid(), static::render($image, $type));

        $image->destroy();

        Storage::deleteTemporaryFile($source);

        return $id;
    }

    /**
     * Initialize an Intervention factory using the given source.
     *
     */
    protected static function factory(string $source) : Image
    {
        $file = Storage::getTemporaryFile($source);

        return Factory::make($file)->orientate();
    }

    /**
     * Apply any edit operations to the given image.
     *
     */
    protected static function process(Image $image, string $type) : Image
    {
        return match ($type) {
            'general' => static::resize($image, $image->width() < 1280),
            'social'  => $image->fit(876, 438, fn($c) => $c->upsize()),
            default   => throw new Exception('Unknown format'),
        };
    }

    /**
     * Draw the given image against a white background.
     *
     */
    protected static function render(Image $image, string $type)
    {
        $image = static::process($image, $type ? $type : 'general');

        $canvas = Factory::canvas($image->width(), $image->height(), '#FFFFFF');

        return $canvas->insert($image)->encode('jpg', 80);
    }

    /**
     * Adjust the size of the given image when appropriate.
     *
     */
    protected static function resize(Image $image, bool $skip) : Image
    {
        return $skip ? $image : $image->resize(1280, null, function($c) {
            return tap(tap($c)->aspectRatio())->upsize();
        });
    }
}
