<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adicionar_produto.css">
    <title>Adicionar Venda</title>
</head>
<body>
    <div class="container">
        <h1>Adicionar Venda</h1>
        
        <form method="post" action="">
            <label for="id_produto">ID do Produto:</label>
            <input type="text" id="id_produto" name="id_produto" required>

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
</body>
</html>