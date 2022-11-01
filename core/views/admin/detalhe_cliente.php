<?php
use core\classes\Store;?>

<div class="container-fluid">
    <div class="row my-3 justify-content-center">
        
        <div class="col-md-2">
            <?= include_once(__DIR__.'/layouts/admin_menu.php'); ?>
        </div>
        
        <div class="col-md-10">
            <h2 class="text-center">Detalhes do cliente</h2><hr>
            <div class="row mt-2">
                <!-- Nome Completo -->
                <div class="col-2 ps-5 fw-bold">
                    Nome Completo:<br>
                    Email:<br>
                    Endereço:<br>
                    Cidade:<br>
                    Telefone:<br>
                    Estatus:<br>
                    Cliente desde:<br>
                </div>
                <div class="col-3">
                    <?= $dados_cliente->nome_completo; ?><br>
                    <a href="mailto:<?= $dados_cliente->email;?>"><?= $dados_cliente->email;?></a><br>
                    <?= $dados_cliente->endereco; ?><br>
                    <?= $dados_cliente->cidade; ?><br>
                    <?= $dados_cliente->telefone; ?><br>
                    <!-- ativo / inativo -->
                    <?php if($dados_cliente->activo==1): ?><span class=""><i class="text-success fa-solid fa-circle-check"></i> Ativo</span><br>
                    <?php else: ?>
                    <span class=""><i class="text-danger fa-solid fa-circle-xmark"></i> Inativo</span><br>
                    <?php endif; ?>
                    <!-- Cliente desde: -->
                    <!-- Formatção da DATA e HORA - coloca numa $variavel no formato atual -->
                    <?php $date=DateTime::createFromFormat('Y-m-d H:i:s',$dados_cliente->created_at);?>
                    <!-- Formatção da DATA e HORA - Depois imprime a $variavel no formato desejado -->
                    <?=$date->format('d-m-Y H:i').'h';?><br>     
                </div>
                <div class="col-5 align-self-center">
                    <?php if($total_encomenda==0): ?>
                        <p>Não existe encomendas para este cliente</p>
                    <?php else: ?>
                        <a class="btn btn-outline-info" href="?a=cliente_historico_encomenda&c=<?= Store::aesEcncriptar($dados_cliente->id_cliente);?>">Histórico de encomendas</a>
                    <?php endif; ?>
                        
                </div>
            </div>
        </div>
    </div>
</div>
