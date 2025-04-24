<?php 
# App/config/pages.php
use App\Glory\PageManager;

# Define your pages here:
PageManager::define('home'); # Title: 'Home', Template: 'TemplateHome.php'

PageManager::register();