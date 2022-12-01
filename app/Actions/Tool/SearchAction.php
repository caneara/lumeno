<?php

namespace App\Actions\Tool;

use App\Models\Tool;
use App\Types\Action;
use Illuminate\Contracts\Pagination\Paginator;

class SearchAction extends Action
{
    /**
     * The fields to retrieve.
     *
     */
    protected static array $fields = [
        'tools.id',
        'tools.name',
        'tools.metrics',
        'tools.originated',
        'categories.name AS category',
    ];

    /**
     * Search for tools that match the given query.
     *
     */
    public static function execute(bool $exact, string $search, int $page) : Paginator
    {
        return Tool::query()
            ->join('categories', 'tools.category_id', '=', 'categories.id')
            ->when($exact, fn($query) => $query->where('tools.id', $search))
            ->when(! $exact, fn($query) => $query->whereLike('tools.name', $search))
            ->groupBy('tools.id')
            ->orderBy('tools.name')
            ->orderBy('categories.name')
            ->orderBy('tools.id')
            ->simplePaginate(10, static::$fields, 'page', $page)
            ->through(fn($item) => static::format($item));
    }

    /**
     * Format the data for use.
     *
     */
    protected static function format(Tool $item) : array
    {
        $count = $item->metrics->skill_count ?? 0;

        $plural = $count === 1 ? 'professional has' : 'professionals have';

        return [
            'id'         => $item->id,
            'name'       => $item->name,
            'category'   => $item->category,
            'count'      => $count,
            'originated' => $item->originated,
            'notice'     => number_format($count) . " {$plural} experience with this tool",
        ];
    }
}
