<?php require_once '../../../config.php';
use BookWorms\Model\Product;
use BookWorms\Model\Image;

try{
  $rules = [
    'product_id' => 'present|integer|min:1'
  ];
  $request->validate($rules);
  if (!$request->is_valid()){
    throw new Exception("Illegal Request");
  }
  $product_id = $request->input('product_id');
  $product = Product::findById($product_id);
  if($product === null){
    throw new Exception("Illegal Request parameter");
  }
}

catch (Exception $ex){
  $request->session()->set("flash_message", $ex->getMessage());
  $request->session()->set("flash_message_class","alert-warning");

  $request->redirect("/index.php");
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Product</title>

    <link href="<?= APP_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?= APP_URL ?>/assets/css/template.css" rel="stylesheet">
    <link href="<?= APP_URL ?>/assets/css/mystyle.css" rel="stylesheet">
    <link href="<?= APP_URL ?>/assets/css/form.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <?php require 'include/navbar.php'; ?>
      <main role="main">
        <div>
          <h1>Edit Product</h1>
          <form method="post" 
          action ="<?= APP_URL?> /product-update.php"
          enctype="multipart/form-data"
          >

            <input type="hidden" name="product_id" value="<?= $product->id ?>" /> 

            <div class="form-field">
              <label for="name"> Name:</label>
              <input type="text" name="name" id="name" value="<?= old('name', $product->name) ?>"  />
              <span class="error"> <?= error("name") ?></span>
            </div>

            <div class="form-field">
              <label for="description"> Description:</label>
              <textarea name="description" id="description" rows="5" ><?= old('description', $product->description) ?></textarea>
              <span class="error"> <?= error("description") ?></span>
            </div>

            <div class="form-field">
              <label for="price"> Price:</label>
              <input type="text" name="price" id="price" value="<?= old('price', $product->price) ?>"  />
              <span class="error"> <?= error("price") ?></span>
            </div>

            <div class="form-field">
              <label for="category"> Category:</label>
              <input type="date" name="category" id="category" value="<?= old('category', $product->category) ?>"  />
              <span class="error"> <?= error("category") ?></span>
            </div>

            <div class="form-field">
              <label for="color"> Color:</label>
              <input type="date" name="color" id="color" value="<?= old('color', $product->color) ?>"  />
              <span class="error"> <?= error("color") ?></span>
            </div>

            <div class="form-field">
              <label> Profile Image: </label>
              <?php
              $image = Image::findById($product->image_id);
              if ($image != null){
                ?>
                <img src="<?= APP_URL . "/" . $image->path ?>" width="150px" />
                <?php
              }
              ?>
              <input type="file" name="profile" id="profile"/>
              <span class="error"> <?= error("profile") ?></span>
            </div>
            <br>
            <div class="form-field">
              <label></label>
              <a class="btn btn-default" href="<?= APP_URL?> /index.php"> Cancel </a>
              <button type = "submit" class="btn btn-primary">Edit</button>
            </div>
          </form>
        </div>
      </main>
      <?php require 'include/footer.php'; ?>
    </div>
    <script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/products.js"></script>
  </body>
</html>
