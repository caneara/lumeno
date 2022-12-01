<?php

namespace Database\Seeders;

use App\Types\Seeder;
use App\Storage\Image;
use Illuminate\Support\Facades\File;
use App\Collections\CurrencyCollection;
use Illuminate\Support\Facades\Storage;
use App\Collections\ToolCategoryCollection;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application database.
     *
     */
    public function run() : void
    {
        parent::run();

        Storage::makeDirectory('images');

        Image::put('user.jpg', File::get(public_path('img/user.jpg')));
        Image::put('project.jpg', File::get(public_path('img/project.jpg')));
        Image::put('article.jpg', File::get(public_path('img/article.jpg')));

        ToolCategoryCollection::seed();
        CurrencyCollection::seed();

        $this->call(TriggerSeeder::class);
        $this->call(LibrarySeeder::class);
        $this->call(FakeSeeder::class);
    }
}
