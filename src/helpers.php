<?php

if (! function_exists('settings')) {
    /**
     * Get / set the specified setting value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string $key
     * @param  mixed $default
     * @return mixed
     */
    function settings($key = null, $default = null)
    {
        $modelName = config('lb-settings.model');
        $model = new $modelName;

        if (is_null($key)) {
            return $model;
        }

        if (is_array($key)) {
            return $model::set($key);
        }

        return $model::get($key, $default);
    }
}
