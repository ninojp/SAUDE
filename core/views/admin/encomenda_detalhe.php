<?php
use core\classes\Store; ?>
<div class="container-fluid">
    <div class="row my-3 justify-content-center">
        <div class="col-md-2">
            <?php include_once(__DIR__.'/layouts/admin_menu.php'); ?>
        </div>
        <div class="col-md-10 text-center">
            <h2>Detalhes da Encomenda - Cliente - Produto</h2><hr>
            <div class="row">
                <h3>Detalhes do Cliente</h3>
                    <div class="col-2">Nome Cliente:<br>
                    <span class="fw-bold"><?=$encomenda->nome_completo;?></span></div>
                    <div class="col-2">Email Contato:<br>
                    <span class="fw-bold"><?=$encomenda->email;?></span></div>
                    <div class="col-2">Telefone:<br><span class="fw-bold"><?=$encomenda->telefone;?></span></div>
                    <div class="col-3">Endereço:<br><span class="fw-bold"><?=$encomenda->endereco;?></span></div>
                    <div class="col-2">Cidade:<br><span class="fw-bold"><?=$encomenda->cidade;?></span></div>
            </div><hr>
            <div class="row">
                    <h3>Detalhes da Encomenda</h3>
                    <div class="col-2">Status:<br>
                    <button type="button" class="header_menu_admin badge bg-info" onclick="apresentarModal()"><?=$encomenda->status;?></button>
                    </div>
                    <div class="col-1">imprimir:<br>
                    <?php if($encomenda->status == 'PROCESSAMENTO'):?>
                        <a class="btn btn-sm btn-outline-info" href=""> PDF</a>
                    <?php endif; ?>
                    </div>
                    <div class="col-2">Codigo Encomenda:<br><span class="fw-bold"><?=$encomenda->codigo_encomenda;?></span></div>
                    <?php $data_encomenda=DateTime::createFromFormat('Y-m-d H:i:s',$encomenda->data_encomenda);?>
                    <div class="col-3">Data Encomenda:<br><span class="fw-bold">
                        <?= $data_encomenda->format('d-m-Y H:i').'h';?></span></div>
                    <div class="col-4">Mensagem:<br><span class="fw-bold"><?=$encomenda->mensagem;?></span></div>
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
<!-- Modal -->
<div class="modal fade" id="modalStatus" tabindex="-1" aria-labelledby="tituloModalStatus" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="tituloModalStatus">Alterar o Status da Encomenda</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="text-center">
            <?php foreach(STATUS as $estado):?>
                <?php if($encomenda->status == $estado):?>
                    <p><?=$estado?></p>
                <?php else:?>
                    <p><a href="?a=encomenda_alterar_estado&e=<?=Store::aesEcncriptar($encomenda->id_encomenda)?>&s=<?=$estado?>"><?=$estado?></a></p>
                <?php endif;?>
                
            <?php endforeach; ?>
        </div>
                
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script>
    function apresentarModal(){
        console.log('teste Modal');
        const modalStatus = new bootstrap.Modal(document.getElementById('modalStatus'));
        modalStatus.show();
    }
</script>