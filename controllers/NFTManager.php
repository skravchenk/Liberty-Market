<?php

require_once '../models/NFT.php';

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
        $uploadDir = __DIR__ . '/../uploads/';
        $imagePaths = [];

        foreach ($files['tmp_name'] as $key => $tmpName) {
            $type = $files['type'][$key];
            $name = basename($files['name'][$key]);

            if (in_array($type, $allowedTypes)) {
                $uniqueName = uniqid() . '_' . $name;
                $targetPath = $uploadDir . $uniqueName;

                if (move_uploaded_file($tmpName, $targetPath)) {
                    $imagePaths[] = '../uploads/' . $uniqueName;
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

    public function readNFTs(): array
    {
        $stmt = $this->db->query('SELECT * FROM nfts ORDER BY id DESC');

        $nfts = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $nft = new NFT(
                isset($row['id']) ? (int)$row['id'] : null,
                $row['title'],
                $row['description'],
                $row['price'],
                $row['royalties'],
                json_decode($row['image_paths'], true)
            );
            $nfts[] = $nft;
        }
        return $nfts;
    }

    public function getNFTById(int $id): ?NFT {
    $stmt = $this->db->prepare("SELECT * FROM nfts WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$row) {
        return null;
    }

    return new NFT(
        isset($row['id']) ? (int)$row['id'] : null,
        $row['title'] ?? '',
        $row['description'] ?? '',
        $row['price'] ?? 0,
        $row['royalties'] ?? 0,
        json_decode($row['image_paths'], true) ?? []
    );
}


    public function deleteNFT(int $id): void {
        $stmt = $this->db->prepare("DELETE FROM nfts WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function updateNFT(NFT $nft): bool
    {
        $stmt = $this->db->prepare("
            UPDATE nfts SET
                title = :title,
                description = :description,
                price = :price,
                royalties = :royalties
            WHERE id = :id
        ");

        return $stmt->execute([
            'title' => $nft->getTitle(),
            'description' => $nft->getDescription(),
            'price' => $nft->getPrice(),
            'royalties' => $nft->getRoyalties(),
            'id' => $nft->getId()
        ]);
    }

}
