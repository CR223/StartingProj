<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    $_SESSION['outputResponse']="You are not logged in!";
    header("Location: loginpage.php");
    exit;
}

$username = $_SESSION['username'];
$newUsername = $_POST['username'];
$newEmail = $_POST['email'];
$newPassword = $_POST['password'];

$conn = new mysqli('localhost', 'root', '', 'registeredusersdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$stmt = $conn->prepare("SELECT userName FROM registeredusers WHERE (userName = ? OR userEmail = ?) AND userName != ?");
$stmt->bind_param("sss", $newUsername, $newEmail, $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $_SESSION['profile_error'] = "Username or email already taken!";
    header("Location: profile.php");
    exit;
}

$stmt->close();


if (!empty($newPassword)) {
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE registeredusers SET userName = ?, userEmail = ?, userPassword = ? WHERE userName = ?");
    $stmt->bind_param("ssss", $newUsername, $newEmail, $hashedPassword, $username);
} else {
    $stmt = $conn->prepare("UPDATE registeredusers SET userName = ?, userEmail = ? WHERE userName = ?");
    $stmt->bind_param("sss", $newUsername, $newEmail, $username);
}

if ($stmt->execute()) {

    $_SESSION['username'] = $newUsername;
    $_SESSION['profile_success'] = "Profile updated successfully!";
} else {
    $_SESSION['profile_error'] = "Error updating profile!";
}

$stmt->close();
$conn->close();


header("Location: index.php");
exit;
?>