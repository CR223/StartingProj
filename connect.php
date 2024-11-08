<?php

$username = $_POST["registerusername"];
$email = $_POST["registeremail"];
$password = $_POST["registerpassword"];
$confirmPassword = $_POST["confirmpassword"];

if ($password == $confirmPassword) {

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $conn = new mysqli('localhost', 'root', '', 'registeredusersdb');

    if ($conn->connect_error) {
        die("Connection Failed : " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT COUNT(*) FROM registeredusers WHERE userEmail = ?");
    if ($stmt === false) {
        die("Failed to prepare statement: " . $conn->error);
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo "<script>alert('The email you inserted is already registered!');</script>";
    } else {
        $stmt2 = $conn->prepare("INSERT INTO registeredusers (userName, userEmail, userPassword) VALUES (?, ?, ?)");
        if ($stmt2 === false) {
            die("Failed to prepare insert statement: " . $conn->error);
        }
        $stmt2->bind_param("sss", $username, $email, $hashed_password);
        if ($stmt2->execute()) {
            echo "<script>alert('Registration successful!');</script>";
        } else {
            echo "Error: " . $stmt2->error;
        }
        $stmt2->close();
    }
    header("Location: loginpage.php", true, 301);
    $conn->close();

} else {
    echo "Passwords don't match!";
}
?>