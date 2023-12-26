<?php $this->layout('site/base', ['title' => $title]); ?>


<form action="" action="<?= url('/course/'.$course->id); ?>" method="post" class="form-course">
    <div><?= session()->flash() ?? ''; ?></div>
    <?= csrf_input(); ?>
    <input type="hidden" name="_method" value="PUT" >
    <input type="file" name="slide-image" >
    <input type="file" name="cover-image" >
    <input type="text" name="name" >
    <textarea name="description" cols="30" rows="10"></textarea>
    <button type="submit">Enviar</button>
</form>

<script>
    window.addEventListener('load', function() {
        let form = document.querySelector('.form-course');
        let files = document.querySelectorAll('[type="file"]');
 
        if(form){
            form.addEventListener('submit', async function(event) {
            event.preventDefault();
            let data = new FormData(this);
            if(files.length){
                files.forEach((file, i) => { 
                    data.delete([file.name]); 
                    data.append(`${file.name}`, file.files[0])
                });
            }
            
            let url = this.action;

            let request = await fetch(url, { method: 'POST', body: data
                }).then(( response => response.json())).then(data => console.log(data))
        });
    }
});
</script>