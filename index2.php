<?php

$host = 'localhost';
$db   = 'evento';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === 'POST') {

       
        $titulo = $_POST['titulo'] ?? '';
        $autores = $_POST['autores'] ?? '';
        $orientador = $_POST['orientador'] ?? '';
        $comentarios = $_POST['comentarios'] ?? '';
        
       
        if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
            $fileTmpPath = $_FILES['arquivo']['tmp_name'];
            $fileName = $_FILES['arquivo']['name'];
            $fileSize = $_FILES['arquivo']['size'];
            $fileType = $_FILES['arquivo']['type'];

            
            $uploadDir = 'uploads/';
            $filePath = $uploadDir . $fileName;

           
            if (move_uploaded_file($fileTmpPath, $filePath)) {
                echo "Arquivo enviado com sucesso!";
            } else {
                echo "Erro ao enviar o arquivo.";
                exit;
            }
        } else {
            echo "Por favor, envie um arquivo.";
            exit;
        }

      
        if (!empty($titulo) && !empty($autores) && !empty($orientador) && !empty($comentarios)) {
            $stmt = $pdo->prepare("INSERT INTO artigos (titulo, autores, orientador, arquivo, comentarios) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$titulo, $autores, $orientador, $filePath, $comentarios]);

            echo "Artigo enviado com sucesso!";
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