<?php
# App/config/script.php
use App\Glory\ScriptManager;

# Configuración Global 
ScriptManager::setGlobalDevMode(true);  
ScriptManager::setThemeVersion('0.1.2'); 

# Define your script here:
ScriptManager::defineFolder('/js');



