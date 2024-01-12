<?php
$servidor = "localhost";
$banco = "controle_vendas_estoque";
$usuario = "root";
$senha = "";

try {
    $conexao = new PDO("mysql:host=$servidor;dbname=$banco", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Verificar se os campos necessários estão presentes no formulário
        if (
            isset($_POST['id'], $_POST['marca'], $_POST['modelo'], $_POST['cor'], $_POST['numero_serie'],
            $_POST['imei_1'], $_POST['imei_2'], $_POST['valor_compra'], $_POST['data_compra'], $_POST['fornecedor'],
            $_POST['situacao'], $_POST['observacoes'])
        ) {
            $produtoId = $_POST['id'];
            $novaMarca = $_POST['marca'];
            $novoModelo = $_POST['modelo'];
            $novaCor = $_POST['cor'];
            $novoNumeroSerie = $_POST['numero_serie'];
            $novoImei1 = $_POST['imei_1'];
            $novoImei2 = $_POST['imei_2'];
            $novoValorCompra = $_POST['valor_compra'];
            $novaDataCompra = $_POST['data_compra'];
            $novoFornecedor = $_POST['fornecedor'];
            $novaSituacao = $_POST['situacao'];
            $novasObservacoes = $_POST['observacoes'];

            // Atualizar os dados do produto no banco de dados
            $sqlAtualizarProduto = ("UPDATE cadastro_produtos SET
                marca = :marca,
                modelo = :modelo,
                cor = :cor,
                numero_serie = :numero_serie,
                imei_1 = :imei_1,
                imei_2 = :imei_2,
                valor_compra = :valor_compra,
                data_compra = :data_compra,
                fornecedor = :fornecedor,
                situacao = :situacao,
                observacoes = :observacoes
                WHERE id = :id");

            $stmtAtualizarProduto = $conexao->prepare($sqlAtualizarProduto);
            $stmtAtualizarProduto->bindParam(':id', $produtoId, PDO::PARAM_INT);
            $stmtAtualizarProduto->bindParam(':marca', $novaMarca, PDO::PARAM_STR);
            $stmtAtualizarProduto->bindParam(':modelo', $novoModelo, PDO::PARAM_STR);
            $stmtAtualizarProduto->bindParam(':cor', $novaCor, PDO::PARAM_STR);
            $stmtAtualizarProduto->bindParam(':numero_serie', $novoNumeroSerie, PDO::PARAM_STR);
            $stmtAtualizarProduto->bindParam(':imei_1', $novoImei1, PDO::PARAM_STR);
            $stmtAtualizarProduto->bindParam(':imei_2', $novoImei2, PDO::PARAM_STR);
            $stmtAtualizarProduto->bindParam(':valor_compra', $novoValorCompra, PDO::PARAM_INT);
            $stmtAtualizarProduto->bindParam(':data_compra', $novaDataCompra, PDO::PARAM_STR);
            $stmtAtualizarProduto->bindParam(':fornecedor', $novoFornecedor, PDO::PARAM_STR);
            $stmtAtualizarProduto->bindParam(':situacao', $novaSituacao, PDO::PARAM_STR);
            $stmtAtualizarProduto->bindParam(':observacoes', $novasObservacoes, PDO::PARAM_STR);

            $stmtAtualizarProduto->execute();

            header("Location: produtos.php"); // Redireciona de volta para a lista de produtos
            exit();
        } else {
            echo "Campos obrigatórios não fornecidos.";
        }
    } else {
        echo "Método de requisição inválido.";
    }

} catch (PDOException $e) {
    echo "Erro na conexão: " . $e->getMessage();
}
?>