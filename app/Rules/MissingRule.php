<?php

namespace App\Rules;

use App\Types\Rule;
use Illuminate\Support\Facades\DB;

class MissingRule extends Rule
{
    /**
     * The additional joins to use.
     *
     */
    protected array $joins = [];

    /**
     * The error message to use.
     *
     */
    protected string $message = 'The selected :attribute already exists.';

    /**
     * The additional constraints to apply.
     *
     */
    protected array $wheres = [];

    /**
     * Apply a join to the database query.
     *
     */
    public function join(string $table, string $first, string $second, string $operator = '=') : static
    {
        $this->joins[] = [
            'table'    => $table,
            'first'    => $first,
            'second'   => $second,
            'operator' => $operator,
        ];

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     */
    public function passes($attribute, $value) : bool
    {
        $table  = (string) str($this->parameters[0])->plural()->lower();
        $column = $this->parameters[1] ?? 'id';
        $query  = DB::table($table)->where($column, $value);

        foreach ($this->joins as $join) {
            $query->join($join['table'], $join['first'], $join['operator'], $join['second']);
        }

        foreach ($this->wheres as $constraint) {
            $query->where($constraint['column'], $constraint['operator'], $constraint['value']);
        }

        return $query->doesntExist();
    }

    /**
     * Apply a conditional to the database query.
     *
     */
    public function where(string $column, mixed $value = null, string $operator = '=') : static
    {
        $this->wheres[] = [
            'column'   => $column,
            'operator' => $operator,
            'value'    => $value,
        ];

        return $this;
    }
}
