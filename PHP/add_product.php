<?php
// Załączenie pliku konfiguracyjnego i klasy zarządzającej produktami
include("cfg.php");
include("product_manager.php");

$productManager = new ProductManager(); // Tworzenie obiektu klasy ProductManager

// Obsługa formularza dodawania produktu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tytul = $_POST['tytul'];
    $opis = $_POST['opis'];
    $cena_netto = $_POST['cena_netto'];
    $vat = $_POST['vat'];
    $ilosc = $_POST['ilosc'];
    $status = $_POST['status'];
    $kategoria = $_POST['kategoria'];
    $gabaryt = $_POST['gabaryt'];
    $zdjecie = $_POST['zdjecie'];

    // Dodawanie produktu do bazy
    $productManager->DodajProdukt($tytul, $opis, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie);
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <base href="/moj_projekt/"> <!-- Baza adresów dla zasobów -->
    <link rel="stylesheet" href="style_main.css"> <!-- Łączenie pliku CSS -->
    <title>Dodaj produkt</title> <!-- Tytuł strony -->
</head>
<body>
    <div class="wrapper">
        <h2>Dodaj nowy produkt</h2>
        <form method="post">
            <input type="text" name="tytul" placeholder="Tytuł" required><br>
            <textarea name="opis" placeholder="Opis" required></textarea><br>
            <input type="number" name="cena_netto" placeholder="Cena netto" required><br>
            <input type="number" name="vat" placeholder="VAT" required><br>
            <input type="number" name="ilosc" placeholder="Ilość" required><br>
            <select name="status">
                <option value="1">Dostępny</option>
                <option value="0">Niedostępny</option>
            </select><br>
            <input type="text" name="kategoria" placeholder="Kategoria" required><br>
            <input type="text" name="gabaryt" placeholder="Gabaryt" required><br>
            <input type="file" name="zdjecie"><br>
            <button type="submit">Dodaj produkt</button>
        </form>
    </div>
</body>
</html>
