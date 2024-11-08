<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  $_SESSION['outputResponse']="You are not logged in!";
  header("Location: loginpage.php");
  exit();
}
?>


<!DOCTYPE html>
<head>

    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/footerStyle.css">
    <link rel="stylesheet" href="styles/headerstyle.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    
    <script src="scripts/script.js"></script>
<body class="sticky-header">

<header>
    <h1>Bine ai venit pe site</h1>
    <nav>
      <a href="loginpage.php">login</a>
      <a href="index.php">Home</a>
      <a href="secretfile.php">Dashboard</a>
      <a><form action="profile.php" method="post" id="profile">
<button type="submit"><i class="fas fa-user"></i></button>
</form></a>
    </nav>
    
  </header>


<div class="wrapper">
  <h1 class="title">Slider de imagini</h1>
    <i id="left" class="fa-solid fa-angle-left"></i>
    <div class="carousel">
      <img src="images/image1.png" alt="img" draggable="false" class="thumbnail" onclick="openImagePage('images/image1.png')">
      <img src="images/image2.png" alt="img" draggable="false" class="thumbnail" onclick="openImagePage('images/image2.png')">
      <img src="images/image3.png" alt="img" draggable="false" class="thumbnail" onclick="openImagePage('images/image3.png')">
      <img src="images/image4.png" alt="img" draggable="false" class="thumbnail" onclick="openImagePage('images/image4.png')">
      <img src="images/image5.png" alt="img" draggable="false" class="thumbnail" onclick="openImagePage('images/image5.png')">
      <img src="images/image6.png" alt="img" draggable="false" class="thumbnail" onclick="openImagePage('images/image6.png')">
      <img src="images/image7.png" alt="img" draggable="false" class="thumbnail" onclick="openImagePage('images/image7.png')">
    </div>
    <div class="dots"></div>
    <i id="right" class="fa-solid fa-angle-right"></i>
  </div>







<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="footer-col">
        <h4>Pagini disponibile</h4>
        <ul>
          <li><a href="loginpage.php">Login</a></li>
          <li><a href="index.php">Home page</a></li>
          <li><a href="secretfile.php">Dashboard</a></li>
        </ul>
      </div>
      <div class="footer-col">
        <h4>Retele sociale</h4>
        <div class="social-links">
          <a href="https://www.facebook.com/?locale=ro_RO"><i class="fab fa-facebook-f"></i></a>
          <a href="https://x.com/"><i class="fab fa-twitter"></i></a>
          <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
          <a href="https://md.linkedin.com/"><i class="fab fa-linkedin-in"></i></a>
        </div>
      </div>
    </div>
  </div>
</footer>


</body>
<script>
    function openImagePage(imageName) {
        window.location.href = `image-page.html?image=${encodeURIComponent(imageName)}`;
    }
</script>
<script src="https://kit.fontawesome.com/591f8c2b84.js" crossorigin="anonymous"></script>
</head>