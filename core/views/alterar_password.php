<div class="container">
    <div class="row my-3 justify-content-center">
        <div class="col-6">
            <form action="?a=alterar_password_submit" method="post">
                <div class="mb-3">
                    <label class="form-label">Senha Atual:</label>
                    <input class="form-control" type="password" name="text_senha_atual" maxlength="30" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nova Senha:</label>
                    <input class="form-control" type="password" name="text_nova_senha" maxlength="30" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Repetir Nova senha:</label>
                    <input class="form-control" type="password" name="text_repetir_nova_senha" maxlength="30" required>
                </div>
                <!-- ERRO anterior TROCAR --------->
                <?php if(isset($_SESSION['erro_senha'])):?>
                <div class="alert alert-warning text-center p-2">
                    <?=$_SESSION['erro_senha']?>
                    <?php unset($_SESSION['erro_senha'])?>
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