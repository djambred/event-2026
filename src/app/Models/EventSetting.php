<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSetting extends Model
{
    protected $fillable = ['key', 'type', 'group', 'value', 'label'];

    public static function get(string $key, ?string $default = null): ?string
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    public static function set(string $key, ?string $value): void
    {
        static::where('key', $key)->update(['value' => $value]);
    }

    public static function getGroup(string $group): array
    {
        return static::where('group', $group)
            ->pluck('value', 'key')
            ->toArray();
    }
}
