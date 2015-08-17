<?php
session_start();
require_once __DIR__ . "/../../vendor/autoload.php";
require __DIR__ . "/../../config.php";

$Opauth = new Opauth($opauth_config);
