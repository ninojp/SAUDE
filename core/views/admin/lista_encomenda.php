
<div class="container-fluid">
    <div class="row my-3 justify-content-center">
        
        <div class="col-md-3">
            <?php include_once(__DIR__.'/layouts/admin_menu.php'); ?>
        </div>
<!-- DESAFIO FEITO PELO PROFESSOR - apresentar o nome do filtro selecionado no OPTION do SELECT.
    A forma atual q ESTÁ, foi a q eu desenvolvi! abaixo vai estar  a forma q o professor explicou!
php
if(isset($_GET['f'])){
    $f = $_GET['f'];
}
//colocar(operador ternário) dentro do OPTION
<option value="" $f==''?'selected':''; ></option>$f==''?'selected':'';
<option value="pendente" $f=='pendente'?'selected':'pendente';>Pendentes</option>
-->

        <div class="col-md-9">
            <div class="row">
                <div class="col-5 text-center">
                    <label class="btn btn-sm btn-outline-primary" for="escolher_status">Escolher Estado:</label><br>
                    <select name="escolher_status" id="escolher_status" onchange="definir_filtro()">
                        <option value="<?=$filtro?>"><?=$filtro?></option>
                        <option value="pendente">Pendentes</option>
                        <option value="processamento">Em Processamento</option>
                        <option value="enviada">Enviadas</option>
                        <option value="cancelada">Canceladas</option>
                        <option value="concluida">Concluídas</option>
                    </select>
                </div>
                <div class="col-3  text-center">
                    <h4>Lista de encomendas: <?=$filtro!=''?$filtro:''?></h4>
                </div>
                <div class="col-4 text-center align-self-center">
                    <a class="btn btn-sm btn-outline-primary" href="?a=lista_encomenda">Todas as Encomendas</a>
                </div>
            </div><hr>
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
<!-- define o DATATABLE para a tabela com o ID=tabelaecomenda -->
<script>
$(document).ready( function () {
    $('#tabelaecomenda').DataTable({
        //define a LINGUAGEM(tradução) das propriedades da DataTable
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
function definir_filtro(){
    var filtro = document.getElementById('escolher_status').value;
    //Reload da pagina com o determinado filtro
    window.location.href = window.location.pathname+"?"+$.param({'a':'lista_encomenda','f': filtro});
}
</script>
