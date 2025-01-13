<?php
class CategoryManager {
    private static $instance = null;
    private $db;

    private function __construct() {
        global $link;
        $this->db = $link;
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new CategoryManager();
        }
        return self::$instance;
    }

    // Zabezpieczenie przed klonowaniem
    private function __clone() {}

    public function DodajKategorie($nazwa, $matka = 0) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM categories WHERE nazwa = ? AND matka = ?");
        $stmt->bind_param("si", $nazwa, $matka);
        $stmt->execute();
        $stmt->bind_result($liczba);
        $stmt->fetch();
        $stmt->close();
    
        if ($liczba > 0) {
            return "Kategoria o nazwie '$nazwa' już istnieje dla rodzica o ID $matka.";
        }
    
        $stmt = $this->db->prepare("INSERT INTO categories (nazwa, matka) VALUES (?, ?)");
        $stmt->bind_param("si", $nazwa, $matka);
        $result = $stmt->execute();
        $stmt->close();
        
        return $result ? "Kategoria została dodana." : "Błąd podczas dodawania kategorii.";
    }

    public function UsunKategorie($id) {
        // Najpierw usuwamy podkategorie
        $stmt = $this->db->prepare("DELETE FROM categories WHERE matka = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        // Następnie główną kategorię
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();
        $stmt->close();
        
        return $result ? "Kategoria została usunięta." : "Błąd podczas usuwania kategorii.";
    }

    public function EdytujKategorie($id, $nowaNazwa) {
        $stmt = $this->db->prepare("UPDATE categories SET nazwa = ? WHERE id = ?");
        $stmt->bind_param("si", $nowaNazwa, $id);
        $result = $stmt->execute();
        $stmt->close();
        
        return $result ? "Nazwa kategorii została zmieniona." : "Błąd podczas edycji kategorii.";
    }

    public function PokazKategorie($asSelect = false) {
        $kategorie = $this->db->query("SELECT * FROM categories ORDER BY matka, id");
        
        if ($asSelect) {
            // Dla selecta w formularzu
            $output = '';
            while ($row = $kategorie->fetch_assoc()) {
                $poziom = $this->getPoziomKategorii($row['id']);
                $wciecie = str_repeat("&nbsp;&nbsp;", $poziom);
                $output .= sprintf(
                    '<option value="%d">%s%s</option>',
                    $row['id'],
                    $wciecie,
                    htmlspecialchars($row['nazwa'])
                );
            }
            return $output;
        } else {
            // Dla wyświetlania drzewa kategorii
            $drzewo = [];
            while ($row = $kategorie->fetch_assoc()) {
                $drzewo[$row['matka']][] = $row;
            }
            
            ob_start();
            $this->wyswietlDrzewoKategorii(0, $drzewo);
            return ob_get_clean();
        }
    }

    private function wyswietlDrzewoKategorii($matka, $drzewo, $poziom = 0) {
        if (!isset($drzewo[$matka])) return;

        foreach ($drzewo[$matka] as $kategoria) {
            $wciecie = str_repeat("--", $poziom);
            printf(
                '<div style="margin-left: %dpx; color: white;">%s %s (ID: %d)</div>',
                $poziom * 20,
                $wciecie,
                htmlspecialchars($kategoria['nazwa']),
                $kategoria['id']
            );
            $this->wyswietlDrzewoKategorii($kategoria['id'], $drzewo, $poziom + 1);
        }
    }

    private function getPoziomKategorii($id) {
        $poziom = 0;
        $current_id = $id;
        
        while ($current_id != 0) {
            $result = $this->db->query("SELECT matka FROM categories WHERE id = $current_id");
            if ($row = $result->fetch_assoc()) {
                $current_id = $row['matka'];
                $poziom++;
            } else {
                break;
            }
        }
        
        return $poziom;
    }
}
?>