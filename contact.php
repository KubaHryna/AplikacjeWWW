<?php
// *********************************************
// Klasa obsługująca formularz kontaktowy
// *********************************************
class FormularzKontaktowy {

    // *********************************************
    // Wyświetlanie formularza kontaktowego
    // *********************************************
    public function PokazKontakt() 
    {
        // Formularz kontaktowy
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

    // *********************************************
    // Wysyłanie wiadomości e-mail z formularza kontaktowego
    // *********************************************
    public function WyslijMailKontakt() 
    {
        // Obsługa przesłanego formularza metodą POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            // Pobranie i zabezpieczenie danych wejściowych
            $name = htmlspecialchars($_POST['name']); // Zabezpieczenie przed kodem HTML
            $email = htmlspecialchars($_POST['email']);
            $message = htmlspecialchars($_POST['message']);

            // Sprawdzenie, czy wszystkie pola zostały wypełnione
            if (empty($name) || empty($email) || empty($message)) 
            {
                echo "Wszystkie pola muszą być wypełnione!";
                return;
            }

            // Dane e-mail do wysyłki
            $to = 'admin@example.com'; // Docelowy adres e-mail
            $subject = 'Wiadomość kontaktowa od ' . $name;
            $body = "Imię: $name\nE-mail: $email\n\nWiadomość:\n$message";
            $headers = 'From: ' . $email . "\r\n" .
                       'Reply-To: ' . $email . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();

            // Próba wysyłki wiadomości
            if (mail($to, $subject, $body, $headers)) 
            {
                echo 'Wiadomość została wysłana!';
            } 
            else 
            {
                echo 'Wystąpił błąd podczas wysyłania wiadomości.';
            }
        }
    }

    // *********************************************
    // Obsługa przypomnienia hasła
    // *********************************************
    public function PrzypomnijHaslo() 
    {
        // Obsługa formularza przypomnienia hasła
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) 
        {
            // Pobranie i zabezpieczenie adresu e-mail
            $email = htmlspecialchars($_POST['email']);

            // Sprawdzenie, czy e-mail został podany
            if (empty($email)) 
            {
                echo "Proszę podać e-mail.";
                return;
            }

            // Dane e-mail do wysyłki przypomnienia hasła
            $to = $email;
            $subject = 'Przypomnienie hasła do panelu admina';
            $body = "Twoje hasło do panelu admina to: 'admin'"; // Przykładowe hasło
            $headers = 'From: admin@example.com' . "\r\n" .
                       'Reply-To: admin@example.com' . "\r\n" .
                       'X-Mailer: PHP/' . phpversion();

            // Próba wysyłki wiadomości
            if (mail($to, $subject, $body, $headers)) 
            {
                echo 'Wiadomość z przypomnieniem hasła została wysłana!';
            } 
            else 
            {
                echo 'Wystąpił błąd podczas wysyłania wiadomości.';
            }
        }

        // Formularz przypomnienia hasła
        echo '<form action="contact.php" method="POST">';
        echo '<label for="email">E-mail:</label><br>';
        echo '<input type="email" id="email" name="email" required><br><br>';
        echo '<input type="submit" name="submit" value="Przypomnij hasło">';
        echo '</form>';
    }
}

// *********************************************
// Inicjalizacja i obsługa akcji na podstawie formularza
// *********************************************
$FormularzKontaktowy = new FormularzKontaktowy();

// Sprawdzenie, która akcja została wywołana
if (isset($_POST['submit'])) 
{
    // Obsługa różnych typów formularzy
    if ($_POST['submit'] == 'Wyślij') 
    {
        $FormularzKontaktowy->WyslijMailKontakt();
    } 
    elseif ($_POST['submit'] == 'Przypomnij hasło') 
    {
        $FormularzKontaktowy->PrzypomnijHaslo();
    }
} 
else 
{
    // Domyślne wyświetlanie formularza kontaktowego
    $FormularzKontaktowy->PokazKontakt();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="contact.css">
</head>
</html>
