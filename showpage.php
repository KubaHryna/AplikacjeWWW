<?php
include_once("cfg.php"); 

function PokazPodstrone($pageTitle) {
    global $link; 

    $pageTitle = $link->real_escape_string($pageTitle);

    $query = "SELECT page_content FROM page_list WHERE page_title = '$pageTitle' AND status = 1 LIMIT 1";
    $result = $link->query($query);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['page_content'];
    } else {
        echo "<p>Strona nie została znaleziona lub jest nieaktywna.</p>";
    }

    $result->free();
}

?>
