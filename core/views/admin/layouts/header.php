<?php use core\classes\Store; 
?>
<div class="container-fluid navegacao">
    <div class="row">
        <div class="col-4 div_titulo">
            <a class="text-center" href="?a=inicio">
                <h2>BackOffice - Admin</h2>
            </a>
        </div>
        
        <div class="col-8 p-3 text-end align-self-center">
            <a class="nav_link btn btn-sm btn-info me-4" href="?a=teste_criar_pdf">Testes</a>
            <a class="header_menu_admin me-4" href="https://localhost/SAUDE/public/?a=loja"><i class="fa-solid fa-shop"></i> Loja</a>
            <?php if(Store::adminLogado()): ?>
                <a class="header_menu_admin" href="?a="><i class="fas fa-user me-2"></i><?= $_SESSION['admin_usuario']; ?></a>
                <a class="header_menu_admin" href="?a=admin_logout"><i class="fa-solid fa-right-from-bracket ms-4"></i> LogOut</a>
            <?php endif; ?>
        </div>
    </div>
</div>