<?php
    include 'konfiguracja.php';

    $haslo = hash("sha256", $_GET["pwd"]);
    mysqli_connect('artkoc7548.mysql.dhosting.pl', 'ohth4o_otrebakr', 'aengie8ieGha', 'iet4cu_otrebakr');
    mysqli_select_db($bazaNazwa);
    $rezultat = mysqli_query("SELECT id FROM ab_uzytkownicy WHERE login='".$_GET["lgn"]."' AND haslo='".$haslo."'");
    $lista22=mysqli_query($connect,$sql22);
    $rezultat = mysqli_query($connect,$sql1);

    if(mysql_num_rows($rezultat) == 1) {
        mysqli_close();
        setcookie('login', $_GET["lgn"], time()+3600*24);
        setcookie('haslo', $haslo, time()+3600*24);
        header("Location: menu.php");
        die();
    }

    mysqli_close($connect);
    header("Location: logowanie.php");
    die();
?>
