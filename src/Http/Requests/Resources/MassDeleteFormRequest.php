<?php

declare(strict_types=1);

namespace Leeto\MoonShine\Http\Requests\Resources;

use Leeto\MoonShine\MoonShineRequest;

final class MassDeleteFormRequest extends MoonShineRequest
{
    public function authorize(): bool
    {
        return $this->getResource()->can('massDelete', $this->getDataInstance());
    }

    public function rules(): array
    {
        return [
            'ids' => ['array']
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'ids' => request()->str('ids')->explode(';')
        ]);
    }
}
