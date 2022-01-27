<?php 
require_once(__DIR__. '/../../Controllers/GeneralController.php');
require_once(__DIR__. '/../../Controllers/PlayerController.php');
$Player = new PlayerController();
$controller = new GeneralController();

$controller->checking();

$Player->logout();

$controller->goBack();


?>