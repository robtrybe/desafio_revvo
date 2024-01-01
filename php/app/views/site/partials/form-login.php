<form action="<?= url('/login'); ?>" class="form-post form-register" method="POST">
    <?= csrf_input(); ?>
    <h1>Login</h1>
    <div class="ajax-response"><?= session()->flash() ?? ''; ?></div>
    <label for="email">EMAIL</label>
    <input type="text" name="email" id="email" placeholder="Email" >
    <label for="password">SENHA</label>
    <input type="password" name="password" id="password" placeholder="Senha" minlength=6 maxlength="12">
    <button type="submit" class="btn-register">Entrar</button>
</form>