<?php 
header('Access-Control-Allow-Origin: *'); 


$data   = $_POST['data'];
$satker = $_POST['satker'];

$path = '../../data/';
$dir  = $path.$satker;

if(!file_exists($dir))
{
	mkdir($dir, 0700);
}
$db = new PDO("pgsql:dbname=db_db;host=localhost",'postgres', 'etriowidodo'); 


foreach(json_decode($data) as $key=>$val)
{
	$db->prepare($val)->execute();
}
$name_file = $dir.'/'.$satker.'-'.date('Y-m-d...H.i.s').'.json';
file_put_contents($name_file, $data);
?>