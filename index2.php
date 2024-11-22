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

    // Verifica se a requisição é POST
    if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] === 'POST') {

        // Obtém os dados do formulário
        $titulo = $_POST['titulo'] ?? '';
        $autores = $_POST['autores'] ?? '';
        $orientador = $_POST['orientador'] ?? '';
        $comentarios = $_POST['comentarios'] ?? '';

        // Verifica se um arquivo foi enviado
        if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] === 0) {
            $fileTmpPath = $_FILES['arquivo']['tmp_name'];
            $fileName = $_FILES['arquivo']['name'];
            $fileSize = $_FILES['arquivo']['size'];
            $fileType = $_FILES['arquivo']['type'];

            // Define o diretório de upload e verifica se existe
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filePath = $uploadDir . $fileName;

            // Move o arquivo para o diretório de uploads
            if (!move_uploaded_file($fileTmpPath, $filePath)) {
                echo "Erro ao mover o arquivo para o diretório de uploads.";
                exit;
            }
        } else {
            echo "Erro no envio do arquivo. Código de erro: " . ($_FILES['arquivo']['error'] ?? 'Nenhum arquivo enviado.');
            exit;
        }

        // Verifica se todos os campos obrigatórios foram preenchidos
        if (!empty($titulo) && !empty($autores) && !empty($orientador) && !empty($comentarios)) {
            $stmt = $pdo->prepare("INSERT INTO artigos (titulo, autores, orientador, arquivo, comentarios) VALUES (?, ?, ?, ?, ?)");

            // Tenta executar a query e verifica se foi bem-sucedida
            if ($stmt->execute([$titulo, $autores, $orientador, $filePath, $comentarios])) {
                // Exibe apenas a mensagem de sucesso
                echo "Artigo enviado com sucesso!";
            } else {
                echo "Erro ao salvar artigo no banco de dados.";
            }
        } else {
            echo "Por favor, preencha todos os campos obrigatórios.";
        }
    } else {
        echo "Método de requisição inválido.";
    }
} catch (PDOException $e) {
    // Exibe mensagens de erro do banco de dados em caso de falha
    echo "Erro na conexão ou execução no banco de dados: " . $e->getMessage();
}
?>