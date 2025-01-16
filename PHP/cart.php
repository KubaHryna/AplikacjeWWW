<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Twój koszyk</title>
    <link rel="stylesheet" href="../cart.css">
</head>
<body>

<?php
session_start();

echo "<h1>Twój koszyk</h1>";

// Wyświetlenie zawartości koszyka
if (isset($_SESSION['count']) && $_SESSION['count'] > 0) {
    echo "<table>";
    echo "<tr><th>Produkt</th><th>Ilość</th><th>Cena brutto</th><th>Wartość</th><th>Opcje</th></tr>";
    $totalValue = 0;
    for ($i = 1; $i <= $_SESSION['count']; $i++) {
        if (isset($_SESSION["prod_$i"])) {
            $produkt = $_SESSION["prod_$i"];
            echo "<tr>";
            echo "<td>{$produkt['tytul']}</td>";
            echo "<td>
                    <form method='post'>
                        <input type='hidden' name='edit_id' value='$i'>
                        <input type='number' name='ilosc' value='{$produkt['ilosc']}' min='1'>
                        <button type='submit'>Aktualizuj</button>
                    </form>
                  </td>";
            echo "<td>{$produkt['cena_brutto']} zł</td>";
            echo "<td>{$produkt['wartosc']} zł</td>";
            echo "<td>
                    <form method='post'>
                        <input type='hidden' name='remove_id' value='$i'>
                        <button type='submit'>Usuń</button>
                    </form>
                  </td>";
            echo "</tr>";
            $totalValue += $produkt['wartosc'];
        }
    }
    echo "<tr><td colspan='3'><strong>Łączna wartość:</strong></td><td colspan='2'><strong>{$totalValue} zł</strong></td></tr>";
    echo "</table>";
    echo "<a href='../PHP/show_products.php'>Wróć do sklepu</a>";
} else {
    echo "<p>Twój koszyk jest pusty.</p>";
    echo "<a href='../PHP/show_products.php'>Wróć do sklepu</a>";
}

// Usuwanie produktu z koszyka
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_id'])) {
    $id = $_POST['remove_id'];
    unset($_SESSION["prod_$id"]);
    echo "<p>Produkt został usunięty.</p>";
    header("Refresh:0");
}

// Aktualizacji ilości produktu w koszyku
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'], $_POST['ilosc'])) {
    $id = $_POST['edit_id'];
    $ilosc = intval($_POST['ilosc']);
    if (isset($_SESSION["prod_$id"])) {
        $_SESSION["prod_$id"]['ilosc'] = $ilosc;
        $_SESSION["prod_$id"]['wartosc'] = $_SESSION["prod_$id"]['cena_brutto'] * $ilosc;
        echo "<p>Ilość produktu została zaktualizowana.</p>";
        header("Refresh:0");
    }
}
?>

</body>
</html>
