<?php

namespace LaravelBackbone\Settings\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

trait GetSettings
{
    /**
     * Store Settings
     *
     * @param $attributes
     * @param null $value
     *
     * @return void
     */
    public static function set($attributes, $value = null)
    {
        self::cacheForget();

        if (is_array($attributes)) {
            foreach ($attributes as $key => $attribute) {
                if (is_array($attribute)) {
                    $attribute = json_encode($attribute);
                }

                static::updateOrInsert([config('lb-settings.keyColumn') => $key],
                    [config('lb-settings.valueColumn') => $attribute])->get();
            }
        } else {
            if (is_array($value)) {
                $value = json_encode($value);
            }

            static::updateOrInsert([config('lb-settings.keyColumn') => $attributes],
                [config('lb-settings.valueColumn') => $value])->get();
        }
    }

    /**
     * Delete Cache
     *
     * @return void
     */
    private static function cacheForget()
    {
        if (config('lb-settings.cache')) {
            Cache::forget('lb-settings');
        }
    }

    /**
     * Setting Delete
     *
     * @param $keys
     *
     * @return integer
     */
    public static function forget($keys)
    {
        self::cacheForget();

        if (is_array($keys)) {
            $setting = static::whereIn(config('lb-settings.keyColumn'), $keys)->delete();
        } else {
            $setting = static::where(config('lb-settings.keyColumn'), $keys)->delete();
        }

        return $setting;
    }

    /**
     * Having Settings key or not
     *
     * @param $keys
     *
     * @return bool|Collection
     */
    public static function has($keys)
    {
        $settings = self::get($keys);

        if (is_array($keys)) {
            $hasSettings = [];

            foreach ($keys as $key) {
                $hasSettings[$key] = ($settings[$key] !== null || is_array($settings[$key]));
            }

            return collect($hasSettings);
        }

        if ($settings !== null) {
            return true;
        }

        return false;
    }

    /**
     * Getting Settings by key or keys
     *
     * @param null $keys
     * @param null $default
     *
     * @return Collection|null|string
     */
    public static function get($keys = null, $default = null)
    {
        if (is_array($keys)) {
            foreach ($keys as $key) {
                $setting[$key] = self::gettingExplodeValue($key, $default);
            }
        } else {
            $setting = self::gettingExplodeValue($keys, $default);
        }

        if (is_array($setting)) {
            $setting = collect($setting);
        }

        return $setting;
    }

    /**
     * For Fallback Support
     *
     * @param null $keys
     * @param null $default
     *
     * @return Collection|mixed|null|string
     */
    private static function gettingExplodeValue($keys = null, $default = null)
    {
        $explode = explode('.', $keys);
        $setting = self::getAll();

        if (!isset($setting[$explode[0]])) {
            if ($keys !== null) {
                $setting = $default;
            }
        } else {
            $setting = $setting[$explode[0]];
        }

        if ($setting !== null && count($explode) > 1) {
            unset($explode[0]);

            foreach ($explode as $element) {
                if (isset($setting[$element])) {
                    $setting = $setting[$element];
                } else {
                    $setting = $default;
                    break;
                }
            }
        }

        return $setting;
    }

    /**
     * Getting All Settings
     *
     * @return Collection|string
     */
    public static function getAll()
    {
        $getAll = config('lb-settings.cache') ? Cache::remember('lb-settings', 15, function () {
            return static::all();
        }) : static::all();

        $string = json_encode($getAll->pluck(config('lb-settings.valueColumn'), config('lb-settings.keyColumn'))->toArray());
        $string = collect(json_decode(preg_replace(['/}"/', '/"{/', '/\\\\/'], ['}', '{', ''], $string), true));

        return $string;
    }
}
