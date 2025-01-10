<?php
// Załączenie pliku konfiguracyjnego
include("cfg.php");

// Klasa do zarządzania produktami
class ProductManager {
    private $db;

    public function __construct() {
        // Połączenie z bazą danych - zmieniono nazwę bazy na 'produkty'
        $this->db = new mysqli('localhost', 'root', '', 'moja_strona');
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    // Metoda dodawania produktu
    public function DodajProdukt($tytul, $opis, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie) {
        $dataUtworzenia = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO produkty (tytul, opis, data_utworzenia, cena_netto, vat, ilosc, status, kategoria, gabaryt, zdjecie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssddissss", $tytul, $opis, $dataUtworzenia, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie);
        $stmt->execute();
        $stmt->close();
    }

    // Metoda wyświetlania produktów
    public function PokazProdukty() {
        $produkty = $this->db->query("SELECT * FROM produkty");
        echo "<div class='product-container'>";
        while ($produkt = $produkty->fetch_assoc()) {
            echo "<div class='product-card'>";
            echo "<h3>{$produkt['tytul']}</h3>";
            echo "<p>{$produkt['opis']}</p>";
            echo "<p>Cena netto: {$produkt['cena_netto']} zł</p>";
            echo "<p>VAT: {$produkt['vat']}%</p>";
            echo "<p>Łączna cena: " . ($produkt['cena_netto'] * (1 + $produkt['vat'] / 100)) . " zł</p>";
            echo "<p>Ilość: {$produkt['ilosc']}</p>";
            echo "<p>Status: " . ($produkt['status'] ? "Dostępny" : "Niedostępny") . "</p>";
            if ($produkt['zdjecie']) {
                echo "<img src='{$produkt['zdjecie']}' alt='Zdjęcie produktu'>";
            }
            echo "</div>";
        }
        echo "</div>";
    }
}

$productManager = new ProductManager(); // Tworzenie obiektu klasy ProductManager
?>
