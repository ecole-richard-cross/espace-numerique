document.querySelector('#notFrench').addEventListener('click', e => {
    const cp = document.querySelector('input[name$="[codePostal]"]');
    const pays = document.querySelector('input[name$="[pays]"]');
    if (e.target.checked) {
        cp.parentNode.classList.add('d-none');
        cp.value = 'n/a';
        pays.parentNode.classList.remove('d-none');
        pays.value = '';
    }
    else {
        cp.parentNode.classList.remove('d-none');
        cp.value = '';
        pays.parentNode.classList.add('d-none');
        pays.value = 'France';
    }
})