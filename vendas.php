<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="vendas.css">
        <title>Document</title>
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
                $sqlDadosVendas = "SELECT vendas.*, cadastro_produtos.valor_compra FROM vendas
                    JOIN cadastro_produtos ON vendas.id_produto = cadastro_produtos.id";

                // Preparar a consulta
                $stmt = $conexao->prepare($sqlDadosVendas);

                // Executar a consulta
                $stmt->execute();

                // Obter os resultados como um array associativo
                $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                echo "Erro na conexão: " . $e->getMessage();
            }
        ?>

        <h1>Cadastro de Vendas</h1>

        <a href="adicionar_venda.php"><button id="adicionar-venda-btn">Adicionar Venda</button></a>

        <a href="index.php"><button id="voltar-btn">Voltar para página inicial</button></a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Valor Compra</th>
                    <th>Valor Venda</th>
                    <th>Dinheiro / PIX</th>
                    <th>Cartão Débito</th>
                    <th>Cartão Crédito</th>
                    <th>Quantidade de Parcelas</th>
                    <th>Valor Recebido da Maquininha</th>
                    <th>Lucro</th>
                    <th>Data da Venda</th>
                    <th>Cliente</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <?php
                if ($resultados) {
            ?>
                    <tbody>
            <?php
                    foreach ($resultados as $venda) {
                        echo "<tr>";
                        echo "<td>" . $venda['id_produto'] . "</td>";
                        echo "<td>" . $venda['valor_compra'] . "</td>";
                        echo "<td>" . $venda['valor_venda'] . "</td>";
                        echo "<td>" . $venda['valor_dinheiro_PIX'] . "</td>";
                        echo "<td>" . $venda['valor_cartao_debito'] . "</td>";
                        echo "<td>" . $venda['valor_cartao_credito'] . "</td>";
                        echo "<td>" . $venda['numero_parcelas'] . "</td>";
                        echo "<td>" . $venda['valor_maquininha'] . "</td>";
                        echo "<td>" . $venda['lucro'] . "</td>";
                        echo "<td>" . $venda['data_venda'] . "</td>";
                        echo "<td>" . $venda['cliente'] . "</td>";
                        echo "<td><a href=''>Alterar</a> | <a href=''>Excluir</a></td>";
                        echo "</tr>";
                    }
            ?>
                    </tbody>
            <?php
                } else {
                    echo "<tr><td colspan='12'>Nenhum dado encontrado</td></tr>";
                }
            ?>
        </table>

        <script>
            function confirmarExclusao(id) {
                var confirmacao = confirm("Tem certeza que deseja excluir esta venda?");
                if (confirmacao) {
                    window.location.href = "excluir_venda.php?id=" + id;
                }
            }
        </script>
    </body>
</html>