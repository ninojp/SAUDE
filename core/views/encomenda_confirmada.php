<div class="container">
    <div class="row m-4">
        <div class="col-sm-8 offset-sm-3">
            <h3 class="text-center">Encomenda Confirmada</h3>
            <p class="text-center">Muito obrigado pela sua encomenda.</p>
            <div class="my-2">
                <h4>Dados de Pagamento</h4>
                <p>Conta bancária: 123456789</p>
                <p>Código da encomenda:<strong> <?= $codigo_encomenda ?></strong></p>
                <p>Total da encomenda:<strong> <?= 'R$ '.number_format($total_encomenda,2,',','.') ?></strong></p>
            </div>
            <p>Você vai receber um email com a confirmação da encomenda e os dados de pagemento.<br>
            <small>Por favor verifique se o email aparece na sua conta, ou se foi para a pasta de SPAM</small></p>
            <p>A sua encomenda só será processada após o pagamento.</p>
            <div class="my-5"><a class="btn btn-primary" href="?a=inicio">Voltar</a></div>
        </div>
    </div>
</div>