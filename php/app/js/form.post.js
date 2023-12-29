window.addEventListener('load', function() {
    let form = document.querySelector('.form-post');
    if(form) form.addEventListener('submit', sendPostForm)
});

async function sendPostForm(event) {
    event.preventDefault();
    let data = new FormData(this);
    let files = document.querySelectorAll('[type="file"]');

    if(files.length){
        files.forEach((file, i) => { 
            data.delete([file.name]); 
            data.append(`${file.name}`, file.files[0])
        });
    }
    
    let url = this.action;

    fetch(url, { method: 'POST', body: data
        }).then(( response => response.json())).then(data => {
           if(data.message){
                document.querySelector('.ajax-response').innerHTML = data.message
           }

           if(data.redirect){
                location.href = data.redirect
           }
        })
}