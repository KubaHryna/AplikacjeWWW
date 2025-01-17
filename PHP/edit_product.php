<?php
include("cfg.php");
include("product_manager.php");

$productManager = new ProductManager();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $tytul = $_POST['tytul'];
    $opis = $_POST['opis'];
    $cena_netto = $_POST['cena_netto'];
    $vat = $_POST['vat'];
    $ilosc = $_POST['ilosc'];
    $status = $_POST['status'];
    $kategoria = $_POST['kategoria'];
    $gabaryt = $_POST['gabaryt'];
    $zdjecie = $_FILES['zdjecie']['name'];

    // Przechowanie zdjęcia na serwerze
    if (!empty($zdjecie)) {
        $upload_dir = "uploads/";
        $upload_file = $upload_dir . basename($_FILES["zdjecie"]["name"]);
        move_uploaded_file($_FILES["zdjecie"]["tmp_name"], $upload_file);
    }

    if ($productManager->EdytujProdukt($id, $tytul, $opis, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie)) {
        echo "<div class='message'>Produkt został zaktualizowany.</div>";
    } else {
        echo "<div class='message'>Wystąpił błąd podczas edycji produktu.</div>";
    }
    header("Location: manage_product.php");
        exit();  
}

// Pobranie szczegółów produktu
$id = intval($_GET['id']);
$produkt = $productManager->PobierzProduktPoId($id);

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <style>
        /* Styl z głównego pliku */
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #333; color: white; }
        .wrapper { max-width: 800px; margin: 20px auto; padding: 20px; background-color: #444; border-radius: 5px; }
        input, select, textarea { width: 100%; padding: 10px; margin: 10px 0; background-color: #555; color: white; border: 1px solid #666; border-radius: 4px; }
        button { background-color: #4CAF50; padding: 10px 15px; border: none; color: white; cursor: pointer; border-radius: 4px; }
        button:hover { background-color: #45a049; }
    </style>
    <title>Edycja produktu</title>
</head>
<body>
<div class="wrapper">
    <h2>Edycja produktu</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $produkt['id']; ?>">
        <input type="text" name="tytul" value="<?php echo $produkt['tytul']; ?>" placeholder="Tytuł" required>
        <textarea name="opis" placeholder="Opis" required><?php echo $produkt['opis']; ?></textarea>
        <input type="number" name="cena_netto" value="<?php echo $produkt['cena_netto']; ?>" placeholder="Cena netto" required>
        <input type="number" name="vat" value="<?php echo $produkt['vat']; ?>" placeholder="VAT" required>
        <input type="number" name="ilosc" value="<?php echo $produkt['ilosc']; ?>" placeholder="Ilość" required>
        <select name="status">
            <option value="1" <?php if ($produkt['status'] == 1) echo 'selected'; ?>>Dostępny</option>
            <option value="0" <?php if ($produkt['status'] == 0) echo 'selected'; ?>>Niedostępny</option>
        </select>
        <input type="text" name="kategoria" value="<?php echo $produkt['kategoria']; ?>" placeholder="Kategoria" required>
        <input type="text" name="gabaryt" value="<?php echo $produkt['gabaryt']; ?>" placeholder="Gabaryt" required>
        <input type="file" name="zdjecie">
        <a href = "/moj_projekt/PHP/manage_product.php">
        <button type="submit">Zaktualizuj produkt</button>
        </a>
    </form>
</div>
</body>
</html>
