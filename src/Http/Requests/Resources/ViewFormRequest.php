<?php

declare(strict_types=1);

namespace Leeto\MoonShine\Http\Requests\Resources;

use Leeto\MoonShine\MoonShineRequest;

final class ViewFormRequest extends MoonShineRequest
{
    public function authorize(): bool
    {
        return $this->getResource()->can('view', $this->getDataOrFail());
    }
}
