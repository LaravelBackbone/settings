<?php

namespace LaravelBackbone\Settings\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelBackbone\Settings\Traits\GetSettings;

class SettingsEloquent extends Model
{
    use GetSettings;

    public $timestamps = false;

    protected $fillable = ['key', 'value'];

    protected $table = 'lb_settings';
}
