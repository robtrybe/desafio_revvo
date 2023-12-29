window.addEventListener('load', function() {
    const ajaxPost = document.querySelector('.ajax-post');

    if(ajaxPost) {
        ajaxPost.addEventListener('click', sendAjaxPost)
    }
})

function sendAjaxPost(event) {
    event.preventDefault()

    const removeCourse = confirm('Tem certeza que deseja excluir este curso?');

    if(!removeCourse) return;

    const elem = event.target;
    const url = elem.dataset.url;
    const method = elem.dataset._method;

    const formData = new FormData();
    formData.append('_method', method);
    formData.append('url', url);

    const headers = new Headers()
    headers.append('Content_Type', 'x-www-form-urlencoded');
 
    fetch(url, {
        method: 'POST',
        body: formData
    }).then(response => response.json()).then(data => {
        if(data.redirect) {
            location.href = data.redirect
        }
    })
    
}