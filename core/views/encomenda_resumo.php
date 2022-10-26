<div class="container">
    <div class="row table-responsive justify-content-center mb-5">
        <div class="col-8 p-3 text-center">
            <!-- Tabela com as informações dos produtos --------------------------------->
            <h2>informações gerais da sua encomenda</h2>
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
                                    <?='R$ '.number_format($produto['preco'], 2, ',', '.');?>
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
                                    <h4><strong><?= 'R$ '.number_format($produto, 2, ',', '.');?></strong></h4>
                                </td>
                            </tr>
                    <?php endif;
                        $index++;
                    endforeach; ?>
                </tbody>
            </table>
            <!-- Exibe os Dados de Pagamento ------------------------------------------->
            <div class="row">
                <div class="col-12 text-start">
                    <h4><strong>Dados de Pagamento:</strong></h4>
                    <p><strong>Conta bancária:</strong> 12345678</p>
                    <p><strong>código da encomenda:</strong> <?=$_SESSION['codigo_encomenda'];?></p>
                    <p><strong>Total:</strong> <?='R$ '.number_format($produto, 2, ',', '.');?></p>
                </div><hr>
            </div>
            <!-- Botões para Cancelar a compra, Continuar comprando, Confirmar a encomenda ------------>
            <div class="row">
                <div class="col-4 ps-5">
                    <a class="btn btn-sm btn-outline-danger" href="?a=carrinho">Cancelar a Compra</a>
                </div>
                <div class="col-4 text-center">
                    <a class="btn btn-sm btn-outline-success mb-3" href="?a=loja">Continuar comprando</a>
                </div>
                <div class="col-4 text-center">
                    <a href="?a=confirmar_encomenda" onclick="endereco_alternativo()"><button class="btn btn-sm btn-success">Confirmar Encomenda</button></a>
                </div>
            </div>
        </div>
        <!-- exibe os dados atuais do cliente ------------------------------------------>
        <div class="col-4  mt-5 p-5 text-start">
            <h4 class="text-center">Dados do cliente</h4>
            <hr>
            <strong>Nome:</strong>  <?= $cliente->nome_completo ?><br>
            <strong>Endereço:</strong> <?= $cliente->endereco ?></strong><br>
            <strong>Cidade:</strong> <?= $cliente->cidade ?><br>
            <strong>Email:</strong> <?= $cliente->email ?><br>
            <strong>Telefone:</strong> <?= $cliente->telefone ?>
            <hr>
            <!-- checkbox com as opções para troca dos dados do cliente ----------------->
            <div class="form-check m-0 p-0">    
                <input class="form-check-input ms-3" onchange="usar_endereco_alternativo()" type="checkbox" name="check_endereco_alternativo" id="check_endereco_alternativo">
                <label class="form-check-label ms-2" for="check_endereco_alternativo">Redefinir dados do cliente</label>
            </div>
            <!-- div do id=endereco_alternativo para controle com o checkbox -->
            <div id="endereco_alternativo" class="" style="display:none;">
                <!-- endereço alternativo ------------------------------------------------>
            	<div class="input-group-sm mb-3">
                    <label class="form-label">Novo Endereço:</label>
                    <input class="form-control" type="text" id="text_endereco_alternativo">
                </div> 
                <!-- Cidade alternativa ------------------------------------------------------>
            	<div class="input-group-sm mb-3">
                    <label class="form-label">Nova Cidade:</label>
                    <input class="form-control" type="text" id="text_cidade_alternativo">
                </div>
                <!-- Telefone alternativo ---------------------------------------------------->
            	<div class="input-group-sm mb-3">
                    <label class="form-label">Novo Email:</label>
                    <input class="form-control" type="email" id="text_email_alternativo">
                </div> 
            <!-- Telefone alternativo ---------------------------------------------------->
            	<div class="input-group-sm mb-3">
                    <label class="form-label">Novo Telefone:</label>
                    <input class="form-control" type="text" id="text_telefone_alternativo">
                </div> 
            </div><hr> 
        </div>
    </div>
</div>