<?php
// Configuração de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "Senai@118";
$dbname = "registro_marca";

$sucesso = false;  // Inicializando como false
$erro = false;     // Inicializando como false

try {
    // Criando a conexão com o banco de dados
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Definindo o modo de erro do PDO
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Falha na conexão: " . $e->getMessage();
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitização dos dados para evitar SQL Injection
    $name = htmlspecialchars(trim($_POST['name']));  // Corrigido para usar 'name' no lugar de 'nome'
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $segment = htmlspecialchars(trim($_POST['segment']));
    $marca = htmlspecialchars(trim($_POST['marca']));

    // Validar se todos os campos estão preenchidos
    if (empty($name) || empty($email) || empty($phone) || empty($segment) || empty($marca)) {
        $erro = true;  // Define que houve erro
    } else {
        // Inserir os dados no banco de dados
        $sql = "INSERT INTO marcas (nome, email, telefone, segmento, marca) 
                VALUES (:nome, :email, :telefone, :segmento, :marca)";

        // Preparar e executar a consulta SQL
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $phone);
        $stmt->bindParam(':segmento', $segment);
        $stmt->bindParam(':marca', $marca);

        // Executar a consulta
        if ($stmt->execute()) {
            $sucesso = true;  // Define que o envio foi bem-sucedido
        } else {
            $erro = true;  // Define que houve erro na execução
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário de Registro</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <section>
        <div class="main-form-container">
            <div class="form-container">
                <h2>Registro da Marca </h2>
                <form method="POST" enctype="multipart/form-data">
                    <label for="name">Nome Completo:</label>
                    <input type="text" id="name" name="name" placeholder="Digite seu nome" required>

                    <label for="email">Email:</label>
                    <input type="text" id="email" name="email" placeholder="Digite seu email" required>

                    <label for="phone">Telefone:</label>
                    <input type="text" id="phone" name="phone" placeholder="Digite seu telefone" required>

                    <label for="segment">Segmento da Marca:</label>
                    <div class="teste">
                        <select id="segment" name="segment" class="selecc" required>
                            <option value="">Selecione um segmento</option>
                            <option value="Tecnologia">Tecnologia</option>
                            <option value="Alimentação">Alimentação</option>
                            <option value="Moda">Moda</option>
                            <option value="Serviços">Serviços</option>
                            <option value="Educação">Educação</option>
                        </select>
                    </div>

                    <input type="text" name="marca" id="marca" placeholder="Sua Marca" required>
                    <button type="submit" id="myBtn">Enviar</button>
                </form>

                <!-- Modal -->
                <div id="myModal" class="modal" style="display: none;">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <p id="modalMessage"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script class="modall">
        // Modal
        var modal = document.getElementById("myModal");
        var span = document.getElementsByClassName("close")[0];
        var modalMessage = document.getElementById("modalMessage");

        <?php if ($sucesso): ?>
            modal.style.display = "block"; 
            modalMessage.innerText = "Suas informações foram enviadas";
        <?php elseif ($erro): ?>
            modal.style.display = "block"; 
            modalMessage.innerText = "Ocorreu um erro ao enviar os dados. Tente novamente.";
        <?php endif; ?>

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
