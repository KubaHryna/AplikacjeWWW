<?php
// Załączenie pliku konfiguracyjnego i klasy do zarządzania produktami
include("cfg.php");
include("product_manager.php");
session_start();

// Funkcja dodająca produkt do koszyka
function addToCart($id_prod, $tytul, $ilosc, $cena_netto, $vat) {
    if (!isset($_SESSION['count'])) {
        $_SESSION['count'] = 0;
    }

    // Obliczamy cenę brutto
    $cena_brutto = $cena_netto + ($cena_netto * $vat / 100);

    $nr = ++$_SESSION['count'];

    $_SESSION["prod_$nr"] = [
        'id_prod' => $id_prod,
        'tytul' => $tytul,
        'ilosc' => $ilosc,
        'cena_netto' => $cena_netto,
        'vat' => $vat,
        'cena_brutto' => $cena_brutto,
        'wartosc' => $cena_brutto * $ilosc
    ];
}

// Obsługa dodawania produktu do koszyka
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $id_prod = $_POST['id_prod'];
    $tytul = $_POST['tytul'];
    $ilosc = $_POST['ilosc'];
    $cena_netto = $_POST['cena_netto'];
    $vat = $_POST['vat'];

    addToCart($id_prod, $tytul, $ilosc, $cena_netto, $vat);
    echo "<p>Produkt '$tytul' został dodany do koszyka.</p>";
}

// Tworzenie obiektu klasy ProductManager
$productManager = new ProductManager();

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep Internetowy</title>
    <link rel="stylesheet" href="../product.css">
</head>
<body>
<a href="../index.php" style="position: absolute; top: 20px; left: 20px; background-color:darkgray ; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-size: 16px; cursor: pointer;">
    Powrót
</a>
    <h1>Sklep Internetowy</h1>
    <a href="cart.php" class="cart-link">
        <img src="../Zdjęcia/cart.png" alt="Koszyk" class="cart-icon">
    </a>
    <?php $productManager->PokazProdukty(); ?>
</body>
</html>
