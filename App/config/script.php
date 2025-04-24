<?php
# App/config/script.php
use App\Glory\ScriptManager;

# Configuración Global 
ScriptManager::setGlobalDevMode(true);  
ScriptManager::setThemeVersion('0.1.1'); 

# Define your script here:
ScriptManager::define('scroll-infinity');

ScriptManager::register();


