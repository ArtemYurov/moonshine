<?php

declare(strict_types=1);

namespace Leeto\MoonShine\Traits\Fields;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Stringable;
use Leeto\MoonShine\Helpers\Condition;

trait WithHtmlAttributes
{
    protected ?string $name = null;

    protected ?string $id = null;

    protected bool $required = false;

    protected bool $disabled = false;

    protected bool $readonly = false;

    public function id(string $index = null): string
    {
        if ($this->id) {
            return $this->id;
        }

        return (string) str($this->name ?? $this->name())
            ->replace(['[', ']'], '_')
            ->replaceMatches('/\${index\d+}/', '')
            ->replaceMatches('/_{2,}/', '_')
            ->trim('_')
            ->snake()
            ->when(!is_null($index), fn(Stringable $str) => $str->append("_$index"));
    }

    public function name(string $index = null): string
    {
        return $this->prepareName($index);
    }

    protected function prepareName($index = null, $wrap = null): string
    {
        if ($this->name) {
            return $this->name;
        }

        return (string) str($this->column())
            ->when(!is_null($wrap), fn(Stringable $str) => $str->wrap("{$wrap}[", "]"))
            ->when(
                $this->getAttribute('multiple'),
                fn(Stringable $str) => $str->append("[".($index ?? '')."]")
            );
    }

    protected function nameDot(string $prefix = null): string
    {
        $name = (string) str($this->name())
            ->replace('[]', '');

        parse_str($name, $array);

        $result = collect(Arr::dot(array_filter($array)));

        $result = $result->isEmpty()
            ? $name
            : (string) str($result->keys()->first());

        if($prefix) {
            $result = "$prefix.$result";
        }

        return $result;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function setId(string $id): static
    {
        $this->id = (string) str($id)->remove(['[', ']'])->snake();

        return $this;
    }

    public function required($condition = null): static
    {
        $this->required = Condition::boolean($condition, true);

        return $this;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function disabled($condition = null): static
    {
        $this->disabled = Condition::boolean($condition, true);

        return $this;
    }

    public function isDisabled(): bool
    {
        return $this->disabled;
    }

    public function readonly($condition = null): static
    {
        $this->readonly = Condition::boolean($condition, true);

        return $this;
    }

    public function isReadonly(): bool
    {
        return $this->readonly;
    }
}
