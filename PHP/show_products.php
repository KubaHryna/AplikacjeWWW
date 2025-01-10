<?php
// Załączenie pliku konfiguracyjnego i klasy do zarządzania produktami
include("cfg.php");
include("product_manager.php");

// Tworzenie obiektu klasy ProductManager
$productManager = new ProductManager();

// Wyświetlanie produktów
$productManager->PokazProdukty();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep Internetowy</title>
    <link rel="stylesheet" href="../product.css">
</head>
</html>
