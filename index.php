<!DOCTYPE html>
<?php  
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING); 
    
    if(isset($_GET['idp'])) {
        switch($_GET['idp']) {
            case 'HomePage':
                $strona = 'html/glowna.html';
                break;
            case 'ForrestGump':
                $strona = 'Podstrony/ForrestGump/forrest_gump.php';
                break;
            case 'Infiltracja':
                $strona = 'Podstrony/Infiltracja/infiltracja.php';
                break;
            case 'Oppenheimer':
                $strona = 'Podstrony/Oppenheimer/oppenheimer.php';
                break;
            case 'Parasite':
                $strona = 'Podstrony/Parasite/parasite.php';
                break;
            case 'Titanic':
                $strona = 'Podstrony/Titanic/titanic.php';
                break;
            case 'GaleOscarowe':
                $strona = 'Podstrony/filmy/films.php';
                break;
            default:
                $strona = 'html/glowna.html';
        }
    } else {
        $strona = 'html/glowna.html';
    }
?>


    <head>
        <base href="/moj_projekt/">
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="icon" href="Zdjęcia/Icon.ico" sizes="32x32" type="image/x-icon">
        <title>Filmy Oscarowe</title>
        <script src="JS/timedate.js" type="text/javascript"></script>
        <script src="JS/information.js" type="text/javascript"></script>
        </head>
    <div class="wrapper">
        <?php 
            if(file_exists($strona)) {
                include($strona);
            } else {
                include('html/glowna.html');
            }
        ?>

    </div>
    

