<?php $this->layout('site/base', ['title' => $title]); ?>



<form action="" action="<?= url('/course'); ?>" method="post" class="form-course">
    <?= csrf_input(); ?>
    <input type="file" name="slide-image" >
    <input type="file" name="cover-image" >
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
            
            let url = location.protocol + '//' + location.hostname + ':' + location.port

            let request = await fetch(url + '/course', { method: 'POST', body: data
                }).then(( response => response.json())).then(data => console.log(data))
        });
    }
});
</script>