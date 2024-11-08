<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login/Register Form</title>
    <link rel="stylesheet" href="styles/styleLogin.css">
    <link rel="stylesheet" href="styles/drag.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  </head>
</head>
<body>

    <div id="myWindow" class="window">
        <div class="window-top"></div>
        <div class="window-content">
         
        <?php
                    if (isset($_SESSION['outputResponse'])) {
                        echo "<p style='color:red;' id='outputresponse'>" . $_SESSION['outputResponse'] . "</p>";
                        unset($_SESSION['outputResponse']);
                    }
                    ?>
                 
            <div class="form-container">
                <div id="loginForm" class="form-box">
                    <h2>Login</h2>
                    <form id="login" action="login.php" method="post">
                        <div class="input-group">
                            <input type="text" id="loginUsername" required name="username">
                            <label for="loginUsername">Username</label>
                        </div>
                        <div class="input-group">
                            <input type="password" id="loginPassword" name="password" required>
                            <label for="loginPassword">Password</label>
                            <span class="password-toggle-icon"><i class="fas fa-eye"></i></span>
                        </div>
                        <button type="submit">Login</button>
                        <p>Don't have an account? <a href="#" onclick="toggleForms()">Register</a></p>
                    </form>
                </div>
            </div>

            <div id="registerForm" class="form-box hidden">
                <h2>Register</h2>
                <form action="connect.php" method="post" id="register">
                    <div class="input-group">
                        <input type="text" id="registerUsername" required name="registerusername">
                        <label for="registerUsername">Username</label>
                    </div>
                    <div class="input-group">
                        <input type="email" id="registerEmail" required name="registeremail">
                        <label for="registerEmail">Email</label>
                    </div>
                    <div class="input-group">
                        <input type="password" id="registerPassword" required name="registerpassword">
                        <label for="registerPassword">Password</label>
                    </div>
                    <div class="input-group">
                        <input type="password" id="confirmPassword" required name="confirmpassword">
                        <label for="confirmPassword">Confirm Password</label>
                    </div>
                    <button type="submit">Login</button>
                    <p>Already have an account? <a href="#" onclick="toggleForms()">Login</a></p>
                </form>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        makeDraggable(document.querySelector('#myWindow'));
    });

    document.addEventListener("DOMContentLoaded", function() {
    const messageElement = document.getElementById('outputresponse');
    if (messageElement) {
        setTimeout(() => {
            messageElement.style.transition = "opacity 1s ease";
            messageElement.style.opacity = 0; 

            setTimeout(() => {
                messageElement.style.display = 'none';
            }, 500);
        }, 5000);
    }
});

const passwordField = document.getElementById("loginPassword");
const togglePassword = document.querySelector(".password-toggle-icon i");

togglePassword.addEventListener("click", function () {
  if (passwordField.type === "password") {
    passwordField.type = "text";
    togglePassword.classList.remove("fa-eye");
    togglePassword.classList.add("fa-eye-slash");
  } else {
    passwordField.type = "password";
    togglePassword.classList.remove("fa-eye-slash");
    togglePassword.classList.add("fa-eye");
  }
});
    </script>
    <script src="scripts/drag.js"></script>
    <script src="scripts/ScriptLogin.js"></script>

</body>
</html>