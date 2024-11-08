<?php
$host = 'localhost';
$db = 'registeredusersdb'; 
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query
$query = $_POST['query'];

// Prepare and execute the SQL statement
$stmt = $conn->prepare("SELECT ID, Name FROM barbanlista WHERE Name LIKE ?");
$searchQuery = "%" . $query . "%";
$stmt->bind_param("s", $searchQuery);
$stmt->execute();
$result = $stmt->get_result();

// Output the table rows for matching users
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['ID']}</td>
            <td>" . htmlspecialchars($row['Name']) . "</td>
            <td>
                <a href='?remove={$row['ID']}' onclick='return confirm(\"Are you sure you want to remove this user?\");'>Remove</a>
            </td>
          </tr>";
}

$stmt->close();
$conn->close();
?>