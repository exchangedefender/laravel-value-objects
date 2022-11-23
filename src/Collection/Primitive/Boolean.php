<?php

declare(strict_types=1);

/**
 * This file is part of michael-rubel/laravel-value-objects. (https://github.com/michael-rubel/laravel-value-objects)
 *
 * @link https://github.com/michael-rubel/laravel-value-objects for the canonical source repository
 * @copyright Copyright (c) 2022 Michael Rubél. (https://github.com/michael-rubel/)
 * @license https://raw.githubusercontent.com/michael-rubel/laravel-value-objects/main/LICENSE.md MIT
 */

namespace MichaelRubel\ValueObjects\Collection\Primitive;

use Illuminate\Support\Stringable;
use InvalidArgumentException;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * "Boolean" object presenting a boolean value.
 *
 * @author Michael Rubél <michael@laravel.software>
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @method static static make(bool|int|string $value)
 * @method static static from(bool|int|string $value)
 * @method static static makeOrNull(bool|int|string|null $value)
 *
 * @extends ValueObject<TKey, TValue>
 */
class Boolean extends ValueObject
{
    /**
     * @var bool|int|string
     */
    protected bool|int|string $value;

    /**
     * Values that represent `true` boolean.
     *
     * @var array
     */
    protected array $trueValues = ['1', 'true', 1, 'on', 'yes'];

    /**
     * Values that represent `false` boolean.
     *
     * @var array
     */
    protected array $falseValues = ['0', 'false', 0, 'off', 'no'];

    /**
     * Create a new instance of the value object.
     *
     * @param  bool|int|string  $value
     */
    public function __construct(bool|int|string $value)
    {
        if (isset($this->value)) {
            throw new InvalidArgumentException(static::IMMUTABLE_MESSAGE);
        }

        $this->value = $value;

        if (! is_bool($this->value)) {
            $this->handleNonBooleanValue();
        }
    }

    /**
     * Get the object value.
     *
     * @return bool
     */
    public function value(): bool
    {
        return (bool) $this->value;
    }

    /**
     * Determine if the passed boolean is true.
     *
     * @return void
     */
    protected function handleNonBooleanValue(): void
    {
        $string = new Stringable($this->value);

        $this->value = match (true) {
            $string->contains($this->trueValues, true) => true,
            $string->contains($this->falseValues, true) => false,
            default => throw new InvalidArgumentException('Invalid boolean.'),
        };
    }

    /**
     * Get string representation of the value object.
     *
     * @return string
     */
    public function toString(): string
    {
        return ! empty($this->value()) ? 'true' : 'false';
    }

    /**
     * Get string representation of the value object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
