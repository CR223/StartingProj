<?php

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$conn = new mysqli('localhost', 'root', '', 'registeredusersdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT userPassword FROM registeredusers WHERE userName = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
   
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {

        $_SESSION['username'] = $username;
        $_SESSION['loggedin'] = true;
        header("Location: index.php", true, 301);  
    
    } else {
        $_SESSION['outputResponse']="Incorrect password!";
        header("Location: loginpage.php", true, 301);
        exit();
    }
} else {
    $_SESSION['outputResponse']="Username not found!";
    header("Location: loginpage.php", true, 301);
    exit();
}

$stmt->close();
$conn->close();
?>