<?php
    include 'konfiguracja.php';
    
    $login = $_GET["lgn"];
    $password = $_GET["pwd"];
    $hashedPassword = hash("sha256", $password);

    $conn = new mysqli('artkoc7548.mysql.dhosting.pl', 'ohth4o_otrebakr', 'aengie8ieGha', 'iet4cu_otrebakr');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, haslo FROM uzytkownicy WHERE login = ?");
    $stmt->bind_param("s", $login);
    $stmt->execute();
    $stmt->store_result();


    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $dbHaslo);
        $stmt->fetch();

        if ($dbHaslo === $hashedPassword) {
            setcookie('login', $login, time() + 3600 * 24);
            setcookie('haslo', $hashedPassword, time() + 3600 * 24);
            header("Location: menu.php");
            die();
        }
    }

    $stmt->close();
    $conn->close();

    header("Location: logowanie.php");
    die();
?>
