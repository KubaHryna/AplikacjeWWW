<!DOCTYPE html>
<head>
    <!-- Tytuł strony i ustawienie bazowej ścieżki do zasobów -->
    <title>Oppenheimer</title>
    <base href="/moj_projekt/">

    <!-- Załączenie pliku CSS specyficznego dla strony Oppenheimer oraz czcionki -->
    <link rel="stylesheet" href="Podstrony/Oppenheimer/style_oh.css">
    <link href="https://fonts.cdnfonts.com/css/metropolis-4" rel="stylesheet">

    <!-- Ustawienie favicon dla strony -->
    <link rel="icon" href="Zdjęcia/Icon.ico" sizes="32x32" type="image/x-icon">
</head>

<body>
    <!-- Główna zawartość strony, wczytanie pliku HTML -->
    <div class="wrapper">
        <?php
        include("../../html/Oppenheimer.html"); 
        ?>
    </div>

    <!-- Wyświetlanie informacji o autorze w PHP -->
    <?php
     $nr_indeksu = '169245';   
     $nrGrupy = 'ISI2';         
     echo 'Autor: Jakub Hryniewicz '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />'; 
    ?> 
</body>
