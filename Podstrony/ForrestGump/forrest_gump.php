<!DOCTYPE html>
    <head>
        <!-- Tytuł strony wyświetlany w zakładce przeglądarki -->
        <title>Forrest Gump</title>
        
        <!-- Określenie podstawowej ścieżki dla wszystkich linków względnych -->
        <base href="/moj_projekt/">
        
        <!-- Link do pliku CSS dla tej strony -->
        <link rel="stylesheet" href="Podstrony/ForrestGump/style_fg.css">
        
        <!-- Ustawienie ikony strony (favicon) -->
        <link rel="icon" href="Zdjęcia/Icon.ico" sizes="32x32" type="image/x-icon">
    </head>
    <div class="wrapper">
        <!-- Wczytanie zewnętrznego pliku HTML (forrest_gump.html) -->
      <?php
      include("../../html/forrest_gump.html");
      ?>
        
    </div>
    
    <!-- Wyświetlenie informacji o autorze na stronie -->
<?php
 $nr_indeksu = '169245';
 $nrGrupy = 'ISI2';
 echo 'Autor: Jakub Hryniewicz '.$nr_indeksu.' grupa '.$nrGrupy.' <br /><br />';
?> 
