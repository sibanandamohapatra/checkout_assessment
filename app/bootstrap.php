<?php
    // Load config main file
    require_once 'config/main.php';

    // Autoload all core libraries
    spl_autoload_register(function($className){
        require_once 'libraries/' . $className . '.php';
    });