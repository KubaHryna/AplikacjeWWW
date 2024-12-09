<?php
include 'admin/admin.php';

class CategoryManager {
    private $db;

    public function __construct() {
        $this->db = new mysqli('localhost', 'root', '', 'moja_strona');
        if ($this->db->connect_error) {
            die("Connection failed: " . $this->db->connect_error);
        }
    }

    public function DodajKategorie($nazwa, $matka = 0) {
        $stmt = $this->db->prepare("INSERT INTO categories (nazwa, matka) VALUES (?, ?)");
        $stmt->bind_param("si", $nazwa, $matka);
        $stmt->execute();
        $stmt->close();
    }

    public function UsunKategorie($id) {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE matka = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }

    public function EdytujKategorie($id, $nowaNazwa) {
        $stmt = $this->db->prepare("UPDATE categories SET nazwa = ? WHERE id = ?");
        $stmt->bind_param("si", $nowaNazwa, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function PokazKategorie() {
        $kategorie = $this->db->query("SELECT * FROM categories ORDER BY matka, id");
        $drzewo = [];

        while ($row = $kategorie->fetch_assoc()) {
            $drzewo[$row['matka']][] = $row;
        }

        $this->wyswietlKategorie(0, $drzewo);
    }

    private function wyswietlKategorie($matka, $drzewo, $poziom = 0) {
        if (!isset($drzewo[$matka])) return;

        foreach ($drzewo[$matka] as $kategoria) {
            echo str_repeat("--", $poziom) . " " . $kategoria['nazwa'] . "<br>";
            $this->wyswietlKategorie($kategoria['id'], $drzewo, $poziom + 1);
        }
    }
}
?>
