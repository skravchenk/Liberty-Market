<?php

require_once '../models/NFT.php';
require_once '../controllers/NFTManager.php';

class NFTController
{
    private NFTManager $nftManager;

    public function __construct(NFTManager $nftManager)
    {
        $this->nftManager = $nftManager;
    }

    public function handleRequest(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET' && isset($_GET['id'])) {
            $this->showUpdateForm((int)$_GET['id']);
        } elseif ($method === 'POST' && isset($_POST['id'])) {
            $this->processUpdate();
        } else {
            $this->renderError('Invalid request');
        }
    }

    private function showUpdateForm(int $id): void
    {
        $nft = $this->nftManager->getNFTById($id);

        if (!$nft) {
            $this->renderError('NFT not found');
            return;
        }

        include 'update_nft_form.php';
    }

    private function processUpdate(): void
    {
        $id = (int)$_POST['id'];
        $nft = $this->nftManager->getNFTById($id);

        if (!$nft) {
            $this->renderError('NFT not found');
            return;
        }

        $nft->setTitle($_POST['title']);
        $nft->setDescription($_POST['description']);
        $nft->setPrice((float)$_POST['price']);
        $nft->setRoyalties((float)$_POST['royalties']);

        if ($this->nftManager->updateNFT($nft)) {
            header('Location: explore.php?updated=1');
            exit;
        } else {
            $this->renderError('Error updating NFT');
        }
    }

    private function renderError(string $message): void
    {
        echo "<h2>Error</h2><p>$message</p>";
        exit;
    }
}
