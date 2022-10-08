<?php

declare(strict_types=1);

namespace Leeto\MoonShine\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class MoonshineUserRole extends Model
{
    use HasFactory;

    public const DEFAULT_ROLE_ID = 1;

    protected $fillable = [
        'id',
        'name'
    ];

    public function moonshineUsers(): HasMany
    {
        return $this->hasMany(MoonshineUser::class);
    }
}
