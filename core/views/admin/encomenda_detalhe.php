<div class="container-fluid">
    <div class="row my-3 justify-content-center">
        <div class="col-md-2">
            <?php include_once(__DIR__.'/layouts/admin_menu.php'); ?>
        </div>
        <div class="col-md-10 text-center">
            <h2>Detalhes da Encomenda - Cliente - Produto</h2><hr>
            <div class="row">
                <h3>Detalhes do Cliente</h3>
                    <div class="col-2">Nome Cliente:<br>...</div>
                    <div class="col-2">Email Contato:<br><span class="fw-bold"><?=$encomenda->email;?></span></div>
                    <div class="col-2">Telefone:<br><span class="fw-bold"><?= $encomenda->telefone;?></span></div>
                    <div class="col-2">Endereço:<br><span class="fw-bold"><?= $encomenda->endereco;?></span></div>
                    <div class="col-2">Cidade:<br><span class="fw-bold"><?= $encomenda->cidade;?></span></div>
            </div><hr>
            <div class="row">
                    <h3>Detalhes da Encomenda</h3>
                    <div class="col-3">Codigo Encomenda:<br><span class="fw-bold"><?= $encomenda->codigo_encomenda;?></span></div>
                    <div class="col-3">Status:<br><span class="fw-bold"><?= $encomenda->status;?></span></div>
                    <?php $d_encomenda=DateTime::createFromFormat('Y-m-d H:i:s',$encomenda->data_encomenda);?>
                    <div class="col-3">Data Encomenda:<br><span class="fw-bold">
                        <?= $d_encomenda->format('d-m-Y H:i').'h';?></span></div>
                    <div class="col-3">Mensagem:<br><span class="fw-bold"><?= $encomenda->mensagem;?></span></div>
            </div><hr>
            <div class="row">
                    <h3>Detalhes dos Produtos da Encomenda</h3>
                    <div class="col-4">Designação do produdo:<br></div>
                    <div class="col-4">Quantidade:<br></div>
                    <div class="col-4">Preço Unidade:<br></div>
                    <?php foreach($lista_produtos as $produto): ?>
                        <div class="col-4"><span class="fw-bold"><?= $produto->designacao_produto;?></span><br></div>
                        <div class="col-4"><span class="fw-bold"><?= $produto->quantidade;?></span><br></div>
                        <div class="col-4"><span class="fw-bold">
                            <?= 'R$ '.number_format($produto->preco_unidade,2,',','.');?></span><br></div>
                    <?php endforeach;?>
                    
            </div><hr>
            <div class="row">
                    <div class="col-5"><span class="fw-bold">Valor Total:</span></div>
                    <div class="col-5"><span class="fw-bold">Valor:</span></div>
            </div>
        </div>
    </div>
</div>
