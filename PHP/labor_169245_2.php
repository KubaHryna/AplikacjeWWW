

<?php
    $nr_indeksu='169245';
    $nrGrupy='2';

    echo 'Jakub Hryniewicz, numer indeksu: ' .$nr_indeksu. ', grupa: ' .$nrGrupy. '<br/><br/>';

    echo 'Zastosowanie metody include()<br/><br/>';
	
	echo 'Metoda Include<br/>';
	
	echo 'Przed zastosowaniem metody include/require_once: ';
	
	echo "To jest $kolor $owoc <br/>";
	
	include 's1.php';
	
	echo 'Po zastosowaniu metody include/require_once: ';
	echo "To jest $kolor $owoc<br/>";
	
	echo 'Zastosowanie warunków<br/>';
	
	$liczba=15;
	
	if($liczba > 10)
		echo "Liczba jest większa od 10<br/>";
	elseif($liczba == 10)
		echo "Liczba jest równa  10<br/>";
	else
		echo "Liczba jest mniejsza od 10<br/>";
	
	echo 'Zastosowanie Switch<br/>';
	
	$imie='Gonzalez';
	
	switch($imie){
		case 'Wiktor' :
			echo 'Cześć Wiktor !<br/>';
			break;
		case 'Kuba' :
			echo 'Cześć Kuba !<br/>';
			break;
		case 'Jan' :
			echo 'Cześć Jan !<br/>';
			break;
		
		default:
			echo 'Nie znam takiego imienia<br/>';
			
	}

echo 'Zastosowanie pętli while: ';	
	$i = 1;
while ($i <= 10) {
    echo $i++ . ' ';  
}
echo '<br/>';

echo 'Zastosowanie pętli for: ';
for ($x = 1; $x <= 10; $x++) {
    echo $x . ' ';
}
echo '<br/>';

echo 'Zastosowanie typu zmiennych $_GET<br/>';
echo 'Hello ' .htmlspecialchars($_GET["name"]). '!';
?>