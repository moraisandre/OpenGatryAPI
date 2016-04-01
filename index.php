<?php

include_once "GatryAPI.class.php";

$gatry = new Gatry\GatryAPI;


if(isset($_GET['qtde']) && isset($_GET['onlyPromocao'])) {
	$gatry->getInfo($_GET['onlyPromocao'], $_GET['qtde']);
}else if (isset($_GET['qtde'])) {
	$gatry->getInfo("false", $_GET['qtde']);
}else if (isset($_GET['onlyPromocao'])) {
	$gatry->getInfo($_GET['onlyPromocao']);
}else{
	$gatry->getInfo();
}

?>