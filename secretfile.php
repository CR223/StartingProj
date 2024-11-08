<?php
session_start();

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  $_SESSION['outputResponse']="You are not logged in!";
  header("Location: loginpage.php");
  exit();
}
?>

<?php

$host = 'localhost';
$db = 'registeredusersdb'; 
$user = 'root';
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);


if ($conn->connect_error) {
    die("Conexiune esuata!: " . $conn->connect_error);
}


if (isset($_POST['add_users'])) {
    $names_input = trim($_POST['names']);
    $names = preg_split('/[\r\n,]+/', $names_input);

    $added = [];
    $skipped = [];
    
    foreach ($names as $name) {
        $name = trim($name);
        
       
        if (!empty($name)) {
            
          
            if (isset($_POST['prefixcheckbox']) && $_POST['prefixcheckbox'] == 'on') {
                $name = append_string("Alexandru barba", $name);
            }

            
            $stmt = $conn->prepare("SELECT ID FROM barbanlista WHERE Name = ?");
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows > 0) {
                $skipped[] = $name;
            } else {
                if(str_contains($name,"Alexandru barba") == true){
                $stmt = $conn->prepare("INSERT INTO barbanlista (Name) VALUES (?)");
                $stmt->bind_param("s", $name);
                if ($stmt->execute()) {
                    $added[] = $name; 
                }
                }
                else{
                    echo "<div id='statusMessage' style='color: red;'>Nu contine prefixul'Alexandru barba'!</div>";
                }
            }
            $stmt->close();
        }
    }


    if (!empty($added)) {
        echo "<div id='statusMessage' style='color: green;'>Adaugata barba: " . implode(', ', $added) . "</div>";
    }
    if (!empty($skipped)) {
        echo "<div id='statusMessage' style='color: red;'>Evitat (deja exista): " . implode(', ', $skipped) . "</div>";
    }
}


if (isset($_GET['remove'])) {
    $id = intval($_GET['remove']);
    
    $stmt = $conn->prepare("DELETE FROM barbanlista WHERE ID = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        
        echo "<div id='statusMessage' style='color: green;'>User removed successfully!</div>";

        $conn->query("SET @count = 0;");
        $conn->query("UPDATE barbanlista SET ID = (@count := @count + 1);");
        $conn->query("ALTER TABLE barbanlista AUTO_INCREMENT = 1;");

        header("Location: " . strtok($_SERVER["REQUEST_URI"], '?'));
        
        exit();
        
    } else {
        echo "<div id='statusMessage' style='color: red;'>Error removing user.</div>";
    }
    $stmt->close();
}

if (isset($_POST['save_backup'])) {
    fireBackup($conn,false);
    echo "<div id='statusMessage' style='color: green;'>Backup successfull!</div>";
    }

if (isset($_POST['download_backup'])) {
fireBackup($conn,false);

$file_path = 'backup/backup.txt';
if (file_exists($file_path)) {
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    header('Content-Length: ' . filesize($file_path));
    readfile($file_path);
} else {
    echo "<div id='statusMessage' style='color: red;'>File not found!</div>";
}
}

    function fireBackup($conn, $displayStatusMessage) {
    $stmt = $conn->prepare("SELECT Name FROM barbanlista");
    $stmt->execute();
    $array = [];
    foreach ($stmt->get_result() as $row)
    {$array[] = $row['Name'];}
   if( file_exists("backup")==false){
    mkdir("backup", 0755);
   }
        $file = fopen("backup/backup.txt","w");
        for($i = 0; $i < count($array); $i++){
            fwrite($file,$array[$i]."\n");
        }
        if($displayStatusMessage == true){echo "<div id='statusMessage' style='color: green;'>Barbele au fost stocate cu succes!</div>";}
    }


if (isset($_POST['remove_all'])) {
    fireBackup($conn,false);
    $stmt = $conn->prepare("TRUNCATE TABLE barbanlista");
    if ($stmt->execute()) {
        echo "<div id='statusMessage' style='color: green;'>Toate barbele au fost sterse cu succes!</div>";
    } else {
        echo "<div id='statusMessage' style='color: red;'>Eroare in stergerea barbelor</div>";
    }
    $stmt->close();
}


$result = $conn->query("SELECT ID, Name FROM barbanlista");

