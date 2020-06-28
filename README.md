# Laravel Backbone Settings
Easy Persistent Settings Management for Laravel.

## Installation

Settings is a Laravel package. You can install it via Composer. Run this command in your terminal from your project directory:

```sh
composer require laravel-backbone/settings
```
Now run this command in your terminal to publish this package resources:

```
php artisan vendor:publish --provider="LaravelBackbone\Settings\Providers\SettingsServiceProvider"
```
If you run `vendor:publish` then you have to add below code in your settings model 
```php
protected $table = 'lb_settings'; // you can change your database table name.
public $timestamps = false;
``` 

## Use Traits
Use `GetSettings` traits in your settings model.

## API List
- [all](https://github.com/LaravelBackbone/settings#all)
- [set](https://github.com/LaravelBackbone/settings#set)
- [get](https://github.com/LaravelBackbone/settings#get)
- [has](https://github.com/LaravelBackbone/settings#has)
- [forget](https://github.com/LaravelBackbone/settings#current)

### all

For getting all settings value paired by key you can use `all` method.

```php
YourSettingModel::all(); // return collection
```

### set

For set value you can use `set` method.

```php
YourSettingModel::set('key', 'value'); // return null
```
Multiple data store by key
```php
YourSettingModel::set(['key1' => 'value', 'key2' => ['subkey2' => 'value-of-subkey2'] ]); // return null
```

### get

For get value you can use `get` method.

```php
YourSettingModel::get('key'); // return collection or string or null
```
Fallback Support:
```php
YourSettingModel::get('key2.subkey2'); // return collection or string or null
```
You can also get all setting value
```php
YourSettingModel::get(); // return collection
```

### has 
For checking key exists or not you can use `has` method.

```php
YourSettingModel::has('key'); // return bool
```
Multiple key Forget:
```php
YourSettingModel::has(['key1', 'key2']); // return collection
```

### forget

For delete key you can use `forget` method.

```php
YourSettingModel::forget('key'); // return integer 0 or 1
```
Multiple key Forget:
```php
YourSettingModel::forget(['key1', 'key2']); // return integer - how many key successfully delete.
```

## Helper
Get / set the specified setting value. If an array is passed as the key, we will assume you want to set an array of values.

```
$value = settings('app.timezone');
$value = settings('app.timezone', $default);
```
You may set settings variables by passing an array of key / value pairs:
```
settings(['app.debug' => true]);
```

