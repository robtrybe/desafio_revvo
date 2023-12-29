<?php $this->layout('site/base', ['title' => $title]); ?>


<form action="<?= url('/course/create'); ?>" method="post" class="form-post">
    <div><?= session()->flash() ?? ''; ?></div>
    <?= csrf_input(); ?>
    <input type="file" name="slide-image" >
    <input type="file" name="cover-image" >
    <input type="text" name="name" >
    <textarea name="description" cols="30" rows="10"></textarea>
    <button type="submit">Enviar</button>
</form>

<img src="uploads/images/php-cover.webp" alt="">

<script>
    window.addEventListener('load', function() {
        let form = document.querySelector('.form-post');
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
            console.log(this.action);

            let request = await fetch(url, { method: 'POST', body: data
                }).then(( response => response.json())).then(data => console.log(data))
        });
    }
});
</script>