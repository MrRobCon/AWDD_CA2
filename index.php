<?php require_once 'config.php'; ?>
<?php 
use BookWorms\Model\Product;
use BookWorms\Model\Image;

try{
  $products = Product::findAll();
}
catch (Exception $ex){
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class", "alert-warning");
  $products = [];
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DogChamp</title>

    <link href="<?= APP_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= APP_URL ?>/assets/css/template.css" rel="stylesheet">
    <link href="<?= APP_URL ?>/assets/css/mystyle.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <?php require 'include/navbar.php'; ?>
      <?php require 'include/flash.php'; ?>
      <img class="d-block w-100" src="assets/img/slider6.jpg">
          <br>
          <br>
      <main role="main">
        <div>
          <h1>Our products</h1>
          <div class="row">
          <?php foreach ($products as $product) { ?>
            <div class="col mb-4">
              <div class="card">
                <div class="card-body">
                <?php
                  $image = Image::findById($product->image_id);
                  if ($image != null){
                    ?>
                    <img class="card-img-top" src="<?= APP_URL ."/". $image->path ?>" />
                    <?php
                  }
                  ?>
                  <h5 class="card-title"><?= $product->name ?></h5>
                  <p class="card-text"><?= get_words($product->description, 30) ?></p>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Price: <?= $product->price ?></li>
                  <li class="list-group-item">Category: <?= $product->category ?></li>
                  <li class="list-group-item">Color: <?= $product->color ?></li>
                </ul>
                <li class="list-group-item">
                  <form method="post" action="<?=APP_URL ?>/actions/cart-add.php">
                  <input type="hidden" name="id" value="<?=$product->id ?>"/>
                  <button type="submit" class="btn btn-primary"> Add to cart </button>
                  </form>
                  <i class="heart fa fa-heart-o fa-2x"></i>
                </li>
              </div>
            </div>
          <?php } ?>
          </div>
        </div>
      </main>
      <?php require 'include/footer.php'; ?>
    </div>
    <script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script>

    $(".heart.fa").click(function() {
      $(this).toggleClass("fa-heart fa-heart-o");
    });

    </script>
  </body>
</html>
