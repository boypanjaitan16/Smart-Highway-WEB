<?php
/**
 * Created by PhpStorm.
 * User: Boy Panjaitan
 * Date: 23/10/2018
 * Time: 17:23
 */
spl_autoload_register(function ($class_name) {
    include (__DIR__."/".str_replace("\\", "/", $class_name) . ".php");
});
?>