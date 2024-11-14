<?php
    $dbhost = 'localhost' ;
    $dbuser = 'root' ;
    $dbpass = '';
    $baza = 'moja_strona';

    $link = new mysqli($dbhost,$dbuser,$dbpass, $baza);

    if ($link->connect_error) {
        die('<b>Połączenie przerwane: </b>' . $link->connect_error);
    }

?>