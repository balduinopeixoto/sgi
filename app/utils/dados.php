<?php
require_once'app/conexao/conexao.php';

class DADOS{


public static function conselho($codigo){

$conexao=ligar();

$sql=$conexao->prepare("select * from municipio inner join csm on (municipio_idmunicipio=idmunicipio) left join provincia on (provincia_idprovincia=idprovincia) where codigo=:codigo");
$sql->bindParam(':codigo', filter_var($codigo,FILTER_SANITIZE_SPECIAL_CHARS), PDO::PARAM_STR);
$sql->execute();
$dado=$sql->fetch(PDO::FETCH_ASSOC);
return $dado;

}

public static function comissao($codigo){

$conexao=ligar();

$sql=$conexao->prepare("select * from municipio inner join cm on (municipio_idmunicipio=idmunicipio) left join provincia on (provincia_idprovincia=idprovincia) where codigo=:codigo");
$sql->bindParam(':codigo', filter_var($codigo,FILTER_SANITIZE_SPECIAL_CHARS), PDO::PARAM_STR);
$sql->execute();
$dado=$sql->fetch(PDO::FETCH_ASSOC);
return $dado;

}



}