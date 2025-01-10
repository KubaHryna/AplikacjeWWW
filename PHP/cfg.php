<?php
// *********************************************
// Konfiguracja parametrów połączenia z bazą danych
// *********************************************
$dbhost = 'localhost'; // Adres serwera bazy danych
$dbuser = 'root';      // Użytkownik bazy danych
$dbpass = '';          // Hasło użytkownika bazy danych
$baza = 'moja_strona'; // Nazwa bazy danych

// *********************************************
// Dane logowania administratora (przykładowe dane)
// *********************************************
$login = "admin"; // Login administratora
$pass = "admin";  // Hasło administratora

// *********************************************
// Tworzenie połączenia z bazą danych
// *********************************************
$link = new mysqli($dbhost, $dbuser, $dbpass, $baza); // Inicjalizacja obiektu połączenia

// Sprawdzanie poprawności połączenia
if ($link->connect_error) {
    // W przypadku błędu połączenia, wyświetlenie komunikatu i zakończenie skryptu
    die('<b>Połączenie przerwane: </b>' . $link->connect_error);
}

// Połączenie zostało nawiązane pomyślnie, skrypt działa dalej
?>
