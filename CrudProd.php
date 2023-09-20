<?php
include './Banco.php';
$pdo = Banco::connectar();

$acao = filter_input(INPUT_POST, 'acao');
$codigo = filter_input(INPUT_POST, 'codigo');
$descricao = filter_input(INPUT_POST, 'descricao');
$unidade = filter_input(INPUT_POST, 'unidades');
$quantidade = filter_input(INPUT_POST, 'quantidade');
$quantidadeMinima = filter_input(INPUT_POST, 'quantidadeMinima');
$precoVenda = filter_input(INPUT_POST, 'precoVenda');
$dataCompra = filter_input(INPUT_POST, 'dataCompra');

if ($acao == "cad") {
    echo "Cadastrar Produto<br>";
    $erro = 0;
    $msgerro = "";

    if (empty($descricao)) {
        $erro += 1;
        $msgerro .= "Erro no campo descrição; deve ser preenchido";
    }

    if ($erro > 0) {
        echo "Detectamos $erro erro(s) no formulário. São eles: $msgerro";
        exit;
    }

    try {
        $sql = "INSERT INTO produtos (descricao, unidades, quantidade, quantidade_Minima, preco_venda, data_compra) VALUES"
            . " (:descricao, :unidades, :quantidade, :quantidadeMinima, :precoVenda, :dataCompra)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':unidades', $unidade);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':quantidadeMinima', $quantidadeMinima);
        $stmt->bindParam(':precoVenda', $precoVenda);
        $stmt->bindParam(':dataCompra', $dataCompra);
        $ok = $stmt->execute();
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

if ($acao == "alt") {
    echo "Alterar Produto";
    $id = filter_input(INPUT_POST, 'id');
    try {
        $sql = "UPDATE produtos SET "
            . "descricao=:descricao,"
            . "unidades=:unidade,"
            . "quantidade=:quantidade,"
            . "quantidade_Minima=:quantidadeMinima,"
            . "preco_venda=:precoVenda,"
            . "data_compra=:dataCompra "
            . "WHERE id=:id";
            
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':unidade', $unidade);
        $stmt->bindParam(':quantidade', $quantidade);
        $stmt->bindParam(':quantidadeMinima', $quantidadeMinima);
        $stmt->bindParam(':precoVenda', $precoVenda);
        $stmt->bindParam(':dataCompra', $dataCompra);
        $stmt->bindParam(':id', $id);

        $ok = $stmt->execute();
        echo "<br><a href=CadastroProduto.php>Cadastrar Novo Produto</a><br>";
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
$acao = $_GET['acao'];
$codigo = $_GET['codigo'];
if ($acao == "del") {
    echo "Excluir Produto";

    try {
        $sql = "DELETE FROM produtos WHERE id=$codigo";
        $stmt = $pdo->prepare($sql);
        $ok = $stmt->execute();
        echo "<br><a href=CadastroProduto.php>Cadastra Nobo Produto</a><br>";
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}
?>
