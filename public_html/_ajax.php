<?php 

require_once(__DIR__ . '/../config/config.php');

$app = new \MyApp\Controller\_Ajax();

$rs = $app->run();

header('Content-Type: application/json; charset=utf-8');
echo json_encode($rs);
?>
