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
            <strong>Email:</strong> <?= $cliente->email ?><br>
            <strong>Nome:</strong>  <?= $cliente->nome_completo ?>
            <div class="form-check m-0 p-0">    
                <strong>Endereço:</strong> <?= $cliente->endereco ?></strong><br>
                <input class="form-check-input ms-3" onchange="usar_endereco_alternativo()" type="checkbox" name="check_endereco_alternativo" id="check_endereco_alternativo">
                <label class="form-check-label ms-2" for="check_endereco_alternativo">Definir um endereço diferente</label>
            </div>
            <div id="endereco_alternativo" class="" style="display:none;">
            endereco_alternativo
            </div>
            <strong>Cidade:</strong> <?= $cliente->cidade ?><br>
            <strong>Telefone:</strong> <?= $cliente->telefone ?>
        </div>

        <div class="row mb-5 p-3">
            <div class="col-4 ps-5">
                <button class="btn btn-sm btn-outline-danger">Cancelar a Compra</button>
            </div>
            <div class="col-4 text-center">
                <a href="?a=loja"><button class="btn btn-sm btn-outline-success mb-3">Continuar a compra</button></a>
            </div>
            <div class="col-4 text-center">
                <a href="?a=finalizar_encomenda"><button class="btn btn-sm btn-success">Escolher o metodo de pagamento</button></a>
            </div>
        </div>

    </div>
</div>