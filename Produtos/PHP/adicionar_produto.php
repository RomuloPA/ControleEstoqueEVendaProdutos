<!DOCTYPE html>
    <html lang="pt-br">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="adicionar_produto.css">
            <title>Adicionar Produto</title>
        </head>
        <body>
            <?php
                $servidor = "localhost";
                $banco = "controle_vendas_estoque";
                $usuario = "root";
                $senha = "";

                try {
                    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);

                    // Configurar o modo de erro para Exception
                    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                    // Verifica se o formulário foi enviado
                    if ($_SERVER["REQUEST_METHOD"] == "POST") { // validar de qual formulário está sendo enviado o POST

                        // Captura os dados do formulário
                        $marca = $_POST["marca"];
                        $modelo = $_POST["modelo"];
                        $cor = $_POST["cor"];
                        $numeroSerie = $_POST["numero_serie"];
                        $imei1 = $_POST["imei_1"];
                        $imei2 = $_POST["imei_2"];
                        $valorCompra = $_POST["valor_compra"];
                        $dataCompra = $_POST["data_compra"];
                        $fornecedor = $_POST["fornecedor"];
                        $situacao = $_POST["situacao"];
                        $observacoes = $_POST["observacoes"];

                        // Prepara e executa a consulta SQL para inserção dos dados
                        $sqlInsercaoProdutos = ("INSERT INTO cadastro_produtos (marca, modelo, cor, numero_serie, imei_1, imei_2, valor_compra, data_compra, fornecedor, situacao, observacoes) VALUES (:marca, :modelo, :cor, :numeroSerie, :imei1, :imei2, :valorCompra, :dataCompra, :fornecedor, :situacao, :observacoes)");

                        $stmt = $conexao->prepare($sqlInsercaoProdutos);

                        // Bind dos parâmetros
                        $stmt->bindParam(':marca', $marca);
                        $stmt->bindParam(':modelo', $modelo);
                        $stmt->bindParam(':cor', $cor);
                        $stmt->bindParam(':numeroSerie', $numeroSerie);
                        $stmt->bindParam(':imei1', $imei1);
                        $stmt->bindParam(':imei2', $imei2);
                        $stmt->bindParam(':valorCompra', $valorCompra);
                        $stmt->bindParam(':dataCompra', $dataCompra);
                        $stmt->bindParam(':fornecedor', $fornecedor);
                        $stmt->bindParam(':situacao', $situacao);
                        $stmt->bindParam(':observacoes', $observacoes);
                
                        // Executa a consulta preparada
                        if ($stmt->execute()) {
                            echo "<script>alert('Dados inseridos com sucesso!');</script>";
                        } else {
                            echo "<script>alert('Erro ao inserir dados: " . $stmt->errorInfo()[2] . "');</script>";
                        }
                    }
                } catch (PDOException $e) {
                    echo "Erro na conexão: " . $e->getMessage();
                }
            ?>

            <div class="container">
                <h1>Adicionar Novo Produto</h1>
                
                <!-- Formulário para adicionar um novo produto -->
                <form action="" method="post">
                    <label for="marca">Marca:</label>
                    <input type="text" id="marca" name="marca" required>
                    
                    <label for="modelo">Modelo:</label>
                    <input type="text" id="modelo" name="modelo" required>

                    <label for="cor">Cor:</label>
                    <input type="text" id="cor" name="cor" required>

                    <label for="numero_serie">Número de Série:</label>
                    <input type="text" id="numero_serie" name="numero_serie" required>

                    <label for="imei_1">IMEI 1:</label>
                    <input type="text" id="imei_1" name="imei_1" required>

                    <label for="imei_2">IMEI 2:</label>
                    <input type="text" id="imei_2" name="imei_2" required>

                    <label for="valor_compra">Valor:</label>
                    <input type="text" id="valor_compra" name="valor_compra" required>

                    <label for="data_compra">Data da Compra:</label>
                    <input type="date" id="data_compra" name="data_compra" required>

                    <label for="fornecedor">Fornecedor:</label>
                    <input type="text" id="fornecedor" name="fornecedor" required>

                    <label for="situacao">Status:</label>
                    <select id="situacao" name="situacao" required>
                        <option value="disponivel">Disponível</option>
                        <option value="indisponivel">Indisponível</option>
                        <option value="vendido">Vendido</option>
                    </select>

                    <label for="observacoes">Observações:</label>
                    <textarea id="observacoes" name="observacoes" rows="4"></textarea>

                    <button type="submit">Adicionar Produto</button>
                </form>
                
                <a href="produtos.php"><button>Voltar para Dados dos Produtos</button></a>
            </div>
        </body>
    </html>