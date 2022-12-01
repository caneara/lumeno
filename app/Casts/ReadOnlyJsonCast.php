<?php

namespace App\Casts;

use JsonSerializable;
use Illuminate\Support\Arr;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ReadOnlyJsonCast implements CastsAttributes
{
    /**
     * Generate a JSON class using the given data.
     *
     */
    protected function create(object $data)
    {
        return new class ($data) implements JsonSerializable {
            public function __construct(protected object $data)
            {
                //
            }

            public function __get($name)
            {
                return property_exists($this->data, $name) ? $this->data->{$name} : null;
            }

            public function except(string | array $keys = []) : array
            {
                return Arr::except($this->toArray(), $keys);
            }

            public function jsonSerialize() : object
            {
                return $this->data;
            }

            public function only(string | array $keys = []) : array
            {
                return Arr::only($this->toArray(), $keys);
            }

            public function toArray() : array
            {
                return (array) $this->data;
            }
        };
    }

    /**
     * Cast the given value.
     *
     */
    public function get($model, string $key, $value, array $attributes) : object
    {
        $data = filled($value) ? json_decode($value) : [];

        $data = is_array($data) ? (object) $data : $data;

        return $this->create($data);
    }

    /**
     * Retrieve the underlying data source for serialization.
     *
     */
    public function serialize($model, string $key, $value, array $attributes) : object
    {
        return $value->jsonSerialize();
    }

    /**
     * Prepare the given value for storage.
     *
     */
    public function set($model, string $key, $value, array $attributes) : string
    {
        return $model->getRawOriginal($key) ?? json_encode([]);
    }
}
