<?php
use core\classes\Store;?>

<div class="container-fluid">
    <div class="row my-3 justify-content-center">
        
        <div class="col-md-2">
            <?php include_once(__DIR__.'/layouts/admin_menu.php'); ?>
        </div>
        
        <div class="col-md-10 text-center">
            <h2>Página com a Lista de Clientes</h2>
            <hr>
            <?php if(count($clientes)==0): ?>
                <p class="text-center text-muted">Não existem clientes registrados</p>
            <?php else: ?>
                <!-- apresenta a tabela de clientes -->
                <table class="table table-striped" id="tabela-clientes">
                    <thead>
                        <tr>
                            <th class="text-center">Nome:</th>
                            <th class="text-center">Email:</th>
                            <th class="text-center">Telefone:</th>
                            <th class="text-center">Total de encomendas</th>
                            <!-- ativo / inativo -->
                            <th class="text-center">Ativo:</th>
                            <!-- deleted_at -->
                            <th class="text-center">Eliminado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($clientes as $cliente): ?>
                            <tr>
                                <td class="text-center"><a href="?a=detalhe_cliente&c=<?= Store::aesEcncriptar($cliente->id_cliente) ;?>"><?= $cliente->nome_completo; ?></a></td>
                                <td class="text-center"><?= $cliente->email; ?></td>
                                <td class="text-center"><?= $cliente->telefone; ?></td>
                                <td class="text-center">
                                    <?php if($cliente->total_encomenda==0): ?>
                                        <span class=""><i class="text-danger fa-solid fa-circle-xmark"></i></span>
                                    <?php else: ?>
                                        <?= $cliente->total_encomenda;?>
                                    <?php endif; ?>
                                    </td>
                                <td class="text-center">
                                    <!-- ativo / inativo -->
                                    <?php if($cliente->activo==1): ?>
                                        <span class=""><i class="text-success fa-solid fa-circle-check"></i></span>
                                    <?php else: ?>
                                        <span class=""><i class="text-danger fa-solid fa-circle-xmark"></i></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <!-- deleted_at -->
                                    <?php if($cliente->deleted_at==NULL): ?>
                                    <span class=""><i class="text-danger fa-solid fa-circle-xmark"></i></span>
                                    <?php else: ?>
                                    <span class=""><i class="text-success fa-solid fa-circle-check"></i></span>
                                    <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- define o DATATABLE para a tabela com o ID=tabelaecomenda -->
<script>
$(document).ready( function () {
    $('#tabela-clientes').DataTable({
        //define a LINGUAGEM(tradução) das propriedades da DataTable
        language:{
                "decimal":        ",",
                "emptyTable":     "No data available in table",
                info: 'Mostrando página _PAGE_ de _PAGES_',
                infoEmpty: 'Não existe clientes disponíveis',
                infoFiltered: '(Filtrado de _MAX_ total de clientes)',
                "infoPostFix":    "",
                "thousands":      ".",
                lengthMenu: 'Apresente _MENU_ clientes por página',
                "loadingRecords": "Loading...",
                "processing":     "",
                "search":         "Pesquisar:",
                zeroRecords: 'Não foram encontradas clientes',
                "paginate": {
                    "first":      "Primeira",
                    "last":       "Última",
                    "next":       "Próxima",
                    "previous":   "Anterior"
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }
        });
} );
</script>
