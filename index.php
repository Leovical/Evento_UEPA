<?php

$host = 'localhost';
$db   = 'evento';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

phpinfo();
try {

    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === 'POST') {
        
        $fullName = $_POST['full-name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $position = $_POST['position'] ?? '';
        $additionalInfo = $_POST['additional-info'] ?? '';

        if (!empty($fullName) && !empty($email) && !empty($phone) && !empty($cpf) && !empty($position)) {
            $stmt = $pdo->prepare("INSERT INTO participantes (nome, email, telefone, cpf, cargo, info_adicionais) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$fullName, $email, $phone, $cpf, $position, $additionalInfo]);
            
            echo "Inscrição realizada com sucesso!";
        } else {
            echo "Por favor, preencha todos os campos obrigatórios.";
        }
    } else {
        echo "Método de requisição inválido.";
    }
} catch (PDOException $e) {
    print_r($e);
}
?>
