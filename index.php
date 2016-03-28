<?php

include_once "GatryAPI.class.php";

$promo = new Gatry\Promocoes;


if(isset($_GET['qtde'])) {
	$promo->getPromo($_GET['qtde']);
}else{
	$promo->getPromo();
}

?>