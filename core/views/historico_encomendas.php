<?php
use core\classes\Store; ?>
<div class="container">
    <div class="row m-4">
        <div class="col-sm-6 offset-sm-3">
            <h3 class="text-center">Histórico de encomendas</h3>
            <?php if (count($historico_encomendas) == 0) : ?>
                <p class="text-center">Não existe encomendas registradas</p>
            <?php else : ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Data da Encomenda</th>
                            <th>Código encomenda</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($historico_encomendas as $encomenda) : ?>
                            <tr>
                                <td><?= $encomenda->data_encomenda ?></td>
                                <td><?= $encomenda->codigo_encomenda ?></td>
                                <td><?= $encomenda->status ?></td>
                                <td><a class="btn btn-sm btn-outline-primary" href="?a=detalhe_encomenda&id=<?= Store::aesEcncriptar($encomenda->id_encomenda) ?>">Detalhes</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p>Total Encomendas: <strong><?= count($historico_encomendas); ?></strong>
                    <hr>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>