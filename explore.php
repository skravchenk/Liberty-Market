<?php
require_once 'includes/header.php';
require_once 'NFTManager.php';
require_once 'NFT.php';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=lb;charset=utf8', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $nftManager = new NFTManager($pdo);
    $nfts = $nftManager->readNFTs();
} catch (Exception $e) {
    die('DB Error: ' . $e->getMessage());
}
?>

<div class="page-heading">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h6>Liberty NFT Market</h6>
        <h2>Discover Some Top Items</h2>
        <span>Home > <a href="#">Explore</a></span>
      </div>
    </div>
  </div>

  <div class="featured-explore">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-features owl-carousel">
            <div class="item">
              <div class="thumb">
                <img src="assets/images/featured-01.jpg" alt="" style="border-radius: 20px;">
                <div class="hover-effect">
                  <div class="content">
                    <h4>Triple Mutant Ape Bored</h4>
                    <span class="author">
                      <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                      <h6>Liberty Artist<br><a href="#">@libertyart</a></h6>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="thumb">
                <img src="assets/images/featured-02.jpg" alt="" style="border-radius: 20px;">
                <div class="hover-effect">
                  <div class="content">
                    <h4>Bored Ape Kennel Club</h4>
                    <span class="author">
                      <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                      <h6>Liberty Artist<br><a href="#">@libertyart</a></h6>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="item">
              <div class="thumb">
                <img src="assets/images/featured-03.jpg" alt="" style="border-radius: 20px;">
                <div class="hover-effect">
                  <div class="content">
                    <h4>Genesis Club by KMT</h4>
                    <span class="author">
                      <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                      <h6>Liberty Artist<br><a href="#">@libertyart</a></h6>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="discover-items">
  <div class="container">
    <div class="row">
      <div class="col-lg-5">
        <div class="section-heading">
          <div class="line-dec"></div>
          <h2>Discover Some Of Our <em>Items</em>.</h2>
        </div>
      </div>
      <div class="col-lg-7">
        <form id="search-form" name="gs" method="submit" role="search" action="#">
          <div class="row">
            <div class="col-lg-4">
              <fieldset>
                <input type="text" name="keyword" class="searchText" placeholder="Type Something..." autocomplete="on" required>
              </fieldset>
            </div>
            <div class="col-lg-3">
              <fieldset>
                <select name="Category" class="form-select">
                  <option selected>All Categories</option>
                  <option value="Music">Music</option>
                  <option value="Digital">Digital</option>
                  <option value="Blockchain">Blockchain</option>
                  <option value="Virtual">Virtual</option>
                </select>
              </fieldset>
            </div>
            <div class="col-lg-3">
              <fieldset>
                <select name="Price" class="form-select">
                  <option selected>Available</option>
                  <option value="Ending-Soon">Ending Soon</option>
                  <option value="Coming-Soon">Coming Soon</option>
                  <option value="Closed">Closed</option>
                </select>
              </fieldset>
            </div>
            <div class="col-lg-2">                        
              <fieldset>
                <button class="main-button">Search</button>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-lg-12">
        <div class="owl-features owl-carousel">
          <?php foreach ($nfts as $nft): ?>
            <div class="item">
              <div class="thumb">
                <img src="<?= htmlspecialchars($nft->getImages()[0]) ?>" alt="" style="border-radius: 20px;">
                <div class="hover-effect">
                  <div class="content">
                    <h4><?= htmlspecialchars($nft->getTitle()) ?></h4>
                    <span class="author">
                      <img src="assets/images/author.jpg" alt="" style="max-width: 50px; max-height: 50px; border-radius: 50%;">
                      <h6>Liberty Artist<br><a href="#">@libertyart</a></h6>
                    </span>
                    <div class="price">
                      <span>Price<br><strong><?= number_format($nft->getPrice(), 2) ?> ETH</strong></span>
                    </div>
                    <div class="main-button">
                      <a href="details.php?id=<?= urlencode($nft->getTitle()) ?>">View Details</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>
