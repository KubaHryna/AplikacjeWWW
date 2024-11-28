<!DOCTYPE html>
<head>
    <!-- Tytuł strony i ustawienie bazowej ścieżki do zasobów -->
    <title>Infiltracja</title>
    <base href="/moj_projekt/">

    <!-- Załączenie pliku CSS i ustawienie favicon -->
    <link rel="stylesheet" href="Podstrony/Infiltracja/infiltracja.css">
    <link rel="icon" href="Zdjęcia/Icon.ico" sizes="32x32" type="image/x-icon">
</head>

<body>
    <!-- Główna zawartość strony, wczytanie pliku HTML -->
    <div class="wrapper">
       <?php
       include("../../html/infiltracja.html");  
       ?>
    </div>

    <!-- Wyświetlanie informacji o autorze w PHP -->
    <?php
     $nr_indeksu = '169245';    
     $nrGrupy = 'ISI2';         
     echo 'Autor: Jakub Hryniewicz '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />'; 
    ?> 
</body>
