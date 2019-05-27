<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Obchod s chovatelksým zbožím">
  <meta name="author" content="Johanna Švugerová">

  <title>PetShop</title>

  <!-- Bootstrap core CSS -->
  <link href="styles/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="styles/style.css" rel="stylesheet">

</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.php"><img src=ikona.png height="50" wight="50" alt="ikona Pet Shopu"><h1>PetShop</h1></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="index.php"><h5>Kočky</h5>
              <span class="sr-only">(current)</span>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="#"><h5>Psy</h5></a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="#"><h5>Ostatní</h5></a>
          </li>
          <li><h4>|</h4></li>
          <?php if (isset($_SESSION['userID'])): ?>
            <li class="nav-item<?php echo strpos($_SERVER['REQUEST_URI'], 'cart') ? ' active' : '' ?>">
              <a class="nav-link" href="cart.php"><b> Nákupní košík</b></a>
            </li>
            <li class="nav-item<?php echo strpos($_SERVER['REQUEST_URI'], 'logout') ? ' active' : '' ?>">
              <a class="nav-link" href="logout.php"> Odhlášení</a>
            </li>
          <?php else: ?>
            <li class="nav-item<?php echo strpos($_SERVER['REQUEST_URI'], 'login') ? ' active' : '' ?>">
              <a class="nav-link" href="login.php"><b>Přihlášení</b></a>
            </li>
          <?php endif; ?>
          </li>
        </ul>
      </div>
    </div>
  </nav>
