<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="adicionar_produto.css">
        <title>Adicionar Venda</title>
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

                // Nova consulta para obter os resultados
                $stmtProdutos = $conexao->prepare("SELECT id, valor_compra FROM cadastro_produtos");
                $stmtProdutos->execute();
                $resultadosProdutos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $id_produto = $_POST["id_produto"];
                    $valor_venda = $_POST["valor_venda"];
                    $valor_dinheiro_PIX = $_POST["valor_dinheiro_PIX"];
                    $valor_cartao_debito = $_POST["valor_cartao_debito"];
                    $valor_cartao_credito = $_POST["valor_cartao_credito"];
                    $numero_parcelas = $_POST["numero_parcelas"];
                    $valor_maquininha = $_POST["valor_maquininha"];
                    $lucro = $_POST["lucro"];
                    $data_venda = $_POST["data_venda"];
                    $cliente = $_POST["cliente"];

                    try {
                        // Incluindo os resultados da consulta no array de produtos
                        $produtoEncontrado = false;
                        $valor_compra = 0;

                        foreach ($resultadosProdutos as $produto) {
                            if ($produto["id"] == $id_produto) {
                                $produtoEncontrado = true;
                                $valor_compra = $produto["valor_compra"];
                                break;
                            }
                        }

                        if (!$produtoEncontrado) {
                            echo "<script>alert('Produto não encontrado. Venda não adicionada.');</script>";
                        } else {
                            $stmtVendas = $conexao->prepare("INSERT INTO vendas (id_produto, valor_venda, valor_dinheiro_PIX, valor_cartao_debito, valor_cartao_credito, numero_parcelas, valor_maquininha, lucro, data_venda, cliente) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                            $stmtVendas->execute([$id_produto, $valor_venda, $valor_dinheiro_PIX, $valor_cartao_debito, $valor_cartao_credito, $numero_parcelas, $valor_maquininha, $lucro, $data_venda, $cliente]);

                            echo "<script>alert('Venda adicionada com sucesso!');</script>";
                        }
                    } catch (PDOException $e) {
                        echo "<script>alert('Erro ao adicionar a venda: " . $e->getMessage() . "');</script>";
                    }
                }
            } catch (PDOException $e) {
                echo "Erro na conexão: " . $e->getMessage();
            }
        ?>

        <div class="container">
            <h1>Adicionar Venda</h1>
            
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="id_produto">ID do Produto:</label>
                <input type="text" id="id_produto" name="id_produto" onchange="buscarValorCompra()" required>

                <label for="valor_compra">Valor da Compra:</label>
                <input type="text" id="valor_compra" name="valor_compra" required>

                <label for="valor_venda">Valor da Venda:</label>
                <input type="text" id="valor_venda" name="valor_venda" required>

                <label for="valor_dinheiro_PIX">Valor em dinheiro/PIX:</label>
                <input type="text" id=" " name="valor_dinheiro_PIX" required>

                <label for="valor_cartao_debito">Valor no Cartão de Débito:</label>
                <input type="text" id="valor_cartao_debito" name="valor_cartao_debito" required>

                <label for="valor_cartao_credito">Valor no Cartão de Crédito:</label>
                <input type="text" id="valor_cartao_credito" name="valor_cartao_credito" required>

                <label for="numero_parcelas">Quantidade de Parcelas:</label>
                <input type="text" id="numero_parcelas" name="numero_parcelas" required>

                <label for="valor_maquininha">Valor da Recebido pela Maquininha:</label>
                <input type="text" id="valor_maquininha" name="valor_maquininha" required>

                <label for="lucro">Lucro:</label>
                <input type="text" id="lucro" name="lucro" required>

                <label for="data_venda">Data da Venda:</label>
                <input type="date" id="data_venda" name="data_venda" required>

                <label for="cliente">Cliente:</label>
                <input type="text" id="cliente" name="cliente" required>

                <button type="submit">Adicionar Produto</button>
            </form>
            
            <a href="index.php"><button>Voltar para página inicial</button></a>
        </div>

        <script>
            var valoresCompra = <?php echo json_encode($resultadosProdutos); ?>;
            function buscarValorCompra() {
                var idProduto = document.getElementById("id_produto").value;
                var valorCompraInput = document.getElementById("valor_compra");

                // Encontrar o valor de compra correspondente ao ID do produto
                var produto = valoresCompra.find(function(produto) {
                    return produto.id == idProduto;
                });

                // Atualizar o campo valor_compra com o valor encontrado ou limpar se não encontrado
                if (produto) {
                    valorCompraInput.value = produto.valor_compra;
                } else {
                    valorCompraInput.value = "";
                }
            }
        </script>
    </body>
</html>
