<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
session_start();

// Alle Klassen inkludieren
foreach(glob("Framework/*.php") as $file)
	include $file;
	
foreach(glob("Controllers/*.php") as $file)
	include $file;

foreach(glob("Models/*.php") as $file)
	include $file;

// Controller und Methode aus URL lesen
if(isset($_GET["page"]))
	$page = $_GET["page"];
else
	$page = "Start";
	
if(isset($_GET["action"]))
	$action = $_GET["action"];
else
	$action = "Index";
	
try
{
	$class = new ReflectionClass($page . "Controller");
	$method = $class->getMethod($action);
}
catch(Exception $e)
{
	$class = new ReflectionClass("BaseController");
	$method = $class->getMethod("Error404");
}

// Parameter mappen
$parameters = $method->getParameters();
$parameterValues = array();
$pandora = array_merge($_GET, $_POST);
foreach($parameters as $parameter)
{
	if($parameter->isDefaultValueAvailable() && !isset($pandora[$parameter->getName()]))
		$parameterValues[] = $parameter->getDefaultValue();
	else if(!isset($pandora[$parameter->getName()]))
		$parameterValues[] = NULL;
	else
		$parameterValues[] = $pandora[$parameter->getName()];
}

// Klasse erstellen und Methode mit oben generierten Parameters invoken
$obj = $class->newInstance();
echo $method->invokeArgs($obj, $parameterValues);