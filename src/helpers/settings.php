<?php

if (!function_exists('settings')) {

    /**
     * description
     *
     * @param
     * @return
     */
    function settings($key = null, $default = null) {
        if ($key === null) {
            return app(\AngusDV\LaravelSetting\Settings\Settings::class);
        }
        if($default!=null){
            app(\AngusDV\LaravelSetting\Settings\Settings::class)->put($key,$default);
            return app(\AngusDV\LaravelSetting\Settings\Settings::class)->get($key);
        }
        return app(\AngusDV\LaravelSetting\Settings\Settings::class)->get($key);
    }
}
