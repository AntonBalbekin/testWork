<?php
defined('B_PROLOG_INCLUDED') || die;
require_once($_SERVER["DOCUMENT_ROOT"]."/vendor/autoload.php");
RegisterModuleDependences("pull", "setMessage", "anton.resume", "ReadMassage", "setMessage" );