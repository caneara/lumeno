<?php

namespace App\Actions\Image;

use App\Types\Model;
use App\Types\Action;
use App\Storage\Image as Storage;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;

class UpdateAction extends Action
{
    /**
     * Update the given model using the given image.
     *
     */
    public static function execute(Model $model, string $attribute, UploadedFile $image = null) : void
    {
        if (! $image) {
            return;
        }

        if (filled($model->{$attribute})) {
            Storage::delete($model->{$attribute});
        }

        attempt(fn() => $model->update([$attribute => uuid()]));

        $upload = Image::make($image)
            ->fit(512, 512, fn($constraint) => $constraint->upsize());

        $content = Image::canvas($upload->width(), $upload->height(), '#FFFFFF')
            ->insert($upload)
            ->encode('jpg', 80);

        Storage::put($model->{$attribute}, $content);
    }
}
