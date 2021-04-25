<?php
use BookWorms\Model\Product;
use BookWorms\Model\Image;

$products = Product::findAll();
$numProducts = count($products);
$pageSize = 10;
$numPages = ceil($numProducts / $pageSize);
?>
<table class="table" id="table-products">
    <thead>
        <tr>
            <th></th>
            <th>Title</th>
            <th>Price</th>
            <th>Category</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product) { ?>
            <tr>
            <td><input type="radio" name="product_id" value="<?= $product->id ?>" /></td>
                <td><?= $product->name ?></td>
                <td><?= $product->price ?></td>
                <td><?= $product->category ?></td>
                <td>
                  <?php
                  $image = Image::findById($product->image_id);
                  if ($image != null){
                    ?>
                    <img src="<?= APP_URL ."/". $image->path ?>" width="50px" />
                    <?php
                  }
                  ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
<button class="btn btn-warning btn-festival" formaction="<?= APP_URL ?>/product-edit.php">Edit</button>
<nav id="nav-products">
    <ul class="pagination justify-content-center">
        <li class="page-item">
            <a class="page-link" href="#" data-page="previous">
                &laquo;
            </a>
        </li>
        <?php for ($i = 0; $i < $numPages; $i++) { ?>
            <li class="page-item">
                <a class="page-link" href="#" data-page="<?= $i + 1 ?>">
                    <?= $i + 1 ?>
                </a>
            </li>
        <?php } ?>
        <li class="page-item">
            <a class="page-link" href="#" data-page="next">
                &raquo;
            </a>
        </li>
    </ul>
</nav>