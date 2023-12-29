<form action="<?= url('/admin/course/create'); ?>" class="form-post form-register" method="POST">
    <?= csrf_input(); ?>
    <h1>Cadatrar</h1>
    <div class="ajax-response"><?= session()->flash() ?? ''; ?></div>
    <label for="slide-image">IMAGEM SLIDE</label>
    <input type="file" name="slide-image" id="slide-image">
    <label for="cover-image">IMAGEM DE CAPA</label>
    <input type="file" name="cover-image" id="cover-image">
    <label for="name">TITULO DO URSO</label>
    <input type="text" name="name" id="name" placeholder="Titulo">
    <label for="description">DESCRIÇÃO</label>
    <textarea name="description" id="description" cols="30" rows="10" placeholder="Descrição do curso"></textarea>
    <button type="button" class="btn-remove">Excluir</button>
    <button type="">Editar</button>
    <button type="submit" class="btn-register">Cadastrar</button>
</form>