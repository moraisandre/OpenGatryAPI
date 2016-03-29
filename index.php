<?php

include_once "GatryAPI.class.php";

$promo = new Gatry\GatryAPI;


if(isset($_GET['qtde']) && isset($_GET['onlyPromocao'])) {
	$promo->getInfo($_GET['onlyPromocao'], $_GET['qtde']);
}else if (isset($_GET['qtde'])) {
	$promo->getInfo("false", $_GET['qtde']);
}else if (isset($_GET['onlyPromocao'])) {
	$promo->getInfo($_GET['onlyPromocao']);
}else{
	$promo->getInfo();
}

?>