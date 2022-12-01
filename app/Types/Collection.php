<?php

namespace App\Types;

use App\Rules\InCollectionRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as BaseCollection;

abstract class Collection extends BaseCollection
{
    /**
     * Constructor.
     *
     */
    public function __construct($items = [])
    {
        return $this->items = empty($items) ? $this->source() : $items;
    }

    /**
     * Retrieve the desired item from the collection.
     *
     */
    public static function find(mixed $value, string $field = 'id') : object
    {
        return static::make()->firstWhere($field, $value);
    }

    /**
     * Factory method.
     *
     */
    public static function make($items = []) : static
    {
        return parent::make($items)->sortByDefault();
    }

    /**
     * Create a validation rule for the collection.
     *
     */
    public static function rule(string $key = 'id') : InCollectionRule
    {
        return new InCollectionRule(static::make(), $key);
    }

    /**
     * Seed the database using the records in the collection.
     *
     */
    public static function seed() : void
    {
        $path = str(class_basename(static::class));

        $table = property_exists(static::class, 'table')
               ? static::$table
               : (string) $path->afterLast('\\')->before('Collection')->plural()->lower();

        $data = static::make()->map(fn($item) => (array) $item)->toArray();

        DB::table($table)->insert($data);
    }

    /**
     * Order the collection's items by their default sorting column.
     *
     */
    public function sortByDefault() : static
    {
        return property_exists($this, 'sort') ? $this->sortBy($this->sort)->values() : $this;
    }
}
