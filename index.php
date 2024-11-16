<?php
include("cfg.php");
?>

<!DOCTYPE html>
<head>
    <base href="/moj_projekt/">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="icon" href="Zdjęcia/Icon.ico" sizes="32x32" type="image/x-icon">
    <title>Filmy Oscarowe</title>
    <script src="JS/timedate.js" type="text/javascript"></script>
    <script src="JS/information.js" type="text/javascript"></script>
</head>
<body>
    <div class="wrapper">
        <?php
        include("showpage.php");
        if (isset($_GET['idp'])) {
            PokazPodstrone($_GET['idp']);
        } else {
            PokazPodstrone('HomePage'); // Wyświetl stronę główną
        }
        ?>
    </div>
</body>
</html>