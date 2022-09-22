<?php

declare(strict_types=1);

namespace MichaelRubel\ValueObjects\Complex;

use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use MichaelRubel\ValueObjects\ValueObject;

/**
 * @method static static make(string $classString)
 */
class ClassString extends ValueObject
{
    use Macroable, Conditionable;

    /**
     * @param  string|null  $classString
     */
    public function __construct(protected ?string $classString)
    {
        //
    }

    /**
     * @return bool
     */
    public function classExists(): bool
    {
        return class_exists($this->value());
    }

    /**
     * @return bool
     */
    public function interfaceExists(): bool
    {
        return interface_exists($this->value());
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return (string) $this->classString;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [$this->value()];
    }

    /**
     * Get string representation of the value object.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
