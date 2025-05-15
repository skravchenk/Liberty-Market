<?php

require_once 'NFT.php';

class NFTManager
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function uploadImages(array $files): array
    {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $uploadDir = __DIR__ . './uploads/';
        $imagePaths = [];

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($files['tmp_name'] as $key => $tmpName) {
            $type = $files['type'][$key];
            $name = basename($files['name'][$key]);

            if (in_array($type, $allowedTypes)) {
                $uniqueName = uniqid() . '_' . $name;
                $targetPath = $uploadDir . $uniqueName;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $imagePaths[] = 'uploads/' . $uniqueName;
                }
            }
        }

        return $imagePaths;
    }

    public function saveNFT(NFT $nft): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO nfts (title, description, price, royalties, image_paths)
            VALUES (:title, :description, :price, :royalties, :image_paths)
        ");

        return $stmt->execute([
            'title' => $nft->getTitle(),
            'description' => $nft->getDescription(),
            'price' => $nft->getPrice(),
            'royalties' => $nft->getRoyalties(),
            'image_paths' => json_encode($nft->getImages()),
        ]);
    }
}
