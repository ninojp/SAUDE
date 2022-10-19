<div class="container">
    <div class="row m-4">
        <div class="col-sm-6 offset-sm-3">
            <h3 class="text-center">Registro de Novo Cliente</h3>
            <form action="?a=criar_cliente" method="post">
                <!-- input email ----------------------------------------------->
                <div class="mb-3">
                    <label for="text_email">E-Mail</label>
                    <input class="form-control" type="email" name="text_email" id="text_email" placeholder="Digite seu Email" required>
                </div>
                <!-- apresentar erro! -------------------------------------------------->
                <?php if(isset($_SESSION['erro_email_exist'])):?>
                    <div class="alert alert-warning text-center p-2">
                        <?=$_SESSION['erro_email_exist']?>
                        <?php unset($_SESSION['erro_email_exist'])?>
                    </div>
                <?php endif;?>
                <!-- input senha_1 ----------------------------------------------->
                <div class="mb-3">
                    <label for="text_senha_1">Digite uma senha</label>
                    <input class="form-control" type="password" name="text_senha_1" id="text_senha_1" placeholder="Digite sua Senha" required>
                </div>
                <!-- input senha_2 ----------------------------------------------->
                <div class="mb-3">
                    <label for="text_senha_2">Confirme sua senha</label>
                    <input class="form-control" type="password" name="text_senha_2" id="text_senha_2" placeholder="Repita sua Senha" required>
                </div>
                <!-- apresentar erro! -------------------------------------------------->
                <?php if(isset($_SESSION['erro_senha_rep'])):?>
                    <div class="alert alert-warning text-center p-2">
                        <?=$_SESSION['erro_senha_rep']?>
                        <?php unset($_SESSION['erro_senha_rep'])?>
                    </div>
                <?php endif;?>
                <!-- input nome_completo ----------------------------------------------->
                <div class="mb-3">
                    <label for="text_nome_completo">Digite seu Nome Completo</label>
                    <input class="form-control" type="text" name="text_nome_completo" id="text_nome_completo" placeholder="Nome e Sobrenome" required>
                </div>
                <!-- input endereco ----------------------------------------------->
                <div class="mb-3">
                    <label for="text_endereco">Digite seu Endereço</label>
                    <input class="form-control" type="text" name="text_endereco" id="text_endereco" placeholder="Nome da Rua, numero 00" required>
                </div>
                <!-- input cidade ----------------------------------------------->
                <div class="mb-3">
                    <label for="text_cidade">Digite sua Cidade</label>
                    <input class="form-control" type="text" name="text_cidade" id="text_cidade" placeholder="Nome da Cidade" required>
                </div>
                <!-- input telefone ----------------------------------------------->
                <div class="mb-3">
                    <label for="text_telefone">Digite seu Telefone</label>
                    <input class="form-control" type="text" name="text_telefone" id="text_telefone" placeholder="(xx) 9xxxx xxxx">
                </div>
                <!-- input botão de Submit ---------------------------------------->
                <div class="mb-3">
                    <input class="btn btn-primary" type="submit" value="Criar conta">
                </div>
            </form>
        </div>
    </div>
</div>

<!--------------------------------------------------------------------------------
	email *
	senha_1 *
	senha_2 *
	nome_completo *
	endereco *
	cidade *
	telefone 

--------------------------------------------------------------------------------->