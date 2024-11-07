<!DOCTYPE html>
<?
 error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

 if($_GET['idp'] == 'HomePage') $strona = '/html/glowna.html';
 if($_GET['idp'] == 'ForrestGump') $strona = '/Podstrony/ForrestGump/forrest_gump.html';
 if($_GET['idp'] == 'Infiltracja') $strona = '/Podstrony/Infiltracja/infiltracja.html';
 if($_GET['idp'] == 'Oppenheimer') $strona = '/Podstrony/Oppenheimer/oppenheimer.html';
 if($_GET['idp'] == 'Parasite') $strona = '/Podstrony/Parasite/parasite.html';
 if($_GET['idp'] == 'Titanic') $strona = '/Podstrony/Titanic/titanic.html';
 if($_GET['idp'] == 'Gale Oscarowe') $strona = '/Podstrony/filmy/films.html';
?>

    <head>
        <link rel="stylesheet" href="style.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <link rel="icon" href="Zdjęcia/Icon.ico" sizes="32x32" type="image/x-icon">
        <title>Filmy Oscarowe</title>
        <script src="JS/timedate.js" type="text/javascript"></script>
        <script src="JS/information.js" type="text/javascript"></script>
        </head>
    <div class="wrapper">
       <?php 
       if (file_exists($strona)){
        include($strona);
       }else{
        echo "Podstrona nie istnieje";
       }
       ?>
    </div>
    

