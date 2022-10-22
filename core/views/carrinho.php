<div class="container">
    <div class="row">
        <div class="col-8">
            <h2>Carrinho de Compras</h2>
            <a class="btn btn-sm btn-primary" href="?a=limpar_carrinho">Limpar Carrinho</a>
        </div>
        <div class="col-8">
            <?php if($carrinho == null): ?>
                <p>Carrinho Vazio</p>
                <p><a class="btn btn-primary" href="?a=loja">Voltar</a></p>
            <?php else:?>
                <p>Carrinho...</p>
            <?php endif;?>
        </div>
    </div>
</div>