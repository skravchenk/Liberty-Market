<?php
class NFT
{
    private ?int $id;
    private string $title;
    private string $description;
    private float $price;
    private float $royalties;
    private array $images = [];

    public function __construct(
        ?int $id,
        string $title,
        string $description,
        float $price,
        float $royalties,
        array $images = []
    ) {
        $this->id = $id;    
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->royalties = $royalties;
        $this->images = $images;
    }

    public function getId(): ?int { return $this->id; }
    public function getTitle(): string { return $this->title; }
    public function getDescription(): string { return $this->description; }
    public function getPrice(): float { return $this->price; }
    public function getRoyalties(): float { return $this->royalties; }
    public function getImages(): array { return $this->images; }

    public function setId(int $id): void {
        $this->id = $id;
    }
}
?>