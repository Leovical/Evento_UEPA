<?php

$host = 'localhost';
$db   = 'evento';
$user = 'seu_usuario';
$pass = 'sua_senha';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $full_name = $_POST['full-name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $cpf = $_POST['cpf'];
    $position = $_POST['position'];
    $additional_info = $_POST['additional-info'];

    $stmt = $pdo->prepare("INSERT INTO inscricoes (full_name, email, phone, cpf, position, additional_info) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$full_name, $email, $phone, $cpf, $position, $additional_info]);

    header("Location: inscricoes.html");
    exit;
}
?>
