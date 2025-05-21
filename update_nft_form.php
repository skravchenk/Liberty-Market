<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <h2>Update NFT #<?= htmlspecialchars($nft->getId()) ?></h2>
        <span>Home > <a href="explore.php">Explore</a> > Update NFT</span>
      </div>
    </div>
  </div>
</div>

<section class="section-padding">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-6">
      <div class="update-nft-wrapper">  
      <form action="update.php" method="POST" class="bg-light p-4 rounded shadow-sm">
          <input type="hidden" name="id" value="<?= htmlspecialchars($nft->getId()) ?>">

          <div class="mb-3">
            <label for="title" class="form-label fw-bold">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($nft->getTitle()) ?>" required>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label fw-bold">Description</label>
            <textarea id="description" name="description" class="form-control" rows="5" required><?= htmlspecialchars($nft->getDescription()) ?></textarea>
          </div>

          <div class="mb-3">
            <label for="price" class="form-label fw-bold">Price (ETH)</label>
            <input type="number" id="price" step="0.01" name="price" class="form-control" value="<?= htmlspecialchars($nft->getPrice()) ?>" required>
          </div>

          <div class="mb-3">
            <label for="royalties" class="form-label fw-bold">Royalties (%)</label>
            <input type="number" id="royalties" step="0.01" name="royalties" class="form-control" value="<?= htmlspecialchars($nft->getRoyalties()) ?>" required>
          </div>

          <button type="submit" class="btn btn-primary w-100">Update NFT</button>
        </form>
      </div>
      </div>
    </div>
  </div>
</section>
