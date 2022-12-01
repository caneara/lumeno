<?php

namespace App\Actions\Tool;

use App\Models\Tool;
use App\Types\Action;
use Illuminate\Contracts\Pagination\Paginator;

class ViewAction extends Action
{
    /**
     * The fields to retrieve.
     *
     */
    protected static array $fields = [
        'tools.id',
        'tools.name',
        'tools.approved',
        'tools.originated',
        'tools.category_id',
        'categories.name AS category',
    ];

    /**
     * Retrieve a list of tools.
     *
     */
    public static function execute(string $name) : Paginator
    {
        return Tool::query()
            ->join('categories', 'tools.category_id', '=', 'categories.id')
            ->whereLike('tools.name', $name)
            ->orderBy('tools.approved')
            ->orderBy('tools.name')
            ->orderBy('categories.id')
            ->orderBy('tools.id')
            ->simplePaginate(10, static::$fields);
    }
}
