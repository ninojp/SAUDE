<div class="container-fluid">
    <div class="row my-3 justify-content-center">
        
        <div class="col-md-3">
            <?php include_once(__DIR__.'/layouts/admin_menu.php'); ?>
        </div>
        
        <div class="col-md-9 text-center">
            <h3>Lista de encomendas: <?=$filtro!=''?$filtro:''?></h3>
            <hr>
            <?php if(count($lista_encomenda)==0):?>
                <p><hr>Não existe encomendas registradas<hr></p>
            <?php else: ?>
                <table class="table table-striped" id="tabela_ecomenda">
                    <thead>
                        <th>Data</th>
                        <th>Código</th>
                        <th>Código</th>
                        <th>Nome Cliente</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>Status</th>
                        <th>Atualização</th>
                    </thead>
                    <tbody>
                        <?php foreach($lista_encomenda as $encomenda): ?>
                            <tr>
                                <td><?= $encomenda->data_encomenda; ?></td>
                                <td><?= $encomenda->codigo_encomenda; ?></td>
                                <td><?= $encomenda->nome_completo; ?></td>
                                <td><?= $encomenda->email; ?></td>
                                <td><?= $encomenda->telefone; ?></td>
                                <td><?= $encomenda->status; ?></td>
                                <td><?= $encomenda->updated_at; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){$('#tabela_ecomenda').DataTable();});
</script>

