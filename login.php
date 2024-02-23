<?php
session_start(); // Începe o nouă sesiune sau reia una existentă

// Conectarea la baza de date
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydatabase";

// Crearea conexiunii
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificarea conexiunii
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Aici se schimbă: selectează hash-ul parolei din baza de date
    $sql = "SELECT id, password FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Parola este corectă, inițializează sesiunea
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            echo "<script>
                    alert('Te-ai logat cu succes!');
                    setTimeout(function(){
                       window.location.href = 'index.html';
                    }, 3000);
                  </script>";
        } else {
            echo "Numele de utilizator sau parola este greșită.";
        }
    } else {
        echo "Numele de utilizator sau parola este greșită.";
    }
}
$conn->close();
?>
