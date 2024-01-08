<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="alterar_produto.css">
        <title>Alterar Produto</title>
    </head>
    <body>
        <?php
            $servidor = "localhost";
            $banco = "controle_vendas_estoque";
            $usuario = "root";
            $senha = "";

            try {
                $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
                $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    // Verificar se o ID do produto foi fornecido na URL
                    if (isset($_GET['id'])) {
                        $produtoId = $_GET['id'];

                        // Consultar o produto com base no ID
                        $sqlConsultaProduto = "SELECT * FROM cadastro_produtos WHERE id = :id";
                        $stmtConsultaProduto = $conexao->prepare($sqlConsultaProduto);
                        // $stmtConsultaProduto->bindParam(':id', $produtoId);
                        $stmtConsultaProduto->bindParam(':id', $produtoId, PDO::PARAM_INT);
                        $stmtConsultaProduto->execute();

                        $produto = $stmtConsultaProduto->fetch(PDO::FETCH_ASSOC);

                        if (!$produto) {
                            echo "Produto não encontrado.";
                            exit();
                        }
                    } else {
                        echo "ID do produto não fornecido.";
                        exit();
                    }
                }

            } catch (PDOException $e) {
                echo "Erro na conexão: " . $e->getMessage();
            }
        ?>

        <h1>Alterar Produto</h1>

        <form method="POST" action="processar_alteracao.php">
            <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">

            <label for="marca">Marca:</label>
            <input type="text" id="marca" name="marca" value="<?php echo $produto['marca']; ?>">

            <label for="modelo">Modelo:</label>
            <input type="text" id="modelo" name="modelo" value="<?php echo $produto['modelo']; ?>">

            <label for="cor">Cor:</label>
            <input type="text" id="cor" name="cor" value="<?php echo $produto['cor']; ?>">

            <label for="numero_serie">Número de Série:</label>
            <input type="text" id="numero_serie" name="numero_serie" value="<?php echo $produto['numero_serie']; ?>">

            <label for="imei_1">IMEI 1:</label>
            <input type="text" id="imei_1" name="imei_1" value="<?php echo $produto['imei_1']; ?>">

            <label for="imei_2">IMEI 2:</label>
            <input type="text" id="imei_2" name="imei_2" value="<?php echo $produto['imei_2']; ?>">

            <label for="valor_compra">Valor Compra:</label>
            <input type="text" id="valor_compra" name="valor_compra" value="<?php echo $produto['valor_compra']; ?>">

            <label for="data_compra">Data da Compra:</label>
            <input type="date" id="data_compra" name="data_compra" value="<?php echo $produto['data_compra']; ?>">

            <label for="fornecedor">Fornecedor:</label>
            <input type="text" id="fornecedor" name="fornecedor" value="<?php echo $produto['fornecedor']; ?>">

            <label for="situacao">Status:</label>
            <select id="situacao" name="situacao">
                <option value="disponivel" <?php echo ($produto['situacao'] == 'disponivel') ? 'selected' : ''; ?>>Disponível</option>
                <option value="indisponivel" <?php echo ($produto['situacao'] == 'indisponivel') ? 'selected' : ''; ?>>Indisponível</option>
                <option value="vendido" <?php echo ($produto['situacao'] == 'vendido') ? 'selected' : ''; ?>>Vendido</option>
            </select>

            <label for="observacoes">Observações:</label>
            <textarea id="observacoes" name="observacoes" rows="4">
                <?php echo $produto['observacoes']; ?>
            </textarea>

            <button type="submit">Salvar Alterações</button>

            <a href="produtos.php"><button>Voltar para a lista de produtos</button></a>
        </form>

    </body>
</html>