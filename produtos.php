<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="cadastro_produtos.css">
        <title>Cadatro de Produtos</title>
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

                // Consulta SQL
                $sqlDadosProdutos = "SELECT id, marca, modelo, cor, numero_serie, imei_1, imei_2, valor_compra, data_compra, fornecedor, situacao, observacoes FROM cadastro_produtos";
                
                // Preparar a consulta
                $stmt = $conexao->prepare($sqlDadosProdutos);
                
                // Executar a consulta
                $stmt->execute();
                
                // Obter os resultados como um array associativo
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                echo "Erro na conexão: " . $e->getMessage();
            }
        ?>

        <h1>Cadastro de Produtos</h1>

        <a href="adicionar_produto.php"><button id="adicionar-produto-btn">Adicionar Produto</button></a>

        <a href="index.php"><button id="adicionar-produto-btn">Voltar para página inicial</button></a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Cor</th>
                    <th>Número de Série</th>
                    <th>IMEI 1</th>
                    <th>IMEI 2</th>
                    <th>Valor</th>
                    <th>Data da Compra</th>
                    <th>Fornecedor</th>
                    <th>Status</th>
                    <th>Observações</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <?php
                if ($resultados) {
            ?>
                    <tbody>
            <?php
                    foreach ($resultados as $produto) {
                        echo "<tr>";
                        echo "<td>" . $produto['id'] . "</td>";
                        echo "<td>" . $produto['marca'] . "</td>";
                        echo "<td>" . $produto['modelo'] . "</td>";
                        echo "<td>" . $produto['cor'] . "</td>";
                        echo "<td>" . $produto['numero_serie'] . "</td>";
                        echo "<td>" . $produto['imei_1'] . "</td>";
                        echo "<td>" . $produto['imei_2'] . "</td>";
                        echo "<td>" . $produto['valor_compra'] . "</td>";
                        echo "<td>" . $produto['data_compra'] . "</td>";
                        echo "<td>" . $produto['fornecedor'] . "</td>";
                        echo "<td>" . $produto['situacao'] . "</td>";
                        echo "<td>" . $produto['observacoes'] . "</td>";
                        echo "<td><a href='alterar_produto.php?id=" . $produto['id'] . "'>Alterar</a> | <a href='excluir_produto.php?id=" . $produto['id'] . "'>Excluir</a></td>";
                        echo "</tr>";
                    }
            ?>
                    </tbody>
            <?php
                } else {
                    echo "<tr><td colspan='16'>Nenhum dado encontrado</td></tr>";
                }
            ?>
        </table>
    </body>
</html>