<div class="container espaco-fundo">
    <!-- titulo da pagina -->
    <div class="row">
        <div class="col-7 p-3">
            <h2 class="text-start">Saúde - Física e Mental</h2>
        </div>
        <div class="col-4 text-end pt-3">
            <a class="btn btn-sm btn-outline-primary me-2" href="?a=loja&c=masculina">Moda Masculina</a>
            <a class="btn btn-sm btn-outline-primary me-2" href="?a=loja&c=feminina">Moda Feminina</a>
            <a class="btn btn-sm btn-outline-primary" href="?a=loja&c=todos">Todos</a>
        </div>
    </div>
    <!-- Produtos -->
    <div class="row">
        <!-- foreach para exibir todos os produtos do BD -->
        <?php foreach($produtos as $produto): ?>
        <div class="col-sm-3 col-6 p-2">
            <div class="text-center p-3 box-produto">
                <img class="img-fluid" src="assets/imgs/produtos/<?= $produto->imagem ?>" alt="Imagem do produto">
                <h3><?= $produto->nome_produto ?></h3>
                <h2><?= $produto->preco ?></h2>
                <p><small><?= $produto->descricao ?></small></p>
                <input class="btn btn-sm btn-primary" type="button" value="Inserir ao Carrinho">
            </div>
        </div>
        <?php endforeach; ?>
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