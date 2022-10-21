<div class="container espaco-fundo">
    <!-- titulo da pagina -->
    <div class="row">
        <div class="col-7 p-3">
            <h2 class="text-start">Saúde - Física e Mental</h2>
        </div>
        <div class="col-4 text-end pt-3">
            <?php foreach($categorias as $categoria): ?>
                <a class="btn btn-sm btn-outline-primary me-2" href="?a=loja&c=<?=$categoria?>">
                <!-- ucfirst(primeira letra Maiúscula), 
                preg_replace("/\caracter_origem/", "caracter_substituição", $variável) -->
                <?= ucfirst(preg_replace("/\_/", " ", $categoria)) ?></a>
            <?php endforeach; ?>
            <a class="btn btn-sm btn-outline-primary" href="?a=loja&c=todos">Todos</a>
        </div>
    </div>
    <!-- Produtos -->
    <div class="row">
        <?php if(count($produtos) == 0): ?>
            <div class="text-center my-5">
                <h3>Não existe produtos disponiveis.</h3>
            </div>
        <?php else: ?>
            <!-- foreach para exibir todos os produtos do BD -->
        <?php foreach($produtos as $produto): ?>
        <div class="col-sm-3 col-6 p-2">
            <div class="text-center p-3 box-produto">
                <img class="img-fluid" src="assets/imgs/produtos/<?= $produto->imagem ?>" alt="Imagem do produto">
                <h3><?= $produto->nome_produto ?></h3>
                <h2><?= "R$ ". preg_replace("/\./", ",", $produto->preco) ?></h2>
                <p><small><?= $produto->descricao ?></small></p>
                <button class="btn btn-sm btn-info" onclick="adicionar_carrinho(<?= $produto->id_produto ?>)">Inserir ao Carrinho<i class="fa-solid fa-cart-shopping ms-2"></i></button>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<!--
    [id_produto] => 1
    [categoria] => homem
    [nome_produto] => Tshirt Vermelha
    [descricao] => Ab laborum, commodi aspernatur, quas distinctio cum quae omnis autem ea, odit sint quisquam similique! Labore aliquam amet veniam ad fugiat optio.
    [imagem] => tshirt_vermelha.png
    [preco] => 45.70
    [stock] => 100
    [visivel] => 1
    [created_at] => 2021-02-06 19:45:18
    [updated_at] => 2021-02-06 19:45:25
    [deleted_at] =>
-->