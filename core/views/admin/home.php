<div class="container-fluid">
    <div class="row my-3 justify-content-center">
        
        <div class="col-md-3">
            <?php include_once(__DIR__.'/layouts/admin_menu.php'); ?>
        </div>
        
        <div class="col-md-9 text-center">
            <!-- Apresenta informações sobre o total de encomendas pendentes -->
            div.alert
            <?php if($total_encomendas_pendentes == 0): ?>
                <p>Não existe encomendas pendentes</p>
                
            <?php else: ?>
                <p><?= $total_encomendas_pendentes ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
