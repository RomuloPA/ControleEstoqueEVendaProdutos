<?php
$servidor = "localhost";
$banco = "controle_vendas_estoque";
$usuario = "root";
$senha = "";

try {
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Verificar se o parâmetro 'id' foi passado na URL
    if (isset($_GET['id'])) {
        // SQL de exclusão
        $sqlExcluirProduto = ("DELETE FROM cadastro_produtos WHERE id = :id");

        // Preparar a consulta
        $stmt = $conexao->prepare($sqlExcluirProduto);

        // Vincular o valor do parâmetro 'id' à instrução SQL
        $stmt->bindParam(':id', $_GET['id'], PDO::PARAM_INT);

        // Executar a instrução SQL
        $stmt->execute();

        // Redirecionar de volta para a página dos produtos
        header("Location: produtos.php");
        exit();
    } else {
        echo "ID do produto não fornecido.";
    }
} catch (PDOException $e) {
    echo "Erro na exclusão: " . $e->getMessage();
}
?>