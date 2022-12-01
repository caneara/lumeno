<?php

namespace App\Responses;

use Exception;
use App\Models\User;
use App\Types\Model;
use App\Storage\Image;
use App\Models\Article;
use Illuminate\Support\Str;

class Meta
{
    /**
     * Generate the Open Graph and Twitter Card meta tags for the given model.
     *
     */
    public static function create(Model $model) : array
    {
        return [
            'title'       => static::getTitle($model),
            'description' => static::getDescription($model),
            'type'        => static::getType($model),
            'url'         => static::getUrl($model),
            'image'       => static::getImage($model),
            'twitter'     => [
                'type'    => static::getCard($model),
            ],
        ];
    }

    /**
     * Retrieve the card type to use for the meta tag.
     *
     */
    protected static function getCard(Model $model) : string
    {
        return match (get_class($model)) {
            Article::class => $model->banner ? 'summary_large_image' : 'summary',
            User::class    => 'summary',
            default        => throw new Exception('Unknown model type'),
        };
    }

    /**
     * Retrieve the description to use for the meta tag.
     *
     */
    protected static function getDescription(Model $model) : string
    {
        $value = match (get_class($model)) {
            Article::class => $model->summary,
            User::class    => "{$model->name} is on Lumeno, the portfolio, " .
                              'community and recruitment platform built for IT professionals.',
            default        => throw new Exception('Unknown model type'),
        };

        return Str::limit($value, 197);
    }

    /**
     * Retrieve the image to use for the meta tag.
     *
     */
    protected static function getImage(Model $model) : string
    {
        return match (get_class($model)) {
            Article::class => $model->banner ? Image::url($model->banner) : asset('img/article.jpg'),
            User::class    => $model->avatar ? Image::url($model->avatar) : asset('img/user.jpg'),
            default        => throw new Exception('Unknown model type'),
        };
    }

    /**
     * Retrieve the title to use for the meta tag.
     *
     */
    protected static function getTitle(Model $model) : string
    {
        $value = match (get_class($model)) {
            Article::class => $model->title,
            User::class    => $model->name,
            default        => throw new Exception('Unknown model type'),
        };

        return Str::limit($value, 67);
    }

    /**
     * Retrieve the type to use for the meta tag.
     *
     */
    protected static function getType(Model $model) : string
    {
        return match (get_class($model)) {
            Article::class => 'article',
            User::class    => 'profile',
            default        => throw new Exception('Unknown model type'),
        };
    }

    /**
     * Retrieve the url to use for the meta tag.
     *
     */
    protected static function getUrl(Model $model) : string
    {
        return match (get_class($model)) {
            Article::class => route('articles.show', ['article' => $model, 'slug' => $model->slug]),
            User::class    => route('account.show', ['user' => $model->handle]),
            default        => throw new Exception('Unknown model type'),
        };
    }
}
