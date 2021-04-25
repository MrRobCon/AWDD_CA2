<?php require_once '../config.php'; ?>
<?php

if ($request->is_logged_in()) {
    $role = $request->session()->get("role");
    if ($role !== "customer"){
        $request->redirect("/views"."/"/$role."/home.php");
    }
}

use BookWorms\Model\Cart;

$cart = Cart::get($request);

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
      <main role="main">
      <div>
      <h1>View Cart</h1>
      <?php if ($cart->empty()){ ?>
        <p>Your shopping cart is empty. </p>
        <?php } else { ?>
        <table class="table">
            <thead>
                <tr>
                    <th> Product </th>
                    <th class="text-right">Price per item</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($cart->items as $item){
                    $total += ($item->product->price * $item->quantity);
                ?>
                <tr>
                    <td> <?= $item->product->name ?></td>
                    <td class="text-right"> <?= $item->product->price ?></td>
                    <td class="text-center">
                        <form method="post">
                            <input type="hidden" name="id" value="<?= $item->product->id ?>" />
                            <button
                            class = "btn btn-light"
                            type="submit"
                            formaction="<?= APP_URL ?>/actions/cart-remove.php"
                            >&lt;</button>
                            <span class="ml-2 mr-2"><?= $item->quantity ?></span>
                            <button
                            class="btn btn-light"
                            type="submit"
                            formaction="<?= APP_URL ?>/actions/cart-add.php"
                            >&gt;</button>
                        </form>
                    </td>
                    <td class="text-right"><?= ($item->product->price * $item->quantity) ?></td>
                </tr>
                <?php } ?>
                <tr>
                    <th colspan="3"> Total amount due </th>
                    <th class="text-right"><?= $total ?></th>
                </tr>
            </tbody>
        </table>
        <a href="<?= APP_URL ?>/views/cart-checkout.php" class="btn btn-primary"> Checkout </a>
        <?php } ?>
      </div>
      </main>
      <?php require 'include/footer.php'; ?>
    </div>
    <script src="<?= APP_URL ?>/assets/js/jquery-3.5.1.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>