<?php  class NFT
{
    private string $title;
    private string $description;
    private float $price;
    private float $royalties;
    private array $images = [];

    public function __construct(
        string $title,
        string $description,
        float $price,
        float $royalties,
        array $images = []
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->royalties = $royalties;
        $this->images = $images;
    }

    public function getTitle(): string { return $this->title; }
    public function getDescription(): string { return $this->description; }
    public function getPrice(): float { return $this->price; }
    public function getRoyalties(): float { return $this->royalties; }
    public function getImages(): array { return $this->images; }

}
?>