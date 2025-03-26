<?php
    // Include database configuration (assuming you have a 'konfiguracja.php' with these variables)
    include 'konfiguracja.php';

    // Ensure proper user input is sanitized (escape dangerous characters in user input)
    $login = $_GET['lgn'];
    $password = $_GET['pwd'];

    // Hash the password using SHA256 (but remember: using password_hash() is better)
    $hashedPassword = hash("sha256", $password);

    // Create a connection to the database using MySQLi
    $conn = new mysqli($bazaAdres, $bazaLogin, $bazaHaslo, $bazaNazwa);

    // Check for successful connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, haslo FROM uzytkownicy WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->store_result();

    // Check if a user is found and verify password
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $dbHaslo);
        $stmt->fetch();

        // Check if the stored hashed password matches the input password hash
        if ($dbHaslo === $hashedPassword) {
            // Set cookies and redirect to the menu page if login is successful
            setcookie('login', $login, time() + 3600 * 24);
            setcookie('haslo', $hashedPassword, time() + 3600 * 24);
            header("Location: menu.php");
            die();
        }
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // If login failed, redirect to the login page
    header("Location: logowanie.php");
    die();
?>
