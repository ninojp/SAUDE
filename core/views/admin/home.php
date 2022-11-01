<div class="container-fluid">
    <div class="row my-3 justify-content-center">
        
        <div class="col-md-2">
            <?php include_once(__DIR__.'/layouts/admin_menu.php'); ?>
        </div>
        
        <div class="col-md-10 text-center">
            <!-- Apresenta informações sobre o total de encomendas PENTENTES -->
            <?php if($total_encomenda_pendente == 0): ?>
                <p class="text-muted">Não existe encomendas pendentes</p><hr>
                
            <?php else: ?>
                <div class="alert alert-warning p-2 text-center">
                    <span class="me-3">Encomendas Pendentes: <strong><?= $total_encomenda_pendente ?></strong></span><a href="?a=lista_encomenda&f=pendente">Ver<i class="far fa-eye ms-1"></i></a><hr>
                </div>
            <?php endif; ?>
            <!-- Apresenta informações sobre o total de encomendas EM PROCESSAMENTO -->
            <?php if($total_encomenda_processamento == 0): ?>
                <p class="text-muted">Não existe encomendas em processamento</p><hr>
                
            <?php else: ?>
                <div class="alert alert-info p-2 text-center">
                    <span class="me-3">Encomendas em processamento: <strong><?= $total_encomenda_processamento ?></strong></span><a href="?a=lista_encomenda&f=processamento">Ver<i class="far fa-eye ms-1"></i></a><hr>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
