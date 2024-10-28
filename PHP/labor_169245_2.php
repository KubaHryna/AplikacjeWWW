<?php
    $nr_indeksu='169245';
    $nrGrupy='2';

    echo 'Jakub Hryniewicz ' .$nr_indeksu. ' grupa: ' .$nrGrupy. '<br /><br />';

    
    echo 'Zastosowanie metody include() <br />';
    echo 'Przed zastosowaniem metody: ';
    echo 'A ' .$color. ' ' .$fruit. '<br/>'; 

    include 's1.php';
    echo 'Po zastosowaniu metody: ';
    echo 'A ' .$color. ' ' .$fruit. '<br/>'; 

    echo 'Warunki if, else, elseif,switch: <br/>';

    $wartość = 12;
    if($wartość > 10){
        echo 'Twoja wartość jest większa niż 10. <br/>';
    }
    elseif($wartość < 10 ){
        echo 'Twoja wartość jest mniejsza niż 10. <br/>';
    }
    else{
        echo 'Twoja wartość jest równa 10. <br/>';
    }
    echo '<br/> Uzycie switcha: <br/>';
    $imie = 'Jan';
    switch ($imie) {
        case 'Kuba':
            echo 'Witaj Kuba <br/>';
            break;
        case 'Wiktor':
            echo 'Witaj Wiktor <br/>';
            break;
        case 'Jan':
            echo 'Witaj Jan <br/>';
            break;    
        default:
        echo 'Nie znam takiego imienia <br/>';
}

    echo 'Zastosowanie pętli while i for: <br/>';

    $i = 1;
    echo 'Pętla While : ';
    while ($i <= 10) {
    echo ' '.$i++;
    }
    echo '<br/>';
    echo 'Pętla for : ';
    for($i = 1; $i <= 10; $i++){
        echo ' '.$i ;
    }    
    echo '<br/>';
    
    if (isset($_GET["imie"])) {
        echo 'Hello ' . htmlspecialchars($_GET["imie"]) . '!';
    } else {
        echo 'Hello, guest!<br/>';
    }
    
    
    $_POST['name'] = 'Kuba'; 
    echo 'Imię: '.$_POST['name'];
    
    

    session_start();  

if (isset($_GET['imie'])) {
    $_SESSION['imie'] = htmlspecialchars($_GET['imie']);
}


if (isset($_SESSION['imie'])) {
    $imie = $_SESSION['imie'];
    echo "<h2>Witaj ponownie, $imie! Miło Cię widzieć!</h2>";
}

?>