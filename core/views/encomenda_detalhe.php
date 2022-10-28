<?php 
use core\classes\Store; ?>

<div class="container">
    <div class="row m-4">
        <div class="col-sm-8 offset-sm-3">
            <h3 class="text-center">Detalhes da Encomenda</h3>
            
            <div class="my-2">
                <!-- Dados da encomenda -->
                <h4>Dados da encomenda</h4>
                <table class="table">
                    <thead><th>Dados:</th><th>Detalhes:</th>
                    </thead>
                    <tbody>
                        <tr><td>ID da encomenda:</td><td> </td></tr>
                        <tr><td>Data da encomenda:</td><td></td></tr>
                                   <!-- date_format($data_enco,'Y/m/d H:i:s');  -->
                        <tr><td>Codigo da Encomenda</td><td></td></tr>
                        <tr><td>Status</td><td></td></tr>
                        <tr><td>Mensagem</td><td><?php ?></td></tr>
                        <tr><th><h4>Dados do Produto</h4></th></tr>
                        <tr><th>designacao_produto</th><th>preco_unidade</th><th>quantidade</th></tr>
                        <tr><td> </td>
                        <td></td><td></td></tr>
                    </tbody>
                </table>
                
                
                <?php
                Store::printData($dados_encomenda);
                // Store::printData($detalhe_encomenda);
                ?>
                <!-- Lista de produtos da encomenda -->
                <p>...</p>
                
            </div>
            
           
            <div class="my-5"><a class="btn btn-primary" href="?a=inicio">Voltar</a></div>
        </div>
    </div>
</div>