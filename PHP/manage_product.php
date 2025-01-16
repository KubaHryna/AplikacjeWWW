
<?php
// Załączenie pliku konfiguracyjnego i klasy zarządzającej produktami
include("cfg.php");
include("product_manager.php");

$productManager = new ProductManager(); 

// Obsługa formularza dodawania produktu
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['edytuj'])) {
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
        $upload_dir = "../Zdjęcia/"; 
        $upload_file = $upload_dir . basename($_FILES["zdjecie"]["name"]);
        move_uploaded_file($_FILES["zdjecie"]["tmp_name"], $upload_file);
    }

    // Dodawanie produktu do bazy
    $productManager->DodajProdukt($tytul, $opis, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie);
}

// Obsługa edytowania produktu
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edytuj'])) {
    $id = $_POST['id'];
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

    // Edytowanie produktu
    $productManager->EdytujProdukt($id, $tytul, $opis, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie);
}

// Obsługa usuwania produktu
if (isset($_GET['usun'])) {
    $id = intval($_GET['usun']); 
    $result = $productManager->UsunProdukt($id);  

    if ($result === "Produkt został usunięty.") {
        echo "<div class='message'>Produkt został usunięty.</div>";
    } else {
        echo "<div class='message'>Wystąpił błąd podczas usuwania produktu: $result</div>";
    }
    
    header("Location: add_product.php");
    exit();
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
    <base href="/moj_projekt/"> 
    <title>Zarządzanie produktami</title> 
</head>
<body>
<a href="admin/admin.php" style="position: absolute; top: 20px; right: 20px; background-color: #4CAF50; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-size: 16px; cursor: pointer;">
    Powrót
</a>
<div class="wrapper">
    <h2>Dostępne produkty</h2>
    <table style="width: 100%; border-collapse: collapse; color: white;">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nazwa</th>
                <th>Opis</th>
                <th>Cena netto</th>
                <th>Ilość</th>
                <th>Akcje</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $produkty = $productManager->PobierzProdukty();
            while ($produkt = $produkty->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$produkt['id']}</td>";
                echo "<td>{$produkt['tytul']}</td>";
                echo "<td>{$produkt['opis']}</td>";
                echo "<td>{$produkt['cena_netto']} zł</td>";
                echo "<td>{$produkt['ilosc']}</td>";
                echo "<td>
                        <a href='/moj_projekt/PHP/delete_product.php?id={$produkt['id']}'>
                            <button style='background-color: #f44336; padding: 5px 10px; color: white; border: none; cursor: pointer;'>Usuń</button>
                        </a>


                        <a href='/moj_projekt/PHP/edit_product.php?id={$produkt['id']}'>
                            <button style='background-color: #4CAF50; padding: 5px 10px; color: white; border: none; cursor: pointer;'>Edytuj</button>
                        </a>
                      </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>
    <div class="wrapper">
        <h2>Dodaj nowy produkt</h2>
        <form method="post" enctype="multipart/form-data">
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
