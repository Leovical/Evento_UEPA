<?php

$host = 'localhost';
$db   = 'evento';
$user = 'root';
$pass = 'root';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

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
            
            echo "<script type='text/javascript'>alert('Inscrição realizada com sucesso!');</script>";
        } else {
            echo "<script type='text/javascript'>alert('Por favor, preencha todos os campos obrigatórios.');</script>";
        }
    } else {
        echo "Método de requisição inválido.";
    }
} catch (PDOException $e) {
    echo "Ocorreu um erro ao processar sua solicitação. Tente novamente mais tarde.";
}
?>
