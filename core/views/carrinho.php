<div class="container">
    <div class="row">
        <div class="col-12">
        <?php if($carrinho == null): ?>
            <!-- Se o carrinho estiver VAZIO apresenta isto ------------------------------------->
            <div class="col-12 pt-4 text-center">
                <h3>Não existem itens no Carrinho</h3>
            </div>
            <div class="col-12 pt-4 text-center">
                <p><a class="btn btn-primary" href="?a=loja">Voltar a Loja</a></p>
            </div>
        <?php else:?>
            <!-- Se o carrinho conter ITENS apresenta isto ------------------------------------>
            <div class="row table-responsive mb-5">
                <div class="col-12 p-3 text-center">
                    <h2>Carrinho de Compras</h2>
                </div>
                <table class="table align-middle table-hover">
                    <thead><tr>
                            <th>Imagem</th>
                            <th>Produto</th>
                            <th class="text-center">Quantidade</th>
                            <th class="text-end">Valor Total</th>
                            <th class="text-center">Remover do Carrinho</th>
                    </tr></thead>
                    <tbody>
                    <?php $index = 0;
                        $total_rows = count($carrinho); 
                        foreach($carrinho as $produto):
                            if($index < $total_rows-1):?>
                            <!-- Lista dos produtos -->
                                <tr>
                                    <td><img class="img-fluid" width="80px" src="assets/imgs/produtos/<?= $produto['imagem'] ?>"></td>
                                    <td><?= $produto['titulo'] ?></td>
                                    <td class="text-center"><?= $produto['quantidade'] ?></td>
                                    <td class="text-end">
                                        <!--  //'R$ '.str_replace('.',',',$produto['preco'])  -->
                                        <?= 'R$ '.number_format($produto['preco'],2,',','.'); ?>
                                    </td>
                                    <td class="text-center"><a href="?a=remover_produto_carrinho&id_produto=<?=$produto['id_produto'];?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-times"></i></a></td>
                                </tr>
                            <?php else: ?>
                                <!-- Total -->
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td class="text-center"><h4><strong>Total:</strong></h4></td>
                                    <td class="text-end"><h4><strong>
                                        <?= 'R$ '.number_format($produto,2,',','.'); ?></strong></h4></td>
                                    <td></td>
                                </tr>
                            <?php endif;
                                $index++;
                                endforeach; ?>
                    </tbody>
                </table>
                <div class="row mb-5">
                    <div class="col-6">
                        <!-- <a class="btn btn-sm btn-outline-primary" href="?a=limpar_carrinho">Limpar Carrinho</a> -->
                        <button class="btn btn-sm btn-outline-primary" onclick="limpar_carrinho()">Limpar Carrinho</button>
                        <span class="ms-4" id="confirmar_limpar_carrinho" style="display:none;">Tem certeza?
                            <button class="btn btn-sm btn-primary" onclick="limpar_carrinho_off()">Não</button>
                            <a class="btn btn-sm btn-primary" href="?a=limpar_carrinho">Sim</a>
                        </span>
                    </div>
                    <div class="col-3 text-center">
                        <a href="?a=loja"><button class="btn btn-sm btn-outline-success mb-3">Continuar a compra</button></a>
                    </div>
                    <div class="col-3 text-center">
                        <a href=""><button class="btn btn-sm btn-success">Finalizar a compra</button></a>
                    </div>
                </div>
            </div>
        <?php endif;?>
        </div>
    </div>
</div>