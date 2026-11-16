const dialog = document.querySelector('#editDialog');

if (dialog.hasAttribute('data-open-on-load')) {
    dialog.showModal();
}

document.querySelector('#editButton').addEventListener('click', () => {
    dialog.showModal();
});

document.querySelector('#cancelButton').addEventListener('click', () => {
    dialog.close();
});
