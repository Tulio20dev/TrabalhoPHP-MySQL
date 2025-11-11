<!DOCTYPE html>
<html lang="pt-br">
<head>
 <meta charset="UTF-8">
 <link rel="stylesheet" href="css/index.css">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title>Novembro azul</title>
</head>
<body>
 <header><h1>Novembro Azul</h1></header>

 <main>
    <section>
        <form action="index.php" method="post"> 
            <label for="nome">Nome</label>
            <input type="text" name="nome" placeholder="Coloque seu nome" required>
            
            <label for="cpf">Digite seu CPF</label>
            <input type="text" name="cpf" minlength="11" maxlength="11" placeholder="xxx.xxx.xxx-xx" required>

            <label for="idade">Idade</label>
            <input type="number" name="idade" required>

            <label for="data">Data do atendimento</label>
            <input type="date" name="data" required>
            
            <input type="submit" value="Enviar">
        </form>
    </section>
</main>

<?php 
if (isset($_POST['cpf'])) {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $idade = $_POST['idade'];
    $data_preferida = $_POST['data'];

    $conn = new mysqli("127.0.0.1", 'root', 'aluno', 'novembroazul', '3307');

    if ($conn->connect_error) {
        die("<p style='color:red;'>Erro na conexão com o banco de dados: " . $conn->connect_error . "</p>");
    }

    // Verifica se o CPF já está cadastrado
    $verifica = "SELECT cpf FROM usuarios WHERE cpf='$cpf'";
    $resultado = $conn->query($verifica);

    if ($resultado && $resultado->num_rows > 0) {
        // se o cpf estiver cadastrado
        echo "<p style='color:orange; font-weight:bold;'>
                ⚠️ Este CPF já possui um cadastro!<br>
                <a href='ConsultarCadastro.php' style='color:blue; text-decoration:underline;'>
                    Clique aqui para consultar seu agendamento.
                </a>
              </p>";
    } else {
        // Insere novo cadastro
        $sql = "INSERT INTO usuarios (nome,cpf,idade,data)
                VALUES ('$nome','$cpf','$idade','$data_preferida')";

        if ($conn->query($sql) === TRUE) {
            echo "<p><strong>Nome:</strong> $nome</p>";
            echo "<p><strong>CPF:</strong> $cpf</p>";
            echo "<p><strong>Idade:</strong> $idade</p>";
            echo "<p><strong>Data:</strong> $data_preferida</p>";
            echo "<p style='color:green; font-weight:bold;'>✅ Agendamento salvo com sucesso no banco de dados!</p><br>";
        } else {
            echo "<p style='color:red;'>❌ Erro ao salvar: " . $conn->error . "</p>";
        }
    }

    $conn->close();
}
?>

<footer>
    <span>Feito por Gabriel, Marco Túlio, Emanuelly e João Pedro</span>
</footer>
</body>
</html>

