<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: loginpage.php");
    exit;
}

$conn = new mysqli('localhost', 'root', '', 'registeredusersdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT userName, userEmail FROM registeredusers WHERE userName = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($userName, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles/styleProfile.css">
</head>
<body>
<div class="container">
<div class="example-section">
    <h2>Bine ai venit, <?php echo htmlspecialchars($username); ?></h2>


    <form action="update_profile.php" method="post">
        <div>
            <label for="username">Nume:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($userName); ?>" required>
        </div>

        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>

        <div>
            <label for="password">Parola noua(optional):</label>
            <input type="password" id="password" name="password">
        </div>

        <button type="submit">Actualizeaza profilul</button>
    </form>

<form action="logout.php" method="post">
<button type="submit">Log out</button>
</form>
    </div>
</div>
</body>
</html>

<?php
$conn->close();
?>