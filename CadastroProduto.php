<?php 
// Variável para fazer alteração nos produtos cadastrados no banco de dados.
include_once "./Banco.php";
$pdo = Banco::connectar();
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($id) {
    $acao = "alt";
    try {
        $msgBotao= "Alterar produto";
        $sql = "SELECT * FROM produtos WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
        $descricao = htmlspecialchars($produto['descricao']);
        $unidade = $produto['unidades'];
        $quantidade = $produto['quantidade'];
        $quantidadeMinima = $produto['quantidade_Minima'];
        $precoVenda = $produto['preco_Venda'];
        $dataCompra = $produto['data_Compra'];

    } catch (PDOException $ex) {
        echo "Erro no banco de dados: " . $ex->getMessage();
    }
} else {
    $msgBotao="Cadastra produto";
    $acao = "cad";
    $descricao = null;
    $unidade = null;
    $quantidade = null;
    $quantidadeMinima = null;
    $precoVenda = null;
    $dataCompra = null;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" href="style.css"> -->
    <title>Cadastro de Produto</title>
</head>
<body>
    <h1>Cadastro de Produto</h1>
    <form action="CrudProd.php" method="post">
        <table class="tabela">
            <tr>
                <td align="right">Descrição:</td>
                <td><textarea name="descricao" rows="2" cols="21"><?php echo $descricao; ?></textarea></td>
            </tr>
            <tr>
                <td align="right">Unidade de medida:</td>
                <td>
                    <select name="unidades">
                        <option value="">Selecione uma unidade</option>
                        <option value="un" <?php if($unidade == 'un') { echo "selected"; } ?>>Unidade</option>
                        <option value="cx" <?php if($unidade == 'cx') { echo "selected"; } ?>>Caixa</option>
                        <option value="kg" <?php if($unidade == 'kg') { echo "selected"; } ?>>Quilograma</option>
                        <option value="pct" <?php if($unidade == 'pct') { echo "selected"; } ?>>Pacote</option>
                        <option value="l" <?php if($unidade == 'l') { echo "selected"; } ?>>Litros</option>
                        <option value="vl" <?php if($unidade == 'vl') { echo "selected"; } ?>>Volume</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="right">Quantidade:</td>
                <td><input type="number" name="quantidade" value="<?php echo $quantidade; ?>"></td>
            </tr>
            <tr>
                <td align="right">Quantidade Mínima:</td>
                <td><input type="number" name="quantidadeMinima" value="<?php echo $quantidadeMinima; ?>"></td>
            </tr>
            <tr>
                <td align="right">Preço de Venda:</td>
                <td><input type="number" name="precoVenda" value="<?php echo $precoVenda; ?>"></td>
            </tr>
            <tr>
                <td align="right">Data de Compra:</td>
                <td><input type="date" name="dataCompra" value="<?php echo $dataCompra; ?>"></td>
            </tr>
        </table>
        <input type="hidden" name="acao" value="<?php echo $acao; ?>">
        <?php if ($id) { ?>
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <?php }?>
        <button><?php echo $msgBotao;?></button>
        <?php if($acao== 'alt'){?>
        <a href="CadastroProduto.php">Novo produto</a>
        <?php }?>
    </form><br>
    <table>
    <tr>
        <td><button onclick="javascript:window.location.href='index.php'">Voltar</button></td>
    </tr>
    </table>
    <table width="100%" border="1">
        <thead>
            <tr>
                <td>Código</td>
                <td>Descrição</td>
                <td>Qtd estoque</td>
                <td>Preço venda</td>
                <td>Alterar</td>
                <td>Excluir</td>
            </tr>
        </thead>
        <tbody>
            <?php 
            include_once "./Banco.php";
            $pdo = Banco::connectar();
            $sql = "SELECT * FROM produtos ORDER BY id DESC";
            foreach ($pdo->query($sql) as $row) {
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['descricao']); ?></td>
                    <td><?php echo $row['quantidade']; ?></td>
                    <td><?php echo $row['preco_Venda']; ?></td>
                    <td><a href="CadastroProduto.php?id=<?php echo $row['id']; ?>">Alterar</a></td>
                    <td><a href="CrudProd.php?acao=del&codigo=<?php echo $row['id'];?>">Excluir</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
