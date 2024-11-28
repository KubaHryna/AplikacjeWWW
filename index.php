<?php
// *********************************************
// Załączenie pliku konfiguracyjnego
// *********************************************
include("cfg.php");
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <!-- *********************************************
         Podstawowe ustawienia strony
         ********************************************* -->
    <base href="/moj_projekt/"> <!-- Baza adresów dla zasobów -->
    <link rel="stylesheet" href="style.css"> <!-- Łączenie pliku CSS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> <!-- Załączenie jQuery -->
    <link rel="icon" href="Zdjęcia/Icon.ico" sizes="32x32" type="image/x-icon"> <!-- Ikona strony -->
    <title>Filmy Oscarowe</title> <!-- Tytuł strony -->

    <!-- *********************************************
         Łączenie dodatkowych skryptów JavaScript
         ********************************************* -->
    <script src="JS/timedate.js" type="text/javascript"></script> <!-- Skrypt wyświetlający czas i datę -->
    <script src="JS/information.js" type="text/javascript"></script> <!-- Skrypt z informacjami -->
</head>
<body>
    <!-- *********************************************
         Główna zawartość strony
         ********************************************* -->
    <div class="wrapper">
        <?php
        // Załączenie pliku obsługującego podstrony
        include("showpage.php");

        // *********************************************
        // Wyświetlanie odpowiedniej podstrony
        // *********************************************
        if (isset($_GET['idp'])) { 
            // Jeśli parametr 'idp' został przekazany w URL, wyświetl daną podstronę
            PokazPodstrone($_GET['idp']);
        } else { 
            // Jeśli brak parametru 'idp', wyświetl stronę główną
            PokazPodstrone('HomePage'); 
        }
        ?>
    </div>
</body>
</html>
