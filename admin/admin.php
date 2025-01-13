<?php
// Rozpoczynamy sesję
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Dołączamy pliki konfiguracyjne
require_once('../PHP/cfg.php');
require_once("../PHP/category_manager.php");
$categoryManager = CategoryManager::getInstance();

// Funkcje pomocnicze
function FormularzLogowania() {
    return '
    <div class="login-form">
        <h2>Logowanie do panelu administracyjnego</h2>
        <form method="post" action="admin.php">
            <div>
                <label>Login:</label>
                <input type="text" name="login" required>
            </div>
            <div>
                <label>Hasło:</label>
                <input type="password" name="pass" required>
            </div>
            <input type="submit" name="logowanie" value="Zaloguj">
        </form>
    </div>';
}

function ListaPodstron() {
    global $link;

    $query = "SELECT * FROM page_list";
    $result = $link->query($query);

    $output = '<div class="admin-list">
        <h2>Lista podstron</h2>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Tytuł</th>
                <th>Akcje</th>
            </tr>';

    while ($row = $result->fetch_assoc()) {
        $output .= '<tr>
            <td>'.$row['id'].'</td>
            <td>'.$row['page_title'].'</td>
            <td>
                <a href="admin.php?action=edytuj&id='.$row['id'].'">Edytuj</a>
                <a href="admin.php?action=usun&id='.$row['id'].'" onclick="return confirm(\'Czy na pewno chcesz usunąć?\')">Usuń</a>
            </td>
        </tr>';
    }

    $output .= '</table>
        <p><a href="admin.php?action=dodaj">Dodaj nową podstronę</a></p>
    </div>';

    return $output;
}

function EdytujPodstrone($id) {
    global $link;
    $query = "SELECT * FROM page_list WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return '<div class="edit-form">
        <h2>Edycja podstrony</h2>
        <form method="post" action="admin.php?action=edytuj&id='.$id.'">
            <input type="hidden" name="id" value="'.$id.'">
            <div>
                <label>Tytuł:</label>
                <input type="text" name="page_title" value="'.htmlspecialchars($row['page_title']).'" required>
            </div>
            <div>
                <label>Zawartość:</label>
                <textarea name="page_content" rows="10" required>'.htmlspecialchars($row['page_content']).'</textarea>
            </div>
            <div>
                <label>
                    <input type="checkbox" name="status" '.($row['status'] ? 'checked' : '').'>
                    Aktywna
                </label>
            </div>
            <input type="submit" name="edytuj" value="Zapisz zmiany">
        </form>
    </div>';
}

function UsunPodstrone($id) {
    global $link;
    $query = "DELETE FROM page_list WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('i', $id);
    
    if ($stmt->execute()) {
        return '<p>Podstrona została usunięta.</p>';
    }
    return '<p>Wystąpił błąd podczas usuwania podstrony.</p>';
}

function DodajNowaPodstrone() {
    return '<div class="edit-form">
        <h2>Dodaj nową podstronę</h2>
        <form method="post" action="admin.php">
            <div>
                <label>Tytuł:</label>
                <input type="text" name="page_title" required>
            </div>
            <div>
                <label>Zawartość:</label>
                <textarea name="page_content" rows="10" required></textarea>
            </div>
            <div>
                <label>
                    <input type="checkbox" name="status" checked>
                    Aktywna
                </label>
            </div>
            <input type="submit" name="dodaj_podstrone" value="Dodaj podstronę">
        </form>
    </div>';
}

function PanelZarzadzaniaKategoriami() {
    global $categoryManager;
    return '<div class="category-management">
        <h2>Zarządzanie kategoriami</h2>
        <form method="post" class="category-form">
            <div>
                <label>Nazwa kategorii:</label>
                <input type="text" name="nazwa" required>
            </div>
            <div>
                <label>Kategoria nadrzędna:</label>
                <select name="matka">
                    <option value="0">Główna kategoria</option>
                    '.$categoryManager->PokazKategorie(true).'
                </select>
            </div>
            <input type="submit" name="dodaj_kategorie" value="Dodaj kategorię">
        </form>

        <form method="post" class="category-form">
            <div>
                <label>ID kategorii do usunięcia:</label>
                <input type="number" name="id" required>
            </div>
            <input type="submit" name="usun_kategorie" value="Usuń kategorię">
        </form>

        <form method="post" class="category-form">
            <div>
                <label>ID kategorii do edycji:</label>
                <input type="number" name="id" required>
            </div>
            <div>
                <label>Nowa nazwa:</label>
                <input type="text" name="nowa_nazwa" required>
            </div>
            <input type="submit" name="edytuj_kategorie" value="Edytuj kategorię">
        </form>

        <div class="category-tree">
            <h3>Struktura kategorii</h3>
            '.$categoryManager->PokazKategorie().'
        </div>
    </div>';
}

