<?php
// Configurações do banco de dados
$host = 'localhost';
$dbname = 'registro_marca';
$username = 'root'; // Altere se necessário
$password = 'Senai@118'; // Altere se necessário

try {
    // Conectar ao banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Criar uma nova marca (Create)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nova_marca'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $segmento = trim($_POST['segmento']);
    $marca = trim($_POST['marca']);
    
    if (!empty($nome) && !empty($email) && !empty($telefone) && !empty($segmento) && !empty($marca)) {
        $stmt = $pdo->prepare("INSERT INTO marcas (nome, email, telefone, segmento, marca) VALUES (:nome, :email, :telefone, :segmento, :marca)");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':segmento', $segmento);
        $stmt->bindParam(':marca', $marca);
        $stmt->execute();
    }
}

// Atualizar uma marca (Update)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_marca'])) {
    $id = (int)$_POST['id_marca'];
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $telefone = trim($_POST['telefone']);
    $segmento = trim($_POST['segmento']);
    $marca = trim($_POST['marca']);
    
    if (!empty($nome) && !empty($email) && !empty($telefone) && !empty($segmento) && !empty($marca)) {
        $stmt = $pdo->prepare("UPDATE marcas SET nome = :nome, email = :email, telefone = :telefone, segmento = :segmento, marca = :marca WHERE id = :id");
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':segmento', $segmento);
        $stmt->bindParam(':marca', $marca);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}

// Deletar uma marca (Delete)
if (isset($_GET['excluir'])) {
    $id = (int)$_GET['excluir'];
    $stmt = $pdo->prepare("DELETE FROM marcas WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Buscar todas as marcas (Read)
$stmt = $pdo->query("SELECT * FROM marcas ORDER BY id DESC");
$marcas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Marcas</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color:rgba(102, 219, 116, 0.74);
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        form input[type="text"], form input[type="email"] {
            width: 98%;
            padding: 12px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        form button {
            background-color: #4CAF50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        form button:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        th, td {
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f1f1f1;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a {
            color: #ff3333;
            text-decoration: none;
            font-size: 14px;
        }
        a:hover {
            color: #c70000;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Lista de Marcas (CRUD PHP + MySQL)</h2>

        <!-- Formulário para adicionar nova marca -->
        <form method="POST">
            <input type="text" name="nome" required placeholder="Nome Completo">
            <input type="email" name="email" required placeholder="E-mail">
            <input type="text" name="telefone" required placeholder="Telefone">
            <input type="text" name="segmento" required placeholder="Segmento">
            <input type="text" name="marca" required placeholder="Marca">
            <button type="submit" name="nova_marca">Adicionar Marca</button>
        </form>

        <!-- Tabela para exibir as marcas -->
        <table>
            <thead>
                <tr>
                    
                    <th>Nome Completo</th>
                    <th>E-mail</th>
                    <th>Telefone</th>
                    <th>Segmento</th>
                    <th>Marca</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($marcas as $marca): ?>
                    <tr>
                       
                        <td><?php echo htmlspecialchars($marca['nome']); ?></td>
                        <td><?php echo htmlspecialchars($marca['email']); ?></td>
                        <td><?php echo htmlspecialchars($marca['telefone']); ?></td>
                        <td><?php echo htmlspecialchars($marca['segmento']); ?></td>
                        <td><?php echo htmlspecialchars($marca['marca']); ?></td>
                        <td>
                            <a href="?editar=<?php echo $marca['id']; ?>">🖍️ Editar</a>
                            <a href="?excluir=<?php echo $marca['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?');">❌ Excluir</a>
                        </td>
                    </tr>
                    <!-- Formulário de edição (aparece somente quando a marca está sendo editada) -->
                    <?php if (isset($_GET['editar']) && $_GET['editar'] == $marca['id']): ?>
                        <form method="POST">
                            <input type="hidden" name="id_marca" value="<?php echo $marca['id']; ?>">
                            <tr>
                                <td><?php echo htmlspecialchars($marca['id']); ?></td>
                                <td><input type="text" name="nome" value="<?php echo htmlspecialchars($marca['nome']); ?>" required></td>
                                <td><input type="email" name="email" value="<?php echo htmlspecialchars($marca['email']); ?>" required></td>
                                <td><input type="text" name="telefone" value="<?php echo htmlspecialchars($marca['telefone']); ?>" required></td>
                                <td><input type="text" name="segmento" value="<?php echo htmlspecialchars($marca['segmento']); ?>" required></td>
                                <td><input type="text" name="marca" value="<?php echo htmlspecialchars($marca['marca']); ?>" required></td>
                                <td>
                                    <button type="submit" name="editar_marca">Salvar</button>
                                    <a href="?">❌ Cancelar</a>
                                </td>
                            </tr>
                        </form>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
