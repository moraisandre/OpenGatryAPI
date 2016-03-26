<?php
namespace Gatry;
/**
 * @author André Morais
 * @version 0.1
 * @package Gatry
*/

class Promocoes
{
	public $link;

	public $ids;
	public $names;
	public $prices;
	public $images;
	public $links;
	public $userLinks;
	public $userImages;
	public $stores;
	public $likes;
	public $comments;
	public $dates;
	public $moreinfos;

	public function __construct()
	{
		$this->link = "http://gatry.com";

		$html = file_get_contents($this->link);

		$this->ids = $this->getArray($html, '/<article id="promocao-([\w\W]*?)itemtype="http:\/\/schema.org\/Product">/', '/id="promocao-([^<]*)" class/'); //Id
		$this->names = $this->getArray($html, '/<h3 itemprop="name">([\w\W]*?)<\/h3>/', '/>([^<]*)<\/a/'); //Name
		$this->prices = $this->getArray($html, '/<span itemprop="price">([\w\W]*?)<\/span>/', '/>([^<]*)</'); //Price
		$this->images = $this->getArray($html, '/<div class="imagem">([\w\W]*?)<\/div>/', '/src="([^"]+)"/'); //Image
		$this->links = $this->getArray($html, '/<h3 itemprop="name">([\w\W]*?)<\/h3>/', '/<a[^>]* href="([^"]*)"/'); //Link
		$this->userLinks = $this->getArray($html, '/<p class="usuario([\w\W]*?)<\/p>/', '/<a[^>]* href="([^"]*)"/', true); //User Link
		$this->userImages = $this->getArray($html, '/<p class="usuario([\w\W]*?)<\/p>/', '/<img[^>]* src="([^"]*)"/'); //User Image 
		$this->stores = $this->getArray($html, '/Ir para <\/span>([\w\W]*?)<\/a>/', '/>([^<]*)</'); //Store Name
		$this->likes = $this->getArray($html, '/\+ <span([\w\W]*?)<\/span>/', '/>([^<]*)</'); //Likes
		$this->comments = $this->getArray($html, '/#comentarios([\w\W]*?)>([\w\W]*?)<span>Comentários<\/span>/', '/>([^<]*)</'); //Comments
		$this->dates = $this->getArray($html, '/data_postado([\w\W]*?)<\/span>/', '/>([^<]*)</'); //Post Date
		$this->moreinfos = $this->getArray($html, '/[0-9]<\/span><\/a><a ([\w\W]*?)mais hidden-xs/', '/<a[^>]* href="([^"]*)"/', true); //More info

		//print_r($this->ids);
	}

	public function getArray($html, $pattern1, $pattern2, $addLink = false)
	{
		
		$htmlDivsArray = Parser::parse($html, $pattern1, true);
		
		for ($i=0; $i < count($htmlDivsArray); $i++) {
			if($addLink){
				$array[$i] = $this->link.trim(Parser::parse($htmlDivsArray[$i][0],$pattern2));
			}else{
				$array[$i] = trim(Parser::parse($htmlDivsArray[$i][0],$pattern2));
			}
		}

		return $array;		
	}

	public function getJson()
	{
		//header('Content-type:application/json; charset=ISO-8859-1');
		header('Content-type:application/json; charset=UTF-8');

		echo "{";

		echo "\"results\":[\n";

		for ($i=0; $i < count($this->ids); $i++) {

			echo "\n{\n";
			Promocoes::echoJson("id",$this->ids[$i]);
			Promocoes::echoJson("name",$this->names[$i]);
			Promocoes::echoJson("price",$this->prices[$i]);
			Promocoes::echoJson("image",$this->images[$i]);
			Promocoes::echoJson("link",$this->links[$i]);
			Promocoes::echoJson("userLink",$this->userLinks[$i]);
			Promocoes::echoJson("userImage",$this->userImages[$i]);
			Promocoes::echoJson("store",$this->stores[$i]);
			Promocoes::echoJson("likes",$this->likes[$i]);
			Promocoes::echoJson("comments",$this->comments[$i]);
			Promocoes::echoJson("date",$this->dates[$i]);
			Promocoes::echoJson("moreinfo",$this->moreinfos[$i], true);

			if ($i == count($this->ids)-1) {
				echo "}";
			}else{
				echo "},";
			}
		}
		echo "],";

		// for ($i=0; $i < count($this->ids); $i++) {
		// 	echo "\"".$this->ids[$i]."\":{";

		// 	Promocoes::echoJson("name",$this->names[$i]);
		// 	Promocoes::echoJson("price",$this->prices[$i]);
		// 	Promocoes::echoJson("image",$this->images[$i]);
		// 	Promocoes::echoJson("link",$this->links[$i]);
		// 	Promocoes::echoJson("userLink",$this->userLinks[$i]);
		// 	Promocoes::echoJson("userImage",$this->userImages[$i]);
		// 	Promocoes::echoJson("store",$this->stores[$i]);
		// 	Promocoes::echoJson("likes",$this->likes[$i]);
		// 	Promocoes::echoJson("comments",$this->comments[$i]);
		// 	Promocoes::echoJson("date",$this->dates[$i]);
		// 	Promocoes::echoJson("moreinfo",$this->moreinfos[$i], true);

		// 	if ($i == count($this->ids)) {
		// 		echo "}";
		// 	}else{
		// 		echo "},";
		// 	}
		// }
			
			echo "\"Author\":\"www.andremorais.com.br\"";
		echo "}";		
	}

	public function echoJson($key, $value, $isLastTag = false){
		
		if($isLastTag){
			echo "\"".$key."\":\"".Promocoes::removeSpecialCharacters($value)."\"\n";
		}else{
			echo "\"".$key."\":\"".Promocoes::removeSpecialCharacters($value)."\",\n";
		}

	}

	public function removeSpecialCharacters($value){
		$value = str_replace("\"", "\\\"", $value);

		return $value;
	}

}

class Parser {
	public static function parse($source, $pattern, $all = false) {
		if($all) {
			if(preg_match_all($pattern, $source, $matches, PREG_SET_ORDER))
				return $matches;
		} else {
			if(preg_match($pattern, $source, $matches))
				return $matches[1];
		}
		return false;
	}
	public static function doesExist($value, $expected, $failMsg = "Could not find.") {
		// echo "DEBUG: Value: $value Expected: $expected";
		return ($value === $expected) ? $value : exit($failMsg);
	}
}