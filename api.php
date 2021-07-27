<?php
#Funcional 24-07-2021
//ocultar erro
error_reporting(0);

//função para pegar IP
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'DESCONHECIDA';
    return $ipaddress;
}
//observação se for ultilizar em localhost use o ip da maquina
//ex: 192.168.1.13/web/site/ip
$getIP = get_client_ip();

//Rastrear IP
$ch = curl_init();
curl_setopt_array($ch, array(
    CURLOPT_URL => "https://ipapi.co/$getIP/json/",
  	CURLOPT_RETURNTRANSFER => 1,
 	  CURLOPT_HTTPHEADER => 
	array(
		'cookie: csrftoken=dPUJpRk5POvFPCr7mUia946rNF0I2Hxyj3iUiydovAycjoliZL5YLNr5xn48UVsR',
		'referer: https://ipapi.co/'
	),
	CURLOPT_SSL_VERIFYPEER =>1
));
//armazenando informações do IP na variavel
$getIP = curl_exec($ch);


//convertendo informações json e passando elas para um objeto
$obj = json_decode($getIP);

//Status de IP erro TRUE ou FAlSE
$status = $obj->error;

//recebendo informações passadas para o objeto
$n1 = $obj->latitude;
$n2 = $obj->longitude;
$n1 = $obj->utc_offset;

//link do google maps
$link = '<a href="https://www.google.com.br/maps/@'.$n1.','.$n2.','.$n3.'/data=!3m1!1e3" target="_blank"><br>Veja no maps</a>';

//salvar só IP Publico
if ($status != 'true') {
    $file = fopen("salvo.html", "a");
    fwrite($file, "Novo acesso: <br>$getIP<br>$link<hr>");
    
    flush();
    ob_flush();
    exit();
}
exit();
