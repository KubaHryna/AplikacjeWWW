<?php
// Załączenie pliku konfiguracyjnego i klasy zarządzającej produktami
include("cfg.php");
include("product_manager.php");

$productManager = new ProductManager(); 

// Sprawdzenie, czy parametr 'id' jest przekazany przez URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $produkt = $productManager->PobierzProduktPoId($id); // Pobranie produktu z bazy danych
} else {
    // Jeśli brak id, przekierowanie do strony z listą produktów
    header("Location: manage_product.php");
    exit();
}

// Obsługa formularza
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['tak'])) {
        // Usuń produkt
        $result = $productManager->UsunProdukt($id);
        if ($result === "Produkt został usunięty.") {
            header("Location: manage_product.php");
            exit();
        } else {
            $message = "Wystąpił błąd podczas usuwania produktu: $result";
        }
    } elseif (isset($_POST['nie'])) {
        header("Location: manage_product.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Potwierdzenie usunięcia produktu</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #333; color: white; }
        .wrapper {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #444;
            border-radius: 5px;
            text-align: center;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #45a049;
        }
        .danger {
            background-color: #f44336;
        }
    </style>
</head>
<body>

<div class="wrapper">
    <h2>Czy na pewno chcesz usunąć produkt?</h2>
    <p><strong>Produkt: </strong><?php echo htmlspecialchars($produkt['tytul']); ?></p>
    <p><strong>ID: </strong><?php echo htmlspecialchars($produkt['id']); ?></p>

    <form method="POST">
        <button type="submit" name="tak">TAK, usuń produkt</button>
        <button type="submit" name="nie" class="danger">NIE, wróć do listy produktów</button>
    </form>

    <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
</div>

</body>
</html>
