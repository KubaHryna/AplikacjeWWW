<?php
// *********************************************
// Załączenie pliku konfiguracyjnego
// *********************************************
include("cfg.php");
// KATEGORIE - Załączenie klasy zarządzania kategoriami
include("category_manager.php");
 $categoryManager = new CategoryManager(); // Tworzenie obiektu klasy
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <!-- *********************************************
         Podstawowe ustawienia strony
         ********************************************* -->
    <base href="/moj_projekt/"> <!-- Baza adresów dla zasobów -->
    <link rel="stylesheet" href="style_main.css"> <!-- Łączenie pliku CSS -->
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
     <!--KATEGORIE - Formularz zarządzania kategoriami -->
    <div class="categories">
            <h2>Zarządzanie kategoriami</h2>

            <!-- Formularz dodawania kategorii -->
            <form method="post">
                <input type="text" name="nazwa" placeholder="Nazwa kategorii" required>
                <select name="matka">
                    <option value="0">Główna kategoria</option>
                    <?php
                    // Wyświetlanie istniejących kategorii jako opcji
                    $categoryManager->PokazKategorie(); 
                    ?>
                </select>
                <button type="submit" name="dodaj">Dodaj kategorię</button>
            </form>

            <!-- Formularz usuwania kategorii -->
            <form method="post">
                <input type="number" name="id" placeholder="ID kategorii do usunięcia" required>
                <button type="submit" name="usun">Usuń kategorię</button>
            </form>

            <!-- Formularz edycji kategorii -->
            <form method="post">
                <input type="number" name="id" placeholder="ID kategorii do edycji" required>
                <input type="text" name="nowa_nazwa" placeholder="Nowa nazwa" required>
                <button type="submit" name="edytuj">Edytuj kategorię</button>
            </form>

            <!-- Wyświetlanie drzewa kategorii -->
            <h3 id = "cm">Aktualne kategorie</h3>
            <?php $categoryManager->PokazKategorie(); ?>
        </div>
        

        <?php
        // *********************************************
        // Obsługa formularzy kategorii
        // *********************************************
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['dodaj'])) {
                $categoryManager->DodajKategorie($_POST['nazwa'], $_POST['matka']);
            } elseif (isset($_POST['usun'])) {
                $categoryManager->UsunKategorie($_POST['id']);
            } elseif (isset($_POST['edytuj'])) {
                $categoryManager->EdytujKategorie($_POST['id'], $_POST['nowa_nazwa']);
            }
        }
        ?>
    </div>
</body>
</html>
