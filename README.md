# AngusDV Laravel Settings



This package makes it easy to store and retrieve some loose values. Stored values are saved as a json file.
```
Supoort Laravel 8 and PHP 8
```
It can be used like this:

```php

settings('key'); // Returns 'value'

settings()->get('key'); // Returns 'value'

settings()->has('key'); // Returns true

// Specify a default value for when the specified key does not exist
settings()->get('non existing key', 'default') // Returns 'default'

settings()->put('anotherKey', 'anotherValue');

settings('anotherKey', 'anotherValue');

settings(['anotherKey'=> 'anotherValue']);

// Put multiple items in one go
settings()->put(['ringo' => 'drums', 'paul' => 'bass']);

settings()->all(); // Returns an array with all items

settings()->forget('key'); // Removes the item

settings()->flush(); // Empty the entire valuestore

settings()->flushStartingWith('somekey'); // remove all items whose keys start with "somekey"

settings()->increment('number'); // settings()->get('number') will return 1 
settings()->increment('number'); // settings()->get('number') will return 2
settings()->increment('number', 3); // settings()->get('number') will return 5

```
## Installation

You can install the package via composer:

``` bash
composer require angus-dv/laravel-setting
```
and for register service provider:


```angular2html
 'providers' => [
   AngusDV\LaravelSetting\LaravelSettingServiceProvider::class,
 ],
```
and run migration to create the database table:
```angular2html
php artisan migrate
```
## Usage

You can call the following methods on the `settings()`

### put
```php
/**
 * Put a value in the store.
 *
 * @param string|array $name
 * @param string|int|null $value
 * 
 * @return $this
 */
public function put($name, $value = null)
```

### get

```php
/**
 * Get a value from the store.
 *
 * @param string $name
 *
 * @return null|string
 */
public function get(string $name)
```

### has

```php
/*
 * Determine if the store has a value for the given name.
 */
public function has(string $name) : bool
```

### all
```php
/**
 * Get all values from the store.
 *
 * @return array
 */
public function all() : array
```

### allStartingWith
```php
/**
 * Get all values from the store which keys start with the given string.
 *
 * @param string $startingWith
 *
 * @return array
*/
public function allStartingWith(string $startingWith = '') : array
```

### forget
```php
/**
 * Forget a value from the store.
 *
 * @param string $key
 *
 * @return $this
 */
public function forget(string $key)
```

### flush
```php
/**
 * Flush all values from the store.
 *
 * @return $this
 */
 public function flush()
```

### flushStartingWith
```php
/**
 * Flush all values from the store which keys start with the specified value.
 *
 * @param string $startingWith
 *
 * @return $this
 */
 public function flushStartingWith(string $startingWith)
```

### pull
```php
/**
 * Get and forget a value from the store.
 *
 * @param string $name 
 *
 * @return null|string
 */
public function pull(string $name)
```

### increment
```php
/**
 * Increment a value from the store.
 *
 * @param string $name
 * @param int $by
 *
 * @return int|null|string
 */
 public function increment(string $name, int $by = 1)
```

### decrement
```php
/**
 * Decrement a value from the store.
 *
 * @param string $name
 * @param int $by
 *
 * @return int|null|string
 */
 public function decrement(string $name, int $by = 1)
```

## push
```php
/**
 * Push a new value into an array.
 *
 * @param string $name
 * @param $pushValue
 *
 * @return $this
 */
public function push(string $name, $pushValue)
```

## prepend
```php
/**
 * Prepend a new value into an array.
 *
 * @param string $name
 * @param $prependValue
 *
 * @return $this
 */
public function prepend(string $name, $prependValue)
```

## count
```php
/**
 * Count elements.
 *
 * @return int
 */
public function count()
```


## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email hsmsender1370@gmail.com instead of using the issue tracker.



## License

The MIT License (MIT)
