<?php

use Glory\Class\PageManager;
use Glory\Class\ScriptManager;
use Glory\Class\StyleManager;

ScriptManager::setGlobalDevMode(true);  
ScriptManager::setThemeVersion('0.1.2'); 

StyleManager::setGlobalDevMode(true);  
StyleManager::setThemeVersion('0.1.2'); 

ScriptManager::defineFolder('/js');

StyleManager::defineFolder('assets/css');
PageManager::define('home');

ScriptManager::register();
StyleManager::register();
#PageManager::register();

