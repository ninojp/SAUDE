<div class="container-fluid">
    <div class="row my-3 justify-content-center">
        <div class="col-md-2">
            <?php include_once(__DIR__ . '/layouts/admin_menu.php'); ?>
        </div>
        <div class="col-md-10">
            <div class="row">
                <h3 class="text-center">Histórico de todas as encomendas deste cliente</h3>
                <div class="row">
                    <div class="col-4 fw-bold">
                        <p>Nome: <?= $cliente->nome_completo ;?></p>
                    </div>
                    <div class="col-4 fw-bold">
                        <p>Email: <?= $cliente->email ;?></p>
                    </div>
                    <div class="col-4 fw-bold">
                        <p>Telefone: <?= $cliente->telefone ;?></p>
                    </div>
                    <hr>
                </div>
                <?php if (count($lista_encomenda) == 0) : ?>
                    <p>
                        <hr>Não existe encomendas registradas<hr>
                    </p>
                <?php else : ?>
                    <table class="table table-striped" id="lista-encomenda-cliente">
                        <thead>
                            <th>Data</th>
                            <th>Endereço</th>
                            <th>Cidade</th>
                            <th>Email</th>
                            <th>Telefone</th>
                            <th>Código</th>
                            <th>Status</th>
                            <th>Mensagem</th>
                            <th>Atualizada em</th>
                        </thead>
                        <tbody>
                            <?php foreach ($lista_encomenda as $encomenda) : ?>
                                <tr>
                                    <?php $encomenda_date = DateTime::createFromFormat('Y-m-d H:i:s', $encomenda->data_encomenda); ?>
                                    <td><?= $encomenda_date->format('d-m-Y H:i') . 'h'; ?></td>
                                    <td><?= $encomenda->endereco; ?></td>
                                    <td><?= $encomenda->cidade; ?></td>
                                    <td><?= $encomenda->email; ?></td>
                                    <td><?= $encomenda->telefone; ?></td>
                                    <td><?= $encomenda->codigo_encomenda; ?></td>
                                    <td><?= $encomenda->status; ?></td>
                                    <td><?= $encomenda->mensagem; ?></td>
                                    <?php $atualizada = DateTime::createFromFormat('Y-m-d H:i:s', $encomenda->updated_at); ?>
                                    <td><?= $atualizada->format('d-m-Y H:i') . 'h'; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- define o DATATABLE para a tabela com o ID=tabelaecomenda -->
<script>
    $(document).ready(function() {
        $('#lista-encomenda-cliente').DataTable({
            //define a LINGUAGEM(tradução) das propriedades da DataTable
            language: {
                "decimal": ",",
                "emptyTable": "No data available in table",
                //pode ser neste formato (propriedade: 'valor',), sem aspas
                info: 'Mostrando página _PAGE_ de _PAGES_',
                infoEmpty: 'Não existe encomendas disponíveis',
                infoFiltered: '(Filtrado de _MAX_ total de encomendas)',
                "infoPostFix": "",
                "thousands": ".",
                lengthMenu: 'Apresente _MENU_ Encomendas por página',
                "loadingRecords": "Loading...",
                "processing": "",
                "search": "Pesquisar:",
                zeroRecords: 'Não foram encontradas encomendas',
                "paginate": {
                    "first": "Primeira",
                    "last": "Última",
                    "next": "Próxima",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }
        });
    });
</script>