function append_string ($str1, $str2) {
    $str1 .=$str2;
    return $str1;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/barbanstil.css">
    <link rel="stylesheet" href="styles/sidebarstyle.css">
    <link rel="stylesheet" href="styles/searchbarstyle.css">
      <link rel="stylesheet" href="styles/footerstyle.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Alexandru barbanlista v1.1</title>
</head>
<body>





<div class="search-container">
  <input type="text" id="searchBar" placeholder="Search...">
  <label for="search">Search</label>
</div>
<div id="searchResults"></div>

<h2>Utilizatori</h2>

<div id="mySidenav" class="sidenav">

  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

  <a>Meniu</a>
<button onclick="toggleAddForm()">Adauga barbe</button>  
  <div class="manage-form" id="manageform" style="display: none;">
<form action="" method="POST">
   <div class="checkboxwrapper"> <input type="checkbox" id="prefixcheckbox" name="prefixcheckbox" value="on" checked>
    <label for="prefixcheckbox">Include prefixul "Alexandru barba"</label></div>
    <textarea name="names" rows="5" cols="30"></textarea><br><br>
    <button type="submit" name="add_users">Adauga barba</button>
</form>
<br/>
</div>
<form action="" method="POST" onsubmit="return confirm('Esti sigur ca doresti sa stergi toate barbele?');">
    <button type="submit" name="remove_all">Sterge barbele</button>
</form>

<form action="" method="POST" onsubmit="return confirm('Doresti sa salvezi fisierul de backup?');">
    <button type="submit" name="Save_backup">

        Save file
    </button>
    <button type="submit" name="download_backup" class="download_btn">
        <i class="fa fa-folder-open" style="margin-right:3px;margin-left:3px;"></i>
    </button>
    
</form>
</div>

<div id="main">
 
  <span style="font-size:30px;cursor:pointer;position:fixed;color:white;" onclick="openNav()">&#9776;</span>


<div class="table-wrapper">
    <table class="fl-table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nume</th>
        <th>Actiuni</th>
    </tr>
    </thead>
    <tbody>
    <?php while ($row = $result->fetch_assoc()) : ?>
        <tr>
            <td><?php echo $row['ID']; ?></td>
            <td><?php echo htmlspecialchars($row['Name']); ?></td>
            <td>
                <a href="?remove=<?php echo $row['ID']; ?>" onclick="return confirm('Esti sigur ca doresti sa stergi barba?');">Remove</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>
</div>



</div>
<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="footer-col">
        <h4>Pagini disponibile</h4>
        <ul>
          <li><a href="loginpage.php">Login</a></li>
          <li><a href="index.php">Home page</a></li>
          <li><a href="secretfile.php">Barba</a></li>
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




</html>


<?php
$conn->close();
?>


<script>
function openNav() {
    if(document.getElementById("manageform").style.display === "none"){
  document.getElementById("mySidenav").style.width = "300px";
  document.getElementById("main").style.marginLeft = "240px";
  document.getElementById("statusMessage").style.marginLeft = "300px";
}else{
    document.getElementById("mySidenav").style.width = "350px";
  document.getElementById("main").style.marginLeft = "290px";
  document.getElementById("statusMessage").style.marginLeft = "350px";
}
}

function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
  document.getElementById("main").style.marginLeft= "0";
  document.getElementById("statusMessage").style.marginLeft = "0";
}

function toggleAddForm() {
    var form = document.getElementById("manageform");
    const nav = document.getElementById("mySidenav");
    if (form.style.display === "none") {
    form.style.display = "block";
    nav.style.width = "350px";
    document.getElementById("main").style.marginLeft = "290px";
    document.getElementById("statusMessage").style.marginLeft = "350px";
  } else {
    form.style.display = "none";
    nav.style.width = "300px";
    document.getElementById("main").style.marginLeft = "240px";
    document.getElementById("statusMessage").style.marginLeft = "300px";
  }
}


document.addEventListener("DOMContentLoaded", function() {
    const messageElement = document.getElementById('statusMessage');
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



</script>
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script>
$(document).ready(function() {
    $('#searchBar').on('input', function() {
        let searchQuery = $(this).val();

        $.ajax({
            url: 'search_users.php',
            method: 'POST',
            data: { query: searchQuery },
            success: function(response) {
                $('tbody').html(response);
            }
        });
    });
});
</script>
