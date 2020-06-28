<?php

return [

    /*
    |--------------------------------------------------------------------------
    | For Cache Enable or Disable
    |--------------------------------------------------------------------------
    | Supported: "true", "false"
    |
    */

    'cache' => true,

    /*
    |--------------------------------------------------------------------------
    | Setting model name
    |--------------------------------------------------------------------------
    | Write your settings model name with namespace.
    |
    */

    'model' => LaravelBackbone\Settings\Models\SettingsEloquent::class,

    /*
    |--------------------------------------------------------------------------
    | Settings Key Column and Value Column
    |--------------------------------------------------------------------------
    | If you want to use custom column names in database store you could set
    | them in this configuration
    |
    */

    'keyColumn' => 'key',
    'valueColumn' => 'value',
];
