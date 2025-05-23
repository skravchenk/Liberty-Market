<?php
require_once '../controllers/NFTManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int) $_POST['id'];

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=lb;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $nftManager = new NFTManager($pdo);
        $nftManager->deleteNFT($id);

        header('Location: explore.php?deleted=1');
        exit;
    } catch (Exception $e) {
        die('Error deleting NFT: ' . $e->getMessage());
    }
} else {
    die('Invalid request.');
}
