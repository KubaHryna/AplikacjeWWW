<?php
session_start();
include('../cfg.php');

function FormularzLogowania() {
    $form = '
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
    
    return $form;
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
    
    while($row = $result->fetch_assoc()) {
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

function EdytujPodstrone($id = null) {
    global $link;
    
    $title = '';
    $content = '';
    $status = 1;
    
    if($id) {
        $query = "SELECT * FROM page_list WHERE id = ?";
        $stmt = $link->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()) {
            $title = $row['page_title'];
            $content = $row['page_content'];
            $status = $row['status'];
        }
    }
    
    $form = '
    <div class="edit-form">
        <h2>'.($id ? 'Edytuj' : 'Dodaj').' podstronę</h2>
        <form method="post" action="admin.php">
            <input type="hidden" name="id" value="'.($id ?? '').'">
            <div>
                <label>Tytuł:</label>
                <input type="text" name="page_title" value="'.$title.'" required>
            </div>
            <div>
                <label>Treść:</label>
                <textarea name="page_content" rows="10" required>'.$content.'</textarea>
            </div>
            <div>
                <label>
                    <input type="checkbox" name="status" value="1" '.($status ? 'checked' : '').'>
                    Strona aktywna
                </label>
            </div>
            <input type="submit" name="'.($id ? 'edytuj' : 'dodaj').'" value="'.($id ? 'Zapisz zmiany' : 'Dodaj stronę').'">
        </form>
    </div>';
    
    return $form;
}

function DodajNowaPodstrone() {
    global $link;

    if (isset($_POST['dodaj'])) {
        $title = $_POST['page_title'];
        $content = $_POST['page_content'];
        $status = isset($_POST['status']) ? 1 : 0;

        $query = "INSERT INTO page_list (page_title, page_content, status) VALUES (?, ?, ?)";
        $stmt = $link->prepare($query);
        $stmt->bind_param('ssi', $title, $content, $status);

        if ($stmt->execute()) {
            return "Dodano nową podstronę.";
        } else {
            return "Błąd podczas dodawania podstrony.";
        }
    }

    return EdytujPodstrone();
}

     

function UsunPodstrone($id) {
    global $link;
    
    $query = "DELETE FROM page_list WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param('i', $id);
    
    if($stmt->execute()) {
        return "Podstrona została usunięta.";
    } else {
        return "Błąd podczas usuwania podstrony.";
    }
}

$message = '';

if(isset($_POST['logowanie'])) {
    if($_POST['login'] === $login && $_POST['pass'] === $pass) {
        $_SESSION['logged_in'] = true;
    } else {
        $message = "Błędny login lub hasło!";
    }
}

if(isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header('Location: admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Panel administracyjny</title>
    <style>
        .login-form, .admin-list, .edit-form { 
            max-width: 800px; 
            margin: 20px auto; 
            padding: 20px; 
        }
        .message { 
            color: red; 
            margin: 10px 0; 
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .edit-form textarea {
            width: 100%;
            margin: 10px 0;
        }
        .edit-form input[type="text"] {
            width: 100%;
            padding: 5px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <?php
    if(!empty($message)) {
        echo '<div class="message">'.$message.'</div>';
    }

    if(!isset($_SESSION['logged_in'])) {
        echo FormularzLogowania();
    } else {
        echo '<div style="text-align: right;"><a href="admin.php?action=logout">Wyloguj</a></div>';
        
        if(isset($_GET['action'])) {
            switch($_GET['action']) {
                case 'edytuj':
                    if(isset($_POST['edytuj'])) {
                    
                        $id = $_POST['id'];
                        $title = $_POST['page_title'];
                        $content = $_POST['page_content'];
                        $status = isset($_POST['status']) ? 1 : 0;
                        
                        $query = "UPDATE page_list SET page_title = ?, page_content = ?, status = ? WHERE id = ?";
                        $stmt = $link->prepare($query);
                        $stmt->bind_param('ssii', $title, $content, $status, $id);
                        
                        if($stmt->execute()) {
                            echo "Zmiany zostały zapisane.";
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
    }
    ?>
</body>
</html>
