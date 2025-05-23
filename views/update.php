<?php
include('../includes/header.php');
require_once '../controllers/NFTManager.php';
require_once '../controllers/NFTController.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=lb;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $nftManager = new NFTManager($pdo);
    $controller = new NFTController($nftManager);
    $controller->handleRequest();

} catch (Exception $e) {
    die('DB Error: ' . $e->getMessage());
}

require_once '../includes/footer.php';
