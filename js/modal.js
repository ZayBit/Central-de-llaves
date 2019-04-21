if (document.querySelector('.btn-new-key')) {
    let btnOpenModal = document.querySelector('.btn-new-key'),
        modal = document.querySelector('.modal-new-key');
    btnOpenModal.addEventListener('click', () => {
        modal.classList.add('modal-new-key-active');
        document.addEventListener('keyup', e => {
            if (e.which == 27) {
                modal.classList.remove('modal-new-key-active');
            }
        });
    });
}