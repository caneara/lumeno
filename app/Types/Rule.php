<?php

namespace App\Types;

use Illuminate\Contracts\Validation\Rule as BaseRule;

abstract class Rule implements BaseRule
{
    /**
     * The error message to use.
     *
     */
    protected string $message = 'An error occurred';

    /**
     * The parameters supplied to the rule.
     *
     */
    protected array $parameters;

    /**
     * Constructor.
     *
     */
    public function __construct()
    {
        $this->parameters = func_get_args();
    }

    /**
     * Factory method.
     *
     */
    public static function make() : static
    {
        return new static(...func_get_args());
    }

    /**
     * Retrieve the validation error message.
     *
     */
    public function message() : string
    {
        return $this->message;
    }

    /**
     * Set the validation error message.
     *
     */
    public function setErrorMessage(string $message) : static
    {
        $this->message = $message;

        return $this;
    }
}
