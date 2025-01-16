<?php
// Załączenie pliku konfiguracyjnego
include("cfg.php");

// Klasa do zarządzania produktami
class ProductManager {
    private $db;

    public function __construct() {
        // Połączenie z bazą danych
        $this->db = new mysqli('localhost', 'root', '', 'moja_strona');
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }
    public function PobierzProduktPoId($id) {
        $query = "SELECT * FROM produkty WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function PobierzProdukty() {
        return $this->db->query("SELECT * FROM produkty");
    }
    // Metoda dodawania produktu
    public function DodajProdukt($tytul, $opis, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie) {
        $dataUtworzenia = date('Y-m-d H:i:s');
        $stmt = $this->db->prepare("INSERT INTO produkty (tytul, opis, data_utworzenia, cena_netto, vat, ilosc, status, kategoria, gabaryt, zdjecie) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssddissss", $tytul, $opis, $dataUtworzenia, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie);
        $stmt->execute();
        $stmt->close();
    }

    // Metoda edytowania produktu
    public function EdytujProdukt($id, $tytul, $opis, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie) {
        $query = "UPDATE produkty SET tytul = ?, opis = ?, cena_netto = ?, vat = ?, ilosc = ?, status = ?, kategoria = ?, gabaryt = ?, zdjecie = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ssdiisissi', $tytul, $opis, $cena_netto, $vat, $ilosc, $status, $kategoria, $gabaryt, $zdjecie, $id);
        
        if ($stmt->execute()) {
            return "Produkt został zaktualizowany.";
        }
        return "Wystąpił błąd podczas edytowania produktu.";
    }

    // Metoda usuwania produktu
    public function UsunProdukt($id) {
        $id = intval($id);  

        
        $sql = "DELETE FROM produkty WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $id); 

        if ($stmt->execute()) {
            return "Produkt został usunięty.";
        } else {
            return "Błąd podczas usuwania produktu.";
        }
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
            if (!empty($produkt['zdjecie'])) {  
                $imagePath = "../Zdjęcia/" . $produkt['zdjecie']; 
                echo "<img src='$imagePath' alt='{$produkt['tytul']}' class='product-image'>";
            } else {
                echo "<p>Brak zdjęcia</p>";
            }
            echo "<form method='post'>";
            echo "<input type='hidden' name='id_prod' value='{$produkt['id']}'>";
            echo "<input type='hidden' name='tytul' value='{$produkt['tytul']}'>";
            echo "<input type='hidden' name='cena_netto' value='{$produkt['cena_netto']}'>";
            echo "<input type='hidden' name='vat' value='{$produkt['vat']}'>";
            echo "<label>Ilość: <input type='number' name='ilosc' value='1' min='1' max='{$produkt['ilosc']}'></label>";
            echo "<button type='submit' name='add_to_cart'>Dodaj do koszyka</button>";
            echo "</form>";
            echo "</div>";
        }
        echo "</div>";
    }
}


$productManager = new ProductManager(); // Tworzenie obiektu klasy ProductManager
?>
