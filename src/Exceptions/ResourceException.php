<?php

declare(strict_types=1);

namespace Leeto\MoonShine\Exceptions;

use Exception;

final class ResourceException extends Exception
{
    public static function queryError(string $message): self
    {
        return new static("Query error: $message");
    }
}
