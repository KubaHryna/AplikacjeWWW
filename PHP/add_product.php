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
<style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #333; }
        .wrapper { 
            max-width: 800px; 
            margin: 20px auto; 
            padding: 20px;
            background-color: #444;
            border-radius: 5px;
            color: white;
        }
        h2 { text-align: center; }
        input[type="text"], input[type="number"], textarea, select {
            width: 100%; 
            padding: 10px; 
            margin: 10px 0;
            border-radius: 4px; 
            border: 1px solid #666;
            background-color: #555;
            color: white;
        }
        textarea { min-height: 100px; }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }
        button:hover { background-color: #45a049; }
        input[type="file"] { 
            margin: 10px 0;
        }
        label {
            font-weight: bold;
        }
        .message { color: #ffd700; margin: 10px 0; text-align: center; }
    </style>
<head>
    <base href="/moj_projekt/"> <!-- Baza adresów dla zasobów -->
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
