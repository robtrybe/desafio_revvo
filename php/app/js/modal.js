window.addEventListener('load', () => {
    modalInit();
    closeModal();
});

function modalInit(){
    const modal = document.querySelector('.modal-container');

    if(modal){
        let closeModal = localStorage.getItem('close-modal');
        if(!closeModal) {
            modal.classList.add('modal-show')
            localStorage.setItem('close-modal', 'hidden');
        }else{
            modal.classList.remove('modal-show')
        }
    }
}

function closeModal() {
    const modal = document.querySelector('.modal-close')

    if(modal) {
        modal.addEventListener('click', function() {
            document.querySelector('.modal-container').classList.remove('modal-show')
        })
    }
}