// Obsługa formularza logowania
if (isset($_POST['logowanie'])) {
    if ($_POST['login'] === $login && $_POST['pass'] === $pass) {
        $_SESSION['logged_in'] = true;
    } else {
        $message = "Błędny login lub hasło!";
    }
}

// Obsługa wylogowania
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: admin.php');
    exit();
}

// Obsługa formularzy kategorii
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['dodaj_kategorie'])) {
        $message = $categoryManager->DodajKategorie($_POST['nazwa'], $_POST['matka']);
    } elseif (isset($_POST['usun_kategorie'])) {
        $message = $categoryManager->UsunKategorie($_POST['id']);
    } elseif (isset($_POST['edytuj_kategorie'])) {
        $message = $categoryManager->EdytujKategorie($_POST['id'], $_POST['nowa_nazwa']);
    } elseif (isset($_POST['dodaj_podstrone'])) {
        global $link;
        $title = $_POST['page_title'];
        $content = $_POST['page_content'];
        $status = isset($_POST['status']) ? 1 : 0;
        
        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES (?, ?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param('ssi', $title, $content, $status);
        
        if ($stmt->execute()) {
            $message = "Nowa podstrona została dodana.";
        } else {
            $message = "Wystąpił błąd podczas dodawania podstrony.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel administracyjny</title>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #333; }
        .login-form, .admin-list, .edit-form, .category-management { 
            max-width: 800px; 
            margin: 20px auto; 
            padding: 20px;
            background-color: #444;
            border-radius: 5px;
            color: white;
        }
        .message { color: #ffd700; margin: 10px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; background-color: #555; }
        th, td { padding: 8px; text-align: left; border: 1px solid #666; }
        th { background-color: #666; }
        .edit-form textarea { width: 100%; margin: 10px 0; min-height: 200px; }
        .edit-form input[type="text"], .category-form input[type="text"] { 
            width: 100%; 
            padding: 5px; 
            margin: 5px 0; 
        }
        .category-form { margin-bottom: 20px; }
        .category-tree { margin-top: 20px; }
        a { color: #add8e6; }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        input[type="submit"]:hover { background-color: #45a049; }
        .logout { text-align: right; margin: 10px; }
    </style>
</head>
<body>
    <?php if (!empty($message)) { echo '<div class="message">' . htmlspecialchars($message) . '</div>'; } ?>

    <?php if (!isset($_SESSION['logged_in'])): ?>
        <?= FormularzLogowania() ?>
    <?php else: ?>
        <div class="logout"><a href="admin.php?action=logout">Wyloguj</a></div>
        <?php
        if (isset($_GET['action'])) {
            switch ($_GET['action']) {
                case 'edytuj':
                    if (isset($_POST['edytuj'])) {
                        global $link;
                        $id = $_POST['id'];
                        $title = $_POST['page_title'];
                        $content = $_POST['page_content'];
                        $status = isset($_POST['status']) ? 1 : 0;

                        $query = "UPDATE page_list SET page_title = ?, page_content = ?, status = ? WHERE id = ?";
                        $stmt = $link->prepare($query);
                        $stmt->bind_param('ssii', $title, $content, $status, $id);

                        if ($stmt->execute()) {
                            echo "<div class='message'>Zmiany zostały zapisane.</div>";
                        }
                    }
                    echo EdytujPodstrone($_GET['id']);
                    break;

                case 'usun':
                    echo UsunPodstrone($_GET['id']);
                    echo ListaPodstron();
                    break;

                case 'dodaj':
                    echo DodajNowaPodstrone();
                    break;

                default:
                    echo ListaPodstron();
            }
        } else {
            echo ListaPodstron();
        }

        echo PanelZarzadzaniaKategoriami();
        ?>

        <div style="text-align: center; margin: 20px;">
            <a href="../PHP/show_products.php" class="shop-button">Przeglądaj produkty</a>
            <a href="../PHP/add_product.php" class="shop-button">Dodaj produkt</a>
        </div>
    <?php endif; ?>
</body>
</html>