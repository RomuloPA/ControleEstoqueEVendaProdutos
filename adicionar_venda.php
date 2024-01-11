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
            
            <form action="" method="post">
                <label for="id_produto">ID do Produto:</label>
                <input type="text" id="id_produto" name="id_produto" onchange="buscarValorCompra()" required>

                <label for="valor_compra">Valor da Compra:</label>
                <input type="text" id="valor_compra" name="valor_compra" readonly>
                
                <label for="valor_venda">Valor da Venda:</label>
                <input type="text" id="valor_venda" name="valor_venda" readonly>
                
                <label for="valor_dinheiro_PIX">Valor em dinheiro/PIX:</label>
                <input type="text" id="valor_dinheiro_PIX" name="valor_dinheiro_PIX" oninput="calcularVendaELucro()" required>
                
                <label for="valor_cartao_debito">Valor no Cartão de Débito:</label>
                <input type="text" id="valor_cartao_debito" name="valor_cartao_debito" required>
                
                <label for="valor_cartao_credito">Valor no Cartão de Crédito:</label>
                <input type="text" id="valor_cartao_credito" name="valor_cartao_credito" required>
                
                <label for="numero_parcelas">Quantidade de Parcelas:</label>
                <input type="text" id="numero_parcelas" name="numero_parcelas" required>
                
                <label for="valor_maquininha">Valor Recebido pela Maquininha:</label>
                <input type="text" id="valor_maquininha" name="valor_maquininha" oninput="calcularVendaELucro()" required>
                
                <label for="lucro">Lucro:</label>
                <input type="text" id="lucro" name="lucro" readonly>

                <label for="data_venda">Data da Venda:</label>
                <input type="date" id="data_venda" name="data_venda" required>
                
                <label for="cliente">Cliente:</label>
                <input type="text" id="cliente" name="cliente" required>
                
                <button type="submit">Adicionar Produto</button>
            </form>
            
            <a href="vendas.php"><button>Voltar para página de vendas</button></a>
        </div>
        
        <script>
            // 
            var valoresCompra = <?php echo json_encode($resultadosProdutos); ?>;
            function buscarValorCompra() {
                var idProduto = document.querySelector("#id_produto").value;
                var valorCompraInput = document.querySelector("#valor_compra");

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

            function calcularVendaELucro() {
                var valorDinheiroPIX = parseFloat(document.querySelector("#valor_dinheiro_PIX").value) || 0;
                var valorMaquininha = parseFloat(document.querySelector("#valor_maquininha").value) || 0;

                var valorVenda = valorDinheiroPIX + valorMaquininha;
                var valorCompra = parseFloat(document.querySelector("#valor_compra").value) || 0;

                var lucro = valorVenda - valorCompra;

                // Atualize os campos e exiba os valores calculados
                document.querySelector("#valor_venda").value = valorVenda.toFixed(2);
                document.querySelector("#lucro").value = lucro.toFixed(2);
            }
        </script>
    </body>
</html>
