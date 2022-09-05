<?php

declare(strict_types=1);

namespace Leeto\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use Leeto\MoonShine\Fields\ID;
use Leeto\MoonShine\Fields\Text;
use Leeto\MoonShine\Filters\TextFilter;
use Leeto\MoonShine\Models\MoonshineUserRole;

final class MoonShineUserRoleResource extends ModelResource
{
    public static string $model = MoonshineUserRole::class;

    public string $column = 'name';

    public function title(): string
    {
        return trans('moonshine::ui.base_resource.role');
    }

    public function fields(): array
    {
        return [
            ID::make()->sortable()->showOnExport(),
            Text::make(trans('moonshine::ui.base_resource.role_name'), 'name')
                ->required()->showOnExport(),
        ];
    }

    public function rowActions(Model $item): array
    {
        return [];
    }

    public function rules($item): array
    {
        return [
            'name' => 'required|min:5',
        ];
    }

    public function search(): array
    {
        return ['id', 'name'];
    }

    public function filters(): array
    {
        return [
            TextFilter::make(trans('moonshine::ui.base_resource.role_name'), 'name'),
        ];
    }

    public function actions(): array
    {
        return [];
    }
}
