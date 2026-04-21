<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class EventSetting extends Model
{
    protected $fillable = ['key', 'type', 'group', 'value', 'label'];

    private const IMAGE_KEYS = [
        'hero_image',
        'road_image',
        'reg_nat_hero_image',
        'reg_int_hero_image',
        'rules_hero_image',
    ];

    private const DEFAULT_IMAGE_SETTINGS = [
        'hero_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuARnuxzzUsWWtV9i_oaWvvJAnlR1KtVVdVaaToWO-NVoGm6iEnFYF16fAu844vPLVC6n-8ob1L4MV9JA1Sy8_aF5-Lm5BzB3oyqsD4gzzIgS_1GOGwVJM67uLBYEgL9rzhTXXN5fFegesYDKy6H-EV3t5eslZHdgumP43nzibR-T2BjbJ9dxaLt1F9b32hL-s-u2TIHJ5sFNxMnJmpfbTiCrnodQUDY28xkixnD3JeQtw3i2aLUJsfcWbdng5CmvETzBTaI8KPBCMk',
        'road_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuD3gA6vKtUlBFvVZ2IiqMMPLbe5mvxIdISzjv6qSYMeHVYYzhzekRkrSW40xXnTdv7k6B-qidsPtTdZqvsj8S9ustyJZxhkqtU2mxQxTOrONActy-MWUo2yUmS2kkG9mlDvNYd37hJyLDCh-WuYDvArJGMn0LF1WaUxX5QhOMSfkUwaSpyXccgRSOHG9AJv5am5QBex43noRGVp-RST1BFK3kgl8tjf0fgPWd4_zsAGCpVI3gcV3has7oBoJAQSy1W2ksjRHo9wfMw',
        'reg_nat_hero_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAymwJ4Vb6bJuEXVaoxY4KP6Ni0HKxuF1r8S_fNZwCQXPl58XB9vmA6KPS-ql2naTC_5SY_dx-Jj2f_4mG3WM_PY_NelwfoCqoZ8Nmcj3YBCjHVikSonhgbOBcIRqFnwaxo30-ZKEjV5gc435mcHgQf8pY7kSiPNmHYC_l6DPhUKMQR-u9cGWjp2B8usDKzK6i2y4FzfbwgfCrzGwcQedVH6zyjYq6Rkwhz5nZr7NMsk5vyPJ7F_VtL97mgCKKZiutsmrsRr-yF3TQ',
        'reg_int_hero_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuASii1uKkJxOKjYWCjbnLLojFSIfdbQOi9NGCOzzF06T3s5In6OzTz5Sg1A2azISLB7zYQ6yUK4GYns_jXlpdcSJG_GRcpykvuZaUv1BVL4nORLA-LwAtKRz8yfIV55X7Qe4yFyb4cKYiqQPsK9uu__UfWk4uSbwxin4w0XptPjXZ02TudVIZj42jM08Fr_YXIYqH8rA3SIJD4bua2WG2IcMr4ku5ow6QLXJlgBF0EiG3DtTFoOm2IpFMoFfs588eBs8idmjI6v1_8',
        'rules_hero_image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCuvFRlDR1XHdWj2S2qXbsEp40jNUBAcvREy9S7El14AWRhfJBLCgvUwzKJDgjO_g87rd9I92ami9TlfFFlg35AGnfpZ5Ky-LJMaVbLN6JLWq1SpWK3HOE86Ha129Sjw5EKCLSpMIyUkDgy-y9ikIyb7lta8buI5rvMmrmMdqxRRdcp1Tk_6x5c7SZTEAQezYK4Mxy9b65NQh8ScPZC6qE9amklfjNZ3eJ7gkndHUtBzQ7XXjkwZvTqedFMChHbt-fi2sTE28cjKvs',
    ];

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

    public static function allForFrontend(): array
    {
        $settings = static::all()->pluck('value', 'key')->toArray();

        foreach (self::IMAGE_KEYS as $key) {
            $fallback = self::DEFAULT_IMAGE_SETTINGS[$key] ?? '';
            $settings[$key] = self::resolveImageValue($settings[$key] ?? null, $fallback);
        }

        return $settings;
    }

    private static function resolveImageValue(?string $value, string $fallback): string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return $fallback;
        }

        if (
            str_starts_with($value, 'http://') ||
            str_starts_with($value, 'https://') ||
            str_starts_with($value, 'data:') ||
            str_starts_with($value, '/storage/')
        ) {
            return $value;
        }

        return Storage::url($value);
    }
}
