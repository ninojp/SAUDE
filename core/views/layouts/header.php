<?php use core\classes\Store;
 ?>

<div class="container-fluid navegacao">
    <div class="row">
        <div class="col-6 p-1">
            <a class="nav_link" href="?a=inicio">
                <h3><?= APP_NAME ?></h3>
            </a>
        </div>
        <div class="col-6 text-end p-3">
            <a class="nav_link" href="?a=inicio">Início</a>
            <a class="nav_link" href="?a=loja">Loja</a>

            <!-- verifica se existe um cliente na sessão ------------------------------->
            <?php if(Store::clienteLogado()): ?>
                <a class="nav_link" href="?a=minha_conta">Minha Conta</a>
                <a class="nav_link" href="?a=logout">Logout</a>
                
            <?php else: ?>
                <a class="nav_link" href="?a=login">Login</a>
                <a class="nav_link" href="?a=novo_cliente">Criar Conta</a>

            <?php endif; ?>

            <a class="nav_link" href="?a=carrinho"><i class="fa-solid fa-cart-shopping"></i></a>
            <span class="badge bg-warning">0</span>
        </div>
    </div>
</div>