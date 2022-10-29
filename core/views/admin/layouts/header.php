<?php use core\classes\Store; 
?>
<div class="container-fluid navegacao">
    <div class="row">
        <div class="col-4 div_titulo">
            <a class="text-center" href="?a=inicio">
                <h3>BackOffice - Admin</h3>
            </a>
        </div>
        <div class="col-8 p-3 text-end align-self-center">
            <?php if(Store::adminLogado()): ?>
                <a href="?a="><i class="fas fa-user me-2"></i><?= $_SESSION['admin_usuario']; ?></a>
                <a href="?a=admin_logout"><i class="fa-solid fa-right-from-bracket ms-4"></i> LogOut</a>
            <?php endif; ?>
        </div>
    </div>
</div>