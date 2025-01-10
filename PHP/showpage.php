<?php
// *********************************************
// Załączenie pliku konfiguracyjnego bazy danych
// *********************************************
include_once("cfg.php");

// *********************************************
// Funkcja wyświetlająca treść podstrony
// *********************************************
function PokazPodstrone($pageTitle) {
    global $link; // Użycie globalnego połączenia do bazy danych

    // Zabezpieczenie parametru podstrony przed atakami SQL Injection
    $pageTitle = $link->real_escape_string($pageTitle);

    // Zapytanie SQL pobierające treść podstrony na podstawie tytułu
    $query = "SELECT page_content FROM page_list WHERE page_title = '$pageTitle' AND status = 1 LIMIT 1";
    $result = $link->query($query);

    // *********************************************
    // Obsługa wyników zapytania
    // *********************************************
    if ($result && $result->num_rows > 0) 
    {
        // Wyświetlenie zawartości podstrony, jeśli istnieje
        $row = $result->fetch_assoc();
        echo $row['page_content'];
    } 
    else 
    {
        // Komunikat, gdy strona nie została znaleziona lub jest nieaktywna
        echo "<p>Strona nie została znaleziona lub jest nieaktywna.</p>";
    }

    // Zwolnienie pamięci zajmowanej przez wyniki zapytania
    $result->free();
}
?>
