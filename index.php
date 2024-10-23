<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
$host = 'localhost';
$db   = 'evento'; // Verifique se o nome do banco de dados está correto
$user = 'root'; // Usuário padrão do XAMPP
$pass = ''; // Se você não configurou uma senha, deixe como uma string vazia
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset"; // Monta a string DSN

phpinfo();
try {
    // Cria a conexão PDO
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === 'POST') {
        
        $fullName = $_POST['full-name'] ?? '';
        $email = $_POST['email'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $cpf = $_POST['cpf'] ?? '';
        $position = $_POST['position'] ?? '';
        $additionalInfo = $_POST['additional-info'] ?? '';

        // Validação dos campos obrigatórios
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
