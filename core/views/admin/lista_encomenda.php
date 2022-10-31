
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
                <table class="table table-striped" id="tabelaecomenda">
                    <thead>
                        <th>Data</th>
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
<!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script> -->
<!--------------------------------------------------------------------------------------------
VIA CDN baixado agora
------------------------------------------------------------------------------------------------->
<!-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.12.1/datatables.min.js"></script> -->

<script>
$(document).ready( function () {
    $('#tabelaecomenda').DataTable({
        language:{
                "decimal":        ",",
                "emptyTable":     "No data available in table",
                //pode ser neste formato (propriedade: 'valor',), sem aspas
                info: 'Mostrando página _PAGE_ de _PAGES_',
                infoEmpty: 'Não existe encomendas disponíveis',
                infoFiltered: '(Filtrado de _MAX_ total de encomendas)',
                "infoPostFix":    "",
                "thousands":      ".",
                lengthMenu: 'Apresente _MENU_ Encomendas por página',
                "loadingRecords": "Loading...",
                "processing":     "",
                "search":         "Pesquisar:",
                zeroRecords: 'Não foram encontradas encomendas',
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
