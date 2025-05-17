<?php
require_once 'includes/header.php';
require_once 'NFT.php';
require_once 'NFTManager.php';
require_once 'Database.php';

$database = new Database();
$pdo = $database->getConnection();

$manager = new NFTManager($pdo);
$uploadSuccess = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = (float)$_POST['price'];
        $royalties = (float)$_POST['royalities'];

        $images = $manager->uploadImages($_FILES['myfiles']);

        $nft = new NFT(null, $title, $description, $price, $royalties, $images);
        if ($manager->saveNFT($nft)) {
            $uploadSuccess = true;
        } else {
            $error = 'Ошибка при сохранении NFT в базу данных.';
        }
    } catch (Exception $e) {
        $error = 'Произошла ошибка: ' . $e->getMessage();
    }
}
?>

<div class="page-heading normal-space">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h6>Liberty NFT Market</h6>
        <h2>Create Your NFT Now.</h2>
        <span>Home > <a href="#">Create Yours</a></span>
        <div class="buttons">
          <div class="main-button">
            <a href="explore.php">Explore Our Items</a>
          </div>
          <div class="border-button">
            <a href="create.php">Create Your NFT</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="item-details-page">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-heading">
          <div class="line-dec"></div>
          <h2>Apply For <em>Your Item</em> Here.</h2>
        </div>
      </div>

      <div class="col-lg-12">
        <?php if ($uploadSuccess): ?>
          <div style="color: green; margin-bottom: 10px;">Файлы успешно загружены!</div>
        <?php elseif (!empty($error)): ?>
          <div style="color: red; margin-bottom: 10px;"><?= $error ?></div>
        <?php endif; ?>

        <form id="contact" action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-lg-4">
              <fieldset>
                <label for="title">Item Title</label>
                <input type="text" name="title" id="title" placeholder="Ex. Lyon King" required>
              </fieldset>
            </div>
            <div class="col-lg-4">
              <fieldset>
                <label for="description">Description For Item</label>
                <input type="text" name="description" id="description" placeholder="Give us your idea" required>
              </fieldset>
            </div>
            <div class="col-lg-6">
              <fieldset>
                <label for="price">Price Of Item</label>
                <input type="text" name="price" id="price" placeholder="Ex. 0.06 ETH" required>
              </fieldset>
            </div>
            <div class="col-lg-6">
              <fieldset>
                <label for="royalities">Royalties</label>
                <input type="text" name="royalities" id="royalities" placeholder="1-25%" required>
              </fieldset>
            </div>
            <div class="col-lg-4">
              <fieldset>
                <label for="file">Your File</label>
                <input type="file" id="file" name="myfiles[]" multiple required />
              </fieldset>
            </div>
            <div class="col-lg-8">
              <fieldset>
                <button type="submit" id="form-submit" class="orange-button">Submit Your Applying</button>
              </fieldset>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>
