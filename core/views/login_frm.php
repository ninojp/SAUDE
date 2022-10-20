<div class="container">
    <div class="row">
        <div class="col-sm-4 offset-sm-4">
            <div>
                <h3 class="text-center">Login!</h3>
                <form action="?a=login_submit" method="POST">
                    <div class="my-3">
                        <label for="text_usuario">Usuário:</label>
                        <input class="form-control" type="email" name="text_usuario" id="text_usuario" placeholder="Usuário (email cadastrado)" required>
                    </div>
                    <div class="my-3">
                        <label for="text_senha">Senha:</label>
                        <input class="form-control" type="password" name="text_senha" id="text_senha" placeholder="Senha cadastrada" required>
                    </div>
                    <div class="my-3 text-center">
                        <input class="btn btn-primary" type="submit" value="Entrar">
                    </div>
                </form>
                <?php if(isset($_SESSION['erro_login'])):?>
                    <div class="alert alert-danger text-center">
                    <?= $_SESSION['erro_login'];?>
                    <?php unset($_SESSION['erro_login']);?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>