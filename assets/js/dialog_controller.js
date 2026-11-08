const dialog = document.querySelector('#editDialog');

document.querySelector('#editButton').addEventListener('click', () => {
    dialog.showModal();
});

document.querySelector('#cancelButton').addEventListener('click', () => {
    dialog.close();
});