<?php

use core\classes\Store; ?>
<div class="container">
    <div class="row m-4">
        <div class="col-sm-8 offset-sm-3">
            <h3 class="text-center">Todos os dados da encomenda</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><h4>Dados da Encomenda</h4></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ID da encomenda:</td>
                        <td><?= $dados_encomenda->id_encomenda; ?></td>
                    </tr>
                    <tr>
                        <td>Data da encomenda:</td>
                        <td><?= $dados_encomenda->data_encomenda; ?></td>
                    </tr>
                    <!-- date_format($data_enco,'Y/m/d H:i:s');  -->
                    <tr>
                        <td>Codigo da Encomenda</td>
                        <td><?= $dados_encomenda->codigo_encomenda; ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><?= $dados_encomenda->status; ?></td>
                    </tr>
                    <tr>
                        <td>Mensagem</td>
                        <td><?php if(isset($dados_encomenda->mensagem)){echo $dados_encomenda->mensagem;} ?></td>
                    </tr>
                    <!-- parte dados do cliente ---------------------------------------->
                    <tr>
                        <th>
                            <h4>Dados do Cliente</h4>
                        </th>
                    </tr>
                    <tr>
                        <td>Nome (id)</td>
                        <td><?= $dados_encomenda->id_cliente; ?></td>
                    </tr>
                    <tr>
                        <td>endereco</td>
                        <td><?= $dados_encomenda->endereco; ?></td>
                    </tr>
                    <tr>
                        <td>cidade</td>
                        <td><?= $dados_encomenda->cidade; ?></td>
                    </tr>
                    <tr>
                        <td>email</td>
                        <td><?= $dados_encomenda->email; ?></td>
                    </tr>
                    <tr>
                        <td>telefone</td>
                        <!-- caso o telefone seja vazio devera aparecer um espaço em branco -->
                        <td><?= !empty($dados_encomenda->telefone) ? $dados_encomenda->telefone : '&nbsp' ; ?></td>
                    </tr>
                    <!-- parte dados dos Produtos ---------------------------------------->
                    <tr>
                        <th>
                            <h4>Produtos da encomenda</h4>
                        </th>
                    </tr>
                    <tr>
                        <th>Designação do Produto</th>
                        <th>Preco por unidade</th>
                        <th>Quantidade</th>
                    </tr>
                    <!--forma como ele fez no video -->
                    <?php foreach($produtos_encomenda as $produto):?>
                        <tr>
                            <td><?=$produto->designacao_produto;?></td>
                            <td><?= 'R$ '.number_format($produto->preco_unidade,2,',','.');?></td>
                            <td><?=$produto->quantidade;?></td>
                        </tr>
                    <?php endforeach;?>
                    <tr><td class="text-center"><strong>Valor Total:</strong></td><td></td><td><strong><?= 'R$ '.number_format($total_encomenda,2,',','.');?></strong></td></tr>
                    <!-- como eu havia feito 
                    <tr>
                        <td>//$produtos_encomenda[0]->designacao_produto;?></td>
                        <td>//$produtos_encomenda[0]->preco_unidade;?></td>
                        <td>//$produtos_encomenda[0]->quantidade;?></td>
                    </tr>-->
                </tbody>
            </table>
            <div class="row text-center">
                <div class="mb-5"><a class="btn btn-primary" href="?a=historico_encomendas">Voltar</a></div>
            </div>
            <?php 
            // Store::printData($produtos_encomenda);   ?>
            
        </div>
    </div>
</div>