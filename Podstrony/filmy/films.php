<!DOCTYPE html>
<html lang="pl">

<head>
    <!-- Tytuł strony -->
    <title>Gale Oscarowe</title>

    <!-- Ustawienie podstawowego adresu względnego -->
    <base href="/moj_projekt/">

    <!-- Ikona strony -->
    <link rel="icon" href="Zdjęcia/Icon.ico" sizes="32x32" type="image/x-icon">
</head>

<body>
    <div>
        <!-- Wczytywanie zewnętrznego pliku HTML -->
        <?php
        include("../../html/oscars.html"); 
        ?>
    </div>

    <!-- Wyświetlanie informacji o autorze -->
    <?php
    $nr_indeksu = '169245';
    $nrGrupy = 'ISI2';
    echo 'Autor: Jakub Hryniewicz ' . $nr_indeksu . ' grupa ' . $nrGrupy . ' <br /><br />';
    ?>

</body>
</html>
