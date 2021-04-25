
<nav class="navbar navbar-expand-md navbar-light sticky-top">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#div-navbar-items" aria-controls="div-navbar-items" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="div-navbar-items">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="<?= APP_URL ?>/views/admin/home.php">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= APP_URL ?>/views/about.php">View Orders</a>
      </li>
    </ul>
    <a class="navbar-brand" href="<?= APP_URL ?>/views/admin/home.php"><img src="assets/img/Logo V1.png" width="100" height="50"></a>
    <ul class="navbar-nav ml-auto">
      <?php if (!$request->session()->has("email")) { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= APP_URL ?>/views/cart-view.php">Your Cart</a>
        </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= APP_URL ?>/views/auth/login-form.php">Login</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= APP_URL ?>/views/auth/register-form.php">Register</a>
      </li>
      <?php } else { ?>
        <li class="nav-item">
          <a class="nav-link" href="<?= APP_URL ?>/actions/logout.php">Logout</a>
        </li>
      <?php } ?>
    </ul>
  </div>
</nav>

