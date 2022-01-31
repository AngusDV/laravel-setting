<?php

if (!function_exists('settings')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function settings($key = null, $default = null) {
        $setting = app(\AngusDV\LaravelSetting\Settings\Settings::class);

        if (is_null($key)) {
            return $setting;
        }

        if (is_array($key)) {
            return $setting->put($key);
        }

        return $setting->get($key, value($default));
      
    }
}
