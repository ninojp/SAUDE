<div class="container">
    <div class="row my-3 justify-content-center">
        <div class="col-6">
            <form action="?a=alterar_dados_pessoais_submit" method="post">
                <div class="mb-3">
                    <label class="form-label">Email:</label>
                    <input class="form-control" type="email" name="text_email" maxlength="50" required value="<?= $dados_pessoais->email?>">
                </div>
                <!-- Apresentar o erro se o email for digitado errado --------->
                <?php if(isset($_SESSION['erro_email_invalido'])):?>
                <div class="alert alert-warning text-center p-2">
                    <?=$_SESSION['erro_email_invalido']?>
                    <?php unset($_SESSION['erro_email_invalido'])?>
                </div>
                <?php endif;?>
                <!-- Apresentar o erro de email se existir em OUTRA CONTA ------->
                <?php if(isset($_SESSION['erro_email_igual'])):?>
                <div class="alert alert-warning text-center p-2">
                    <?=$_SESSION['erro_email_igual']?>
                    <?php unset($_SESSION['erro_email_igual'])?>
                </div>
                <?php endif;?>
                <div class="mb-3">
                    <label class="form-label">Nome completo:</label>
                    <input class="form-control" type="text" name="text_nome_completo" maxlength="100" required value="<?= $dados_pessoais->nome_completo?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Endereco:</label>
                    <input class="form-control" type="text" name="text_endereco" maxlength="150" required value="<?= $dados_pessoais->endereco?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Cidade:</label>
                    <input class="form-control" type="text" name="text_cidade" maxlength="50" required value="<?= $dados_pessoais->cidade?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Telefone:</label>
                    <input class="form-control" type="text" name="text_telefone" maxlength="20" value="<?= $dados_pessoais->telefone?>">
                </div>
                <!-- Apresentar no preenchimento dos campos se existir --------->
                <?php if(isset($_SESSION['erro_dados_form'])):?>
                    <div class="alert alert-warning text-center p-2">
                        <?=$_SESSION['erro_dados_form']?>
                        <?php unset($_SESSION['erro_dados_form'])?>
                    </div>
                <?php endif;?>
                <div class="text-center">
                    <a class="btn btn-primary" href="?a=perfil">Cancelar</a>
                    <input class="btn btn-primary" type="submit" value="Salvar">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- 
[email] => meu.sem@gmail.com
[nome_completo] => Edenilson JP
[endereco] => Meu endereço a atual
[cidade] => Floranópolis
[telefone] => (48) 98466 6666 
-->