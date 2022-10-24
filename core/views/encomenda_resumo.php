<div class="container">
    <div class="row table-responsive justify-content-center mb-5">
        <div class="col-8 p-3 text-center">
            <h2>Finalizar sua encomenda</h2>

            <table class="table align-middle table-hover">
                <thead>
                    <tr>
                        <th>Imagem</th>
                        <th>Produto</th>
                        <th class="text-center">Quantidade</th>
                        <th class="text-end">Valor Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 0;
                    $total_rows = count($carrinho);
                    foreach ($carrinho as $produto) :
                        if ($index < $total_rows - 1) : ?>
                            <!-- Lista dos produtos -->
                            <tr>
                                <td><img class="img-fluid" width="80px" src="assets/imgs/produtos/<?= $produto['imagem'] ?>"></td>
                                <td><?= $produto['titulo'] ?></td>
                                <td class="text-center"><?= $produto['quantidade'] ?></td>
                                <td class="text-end">
                                    <!--  //'R$ '.str_replace('.',',',$produto['preco'])  -->
                                    <?= 'R$ ' . number_format($produto['preco'], 2, ',', '.'); ?>
                                </td>
                            </tr>
                        <?php else : ?>
                            <!-- Total -->
                            <tr>
                                <td></td>
                                <td></td>
                                <td class="text-center">
                                    <h4><strong>Total:</strong></h4>
                                </td>
                                <td class="text-end">
                                    <h4><strong>
                                            <?= 'R$ ' . number_format($produto, 2, ',', '.'); ?></strong></h4>
                                </td>
                            </tr>
                    <?php endif;
                        $index++;
                    endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="col-4  mt-5 p-5 text-start">
            <h4 class="text-center">Dados do cliente</h4>
            <hr>
            <strong>Nome:</strong>  <?= $cliente->nome_completo ?><br>
            <strong>Endereço:</strong> <?= $cliente->endereco ?></strong><br>
            <strong>Cidade:</strong> <?= $cliente->cidade ?><br>
            <strong>Email:</strong> <?= $cliente->email ?><br>
            <strong>Telefone:</strong> <?= $cliente->telefone ?>
            <div class="form-check m-0 p-0">    
                <input class="form-check-input ms-3" onchange="usar_endereco_alternativo()" type="checkbox" name="check_endereco_alternativo" id="check_endereco_alternativo">
                <label class="form-check-label ms-2" for="check_endereco_alternativo">Redefinir dados do cliente</label>
            </div>
            <!-- endereço alternativo ------------------------------------------------------>
            <div id="endereco_alternativo" class="" style="display:none;">
            	<div class="mb-3">
                    <label class="form-label">Novo Endereço:</label>
                    <input class="form-control" type="text" id="text_endereco_alternativo">
                </div> 
            <!-- Cidade alternativa ------------------------------------------------------>
            	<div class="mb-2">
                    <label class="form-label">Nova Cidade:</label>
                    <input class="form-control" type="text" id="text_cidade_alternativo">
                </div> 
            <!-- Telefone alternativo ------------------------------------------------------>
            	<div class="mb-2">
                    <label class="form-label">Novo Telefone:</label>
                    <input class="form-control" type="text" id="text_telefone_alternativo">
                </div> 
            <!-- Email alternativo ------------------------------------------------------>
            	<div class="mb-2">
                    <label class="form-label">Novo Email:</label>
                    <input class="form-control" type="email" id="text_email_alternativo">
                </div>
            </div> 
        </div>
        <div class="row mb-5 p-2">
            <div class="col-4 ps-5">
                <a class="btn btn-sm btn-outline-danger" href="?a=carrinho">Cancelar a Compra</a>
            </div>
            <div class="col-4 text-center">
                <a class="btn btn-sm btn-outline-success mb-3" href="?a=loja">Continuar a compra</a>
            </div>
            <div class="col-4 text-center">
                <a href="?a=escolher_metodo_pagamento" onclick="endereco_alternativo()"><button class="btn btn-sm btn-success">Escolher o metodo de pagamento</button></a>
            </div>
        </div>

    </div>
</div>