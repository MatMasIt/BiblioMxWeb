<?php
function cache_get($isbn){
	if(!file_exists("isbnCacheImg.json")) return false;
	$data = json_decode(file_get_contents("isbnCacheImg.json"),true);
    if(!$data) return false;
    $res = $data[$isbn];
    if(!$res) return false;
    if($res["time"] + $GLOBALS["imageISBNCache"] < time()) return false;
    return $res["url"];
}
function cache_set($isbn,$url){
	if(file_exists("2/isbnCacheImg.json")){
    	$data = json_decode(file_get_contents("isbnCacheImg.json"),true)?:[];
    }
    else{
    	$data = [];
    }
    $data[$isbn] = ["time"=>time(),"url"=>$url];
    file_put_contents("2/isbnCacheImg.json", json_encode($data));
}
function isbnImage($isbn){
	$url = cache_get($isbn);
    if($url) return $url;
	$curlSES=curl_init(); 
	curl_setopt($curlSES,CURLOPT_URL,"https://www.googleapis.com/books/v1/volumes?q=isbn:".urlencode($isbn));
	curl_setopt($curlSES,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curlSES,CURLOPT_HEADER, false); 
	$result=curl_exec($curlSES);
	curl_close($curlSES);
	$data=json_decode($result,true);
    if(!$data) return "books.png";
    $images=$data["items"][0]["volumeInfo"]["imageLinks"];
    $lak = array_keys($images);
    $le = $lak[count($lak)-1];
    $url = $images[$le]?: "books.png";
    cache_set($isbn,$url);
    return $url;
}
?>
