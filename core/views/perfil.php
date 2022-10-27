<div class="container">
    <div class="row text-center">
        <div class="col-8">
           <table class="table table-striped">
            <?php foreach($dados_cliente as $key=>$value):?>
                <tr><td class="text-end"><?=$key?>:</td>
                    <td class=""><strong><?=$value?></strong></td>
                </tr>
            <?php endforeach;?>
           </table>
            
        </div>
    </div>
</div>
<!-- [dados_cliente] => stdClass Object
        (
            [email] => meu.sem@gmail.com
            [nome_completo] => Edenilson JP
            [endereco] => Meu endereço a atual
            [cidade] => Floranópolis
            [telefone] => (48) 98466 6666
        ) -->