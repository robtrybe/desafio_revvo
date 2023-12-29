<form action="<?= url('/admin/course/'.$course->id.'/edit'); ?>" class="form-post form-register" method="POST">
    <?= csrf_input(); ?>
    <h1>Atualizar</h1>
    <div class="ajax-response"><?= session()->flash() ?? ''; ?></div>
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="id" value="<?= $course->id ?? ''; ?>">
    <label for="slide-image">IMAGEM SLIDE</label>
    <input type="file" name="slide-image" id="slide-image">
    <label for="cover-image">IMAGEM DE CAPA</label>
    <input type="file" name="cover-image" id="cover-image">
    <label for="name">TITULO DO URSO</label>
    <input type="text" name="name" id="name" placeholder="Titulo" value="<?= $course->name ?? ''; ?>">
    <label for="description">DESCRIÇÃO</label>
    <textarea name="description" id="description" cols="30" rows="10" placeholder="Descrição do curso"><?= $course->description ?? ''; ?></textarea>
    <button type="submit" class="btn-edit">Editar</button>
    <button 
            type="button"
            class="btn-remove ajax-post"
            data-url="<?= url('/admin/course/'.$course->id); ?>"
            data-_method="DELETE"
    >Excluir</button>
</form>
