<?php

include_once "GatryAPI.class.php";

$promo = new Gatry\Promocoes;

if ($_GET['loadMorePromo'] == "true"){
	$promo->getMorePromo($_GET['qtde']);
}else{
	$promo->getPromo();
}



//echo "END";


?>