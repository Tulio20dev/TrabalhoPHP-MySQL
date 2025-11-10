<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/ConsultarCadastro.css">
    <title>Consultar Meu Cadastro</title>
</head>
<body>
    <header><h1>Novembro Azul</h1></header>

    <?php
    //CONEXÃO COM O BANCO DE DADOS
    $servidor = "127.0.0.1";
    $usuario = "root";
    $senha = "";
    $banco = "novembroazul";
    $porta = '3306';            
    $conn = new mysqli("127.0.0.1",'root','','novembroazul','3306');

    if ($conn->connect_error) {
        die("<p>❌ Erro na conexão com o banco: " . $conn->connect_error . "</p>");
    }

    //VERIFICA SE O FORMULÁRIO FOI ENVIAD
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $cpf = $_POST["cpf"];

        // Evita SQL injection
        $cpf = $conn->real_escape_string($cpf);

        // Consulta o CPF no banco
        $sql = "SELECT nome,cpf,idade,data  FROM usuarios WHERE cpf='$cpf'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            // Encontrou o CPF — mostra os dados
            $dados = $result->fetch_assoc();
            echo "
            <main>
                <section class='mostrarCadastro'>
                    <h1>👋 Seja bem-vindo, {$dados['nome']}!</h1>
                    <p><strong>CPF:</strong> {$dados['cpf']}</p>
                    <p><strong>Idade:</strong> {$dados['idade']}</p>
                    <p><strong>Data de Atendimento:</strong> {$dados['data']}</p>
                </section>
            </main>";
        } else {
            // Não encontrou o CPF
            echo "<p>❌ CPF não encontrado. Cadastre-se primeiro.</p>";
        }
    } else {
        //FORMULÁRIO PARA DIGITAR CPF
        echo "
        <main>
            <section class='consultar'>
                <form action='ConsultarCadastro.php' method='post'>
                    <label for='cpf'>Qual é seu CPF?</label>
                    <input type='text' name='cpf' placeholder='xxx.xxx.xxx-xx' required>
                    <input type='submit' value='Pesquisar'>
                </form>
            </section>
        </main>";
    }

    $conn->close();
    ?>
<a href="index.php">Quer fazer outro cadastro? CLIQUE AQUI</a>
    <footer>
        <span>Feito por Gabriel, Marco Túlio, Emanuelly e João Pedro</span>
    </footer>
</body>
</html>
