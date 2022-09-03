<?php

spl_autoload_register('classAutoloader');

function classAutoloader($className) {
    $path = "classes/";
    $extension = "-classes.php";
    $fullPath = $path . $className . $extension;

    if (!file_exists($fullPath)) {
        return false;
    }

    include_once $fullPath;
}