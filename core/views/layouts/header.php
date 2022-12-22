<?php use core\classes\Store; 

// Calcula o numero de produtos do carrinho
$total_produtos = 0;
if(isset($_SESSION['carrinho'])){
    foreach($_SESSION['carrinho'] as $quantidade){
        $total_produtos += $quantidade;
    }
}
?>


<div class="container-fluid navegacao">
    <div class="row">
        <div class="col-6 div_titulo">
            <a class="text-center" href="?a=inicio">
                <h3>Saúde - Bem-estar Físico, Mental e Social.</h3>
            </a>
        </div>
        <div class="col-6 text-end p-3">
            <a class="nav_link btn btn-sm btn-success" href="https://localhost/SAUDE/public/admin/" target="_blank">ADM</a>
            <a class="nav_link btn btn-sm btn-success" href="?a=inicio">Início</a>
            <a class="nav_link btn btn-sm btn-success" href="?a=loja">Loja</a>

            <!-- verifica se existe um cliente na sessão ------------------------------->
            <?php if(Store::clienteLogado()): ?>
                <a class="btn btn-sm btn-success" href="?a=perfil"><i class="fas fa-user me-1"></i><?=$_SESSION['usuario']?></a>
                <a class="nav_link btn btn-sm btn-success" href="?a=logout"><i class="fa-solid fa-right-from-bracket"></i></a>
                
            <?php else: ?>
                <a class="nav_link btn btn-sm btn-success" href="?a=login">Login</a>
                <a class="nav_link btn btn-sm btn-success" href="?a=novo_cliente">Criar Conta</a>

            <?php endif; ?>

            <a class=" btn btn-sm btn-success" href="?a=carrinho"><i class="fa-solid fa-cart-shopping"></i></a>
            <span class="badge bg-warning" id="carrinho"><?= $total_produtos == 0 ? '' : $total_produtos ?></span>
        </div>
    </div>
</div>