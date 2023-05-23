<?php
$host = 'your_host';
$dbName = 'your_database_name';
$username = 'your_username';
$password = 'your_password';

$pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8", $username, $password);

function saveFormSubmission($name, $email, $message, $pdo)
{
    $sql = "INSERT INTO contact_form (name, email, message) VALUES (:name, :email, :message)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':message', $message);
    $stmt->execute();
}

function sendEmailNotification($name, $email, $message)
{
    $to = 'your_email@example.com';
    $subject = 'New Contact Form Submission';
    $body = "Name: $name\nEmail: $email\n\n$message";
    $headers = "From: $email";
    mail($to, $subject, $body, $headers);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    saveFormSubmission($name, $email, $message, $pdo);

    sendEmailNotification($name, $email, $message);

    header('Location: thank-you.php');
    exit;
}
?>
