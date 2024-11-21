<?php

class FormularzKontaktowy {

    public function PokazKontakt() {
        echo '<form action="contact.php" method="POST">';
        echo '<label for="name">Imię:</label><br>';
        echo '<input type="text" id="name" name="name" required><br><br>';
        echo '<label for="email">E-mail:</label><br>';
        echo '<input type="email" id="email" name="email" required><br><br>';
        echo '<label for="message">Wiadomość:</label><br>';
        echo '<textarea id="message" name="message" required></textarea><br><br>';
        echo '<input type="submit" name="submit" value="Wyślij">';
        echo '</form>';
    }

    public function WyslijMailKontakt() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $message = htmlspecialchars($_POST['message']);

        
            if (empty($name) || empty($email) || empty($message)) {
                echo "Wszystkie pola muszą być wypełnione!";
                return;
            }


            $to = 'admin@example.com';
            $subject = 'Wiadomość kontaktowa od ' . $name;
            $body = "Imię: $name\nE-mail: $email\n\nWiadomość:\n$message";
            $headers = 'From: ' . $email . "\r\n" .
                       'Reply-To: ' . $email . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();

            if (mail($to, $subject, $body, $headers)) {
                echo 'Wiadomość została wysłana!';
            } else {
                echo 'Wystąpił błąd podczas wysyłania wiadomości.';
            }
        }
    }

    public function PrzypomnijHaslo() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
            $email = htmlspecialchars($_POST['email']);

    
            if (empty($email)) {
                echo "Proszę podać e-mail.";
                return;
            }

            $to = $email;
            $subject = 'Przypomnienie hasła do panelu admina';
            $body = "Twoje hasło do panelu admina to: 'admin'"; 
            $headers = 'From: admin@example.com' . "\r\n" .
                       'Reply-To: admin@example.com' . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();

            if (mail($to, $subject, $body, $headers)) {
                echo 'Wiadomość z przypomnieniem hasła została wysłana!';
            } else {
                echo 'Wystąpił błąd podczas wysyłania wiadomości.';
            }
        }

        echo '<form action="contact.php" method="POST">';
        echo '<label for="email">E-mail:</label><br>';
        echo '<input type="email" id="email" name="email" required><br><br>';
        echo '<input type="submit" name="submit" value="Przypomnij hasło">';
        echo '</form>';
    }
}

$FormularzKontaktowy = new FormularzKontaktowy();

if (isset($_POST['submit'])) {
    if ($_POST['submit'] == 'Wyślij') {
        $FormularzKontaktowy->WyslijMailKontakt();
    } elseif ($_POST['submit'] == 'Przypomnij hasło') {
        $FormularzKontaktowy->PrzypomnijHaslo();
    }
} else {
    $FormularzKontaktowy->PokazKontakt();
}

?>
<!DOCTYPE html>
<head>
<link rel="stylesheet" type="text/css" href="contact.css">
</head>
</html>