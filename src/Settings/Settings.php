<?php

namespace AngusDV\LaravelSetting\Settings;

use AngusDV\LaravelSetting\Models\Setting;
use ArrayAccess;
use Countable;


class Settings  implements ArrayAccess, Countable
{
    /** @var string */
    protected $fileName;

    /**
     * @param string $fileName
     * @param array|null $values
     *
     * @return $this
     */
    public static function make( array $values = null)
    {
        $valuestore = (new static());

        if (! is_null($values)) {
            $valuestore->put($values);
        }

        return $valuestore;
    }

    protected function __construct()
    {
        return $this;
    }



    /**
     * Put a value in the store.
     *
     * @param string|array    $name
     * @param string|int|null $value
     *
     * @return $this
     */
    public static function put($name, $value = null)
    {
        if ($name == []) {
            return (new static());
        }

        $newValues = $name;

        if (! is_array($name)) {
            $newValues = [$name => $value];
        }

        $newContent = array_merge((new static())->all(), $newValues);

        (new static())->setContent($newContent);

        return (new static());
    }

    /**
     * Push a new value into an array.
     *
     * @param string $name
     * @param $pushValue
     *
     * @return $this
     */
    public static function push(string $name, $pushValue)
    {
        if (! is_array($pushValue)) {
            $pushValue = [$pushValue];
        }

        if (! (new static())->has($name)) {
            (new static())->put($name, $pushValue);

            return (new static());
        }

        $oldValue = (new static())->get($name);

        if (! is_array($oldValue)) {
            $oldValue = [$oldValue];
        }

        $newValue = array_merge($oldValue, $pushValue);

        (new static())->put($name, $newValue);

        return (new static());
    }

    /**
     * Prepend a new value in an array.
     *
     * @param string $name
     * @param $prependValue
     *
     * @return $this
     */
    public function prepend(string $name, $prependValue)
    {
        if (! is_array($prependValue)) {
            $prependValue = [$prependValue];
        }

        if (! $this->has($name)) {
            $this->put($name, $prependValue);

            return $this;
        }

        $oldValue = $this->get($name);

        if (! is_array($oldValue)) {
            $oldValue = [$oldValue];
        }

        $newValue = array_merge($prependValue, $oldValue);

        $this->put($name, $newValue);

        return $this;
    }

    /**
     * Get a value from the store.
     *
     * @param string $name
     * @param $default
     *
     * @return null|string|array
     */
    public static function get(string $name, $default = null)
    {
        $all = (new static())->all();

        if (! array_key_exists($name, $all)) {
            return $default;
        }

        return $all[$name];
    }

    /*
     * Determine if the store has a value for the given name.
     */
    public static function has(string $name): bool
    {
        return array_key_exists($name, (new static())->all());
    }

    /**
     * Get all values from the store.
     *
     * @return array
     */


    /**
     * Get all keys starting with a given string from the store.
     *
     * @param string $startingWith
     *
     * @return array
     */
    public static function allStartingWith(string $startingWith = ''): array
    {
        $values = (new static())->all();

        if ($startingWith === '') {
            return $values;
        }

        return (new static())->filterKeysStartingWith($values, $startingWith);
    }

    public static function all()
    {
        $settings='';
        if(Setting::count()==0){
            $settings=new Setting();
            $settings->settings=json_encode([]);
            $settings->save();
        }else{
            $settings=Setting::first();
        }

        return json_decode($settings->settings??'',true)??[];
    }

    /**
     * Forget a value from the store.
     *
     * @param string $key
     *
     * @return $this
     */
    public static function forget(string $key)
    {
        $newContent = (new static())->all();

        unset($newContent[$key]);

        (new static())->setContent($newContent);

        return (new static());
    }

    /**
     * Flush all values from the store.
     *
     * @return $this
     */
    public static function flush()
    {
        return (new static())->setContent([]);
    }

    /**
     * Flush all values which keys start with a given string.
     *
     * @param string $startingWith
     *
     * @return $this
     */
    public static function flushStartingWith(string $startingWith = '')
    {
        $newContent = [];

        if ($startingWith !== '') {
            $newContent = (new static())->filterKeysNotStartingWith((new static())->all(), $startingWith);
        }

        return (new static())->setContent($newContent);
    }

    /**
     * Get and forget a value from the store.
     *
     * @param string $name
     *
     * @return null|string
     */
    public static function pull(string $name)
    {
        $value = (new static())->get($name);

        (new static())->forget($name);

        return $value;
    }

    /**
     * Increment a value from the store.
     *
     * @param string $name
     * @param int    $by
     *
     * @return int|null|string
     */
    public static function increment(string $name, int $by = 1)
    {
        $currentValue = (new static())->get($name) ?? 0;

        $newValue = $currentValue + $by;

        (new static())->put($name, $newValue);

        return $newValue;
    }

    /**
     * Decrement a value from the store.
     *
     * @param string $name
     * @param int    $by
     *
     * @return int|null|string
     */
    public static function decrement(string $name, int $by = 1)
    {
        return (new static())->increment($name, $by * -1);
    }

    /**
     * Whether a offset exists.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * Offset to retrieve.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset
     *
     * @return mixed
     */
    public function offsetGet($offset): mixed
    {
        return $this->get($offset);
    }

    /**
     * Offset to set.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value): void
    {
        $this->put($offset, $value);
    }

    /**
     * Offset to unset.
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset): void
    {
        $this->forget($offset);
    }

    /**
     * Count elements.
     *
     * @link http://php.net/manual/en/countable.count.php
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->all());
    }

    protected static function filterKeysStartingWith(array $values, string $startsWith): array
    {
        return array_filter($values, function ($key) use ($startsWith) {
            return (new static())->startsWith($key, $startsWith);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected static function filterKeysNotStartingWith(array $values, string $startsWith): array
    {
        return array_filter($values, function ($key) use ($startsWith) {
            return ! (new static())->startsWith($key, $startsWith);
        }, ARRAY_FILTER_USE_KEY);
    }

    protected  function startsWith(string $haystack, string $needle): bool
    {
        return substr($haystack, 0, strlen($needle)) === $needle;
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    protected function setContent(array $values)
    {
        $settings='';
        if(Setting::count()==0){
            $settings=new Setting();
        }else{
            $settings=Setting::first();
        }

        $settings->settings= json_encode($values);
        $settings->save();
        return $this;
    }
}
