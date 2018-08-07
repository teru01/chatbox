document.addEventListener('DOMContentLoaded', () => {
    for(let elm of document.getElementsByClassName('reaction_icons')){
        elm.addEventListener('click', (event) => {
            //event.preventDefault();
            let xhr = new XMLHttpRequest();

            xhr.addEventListener('loadstart', () => {
                elm.nextElementSibling.textContent = '...';
            }, false);

            xhr.addEventListener('load', () => {
                elm.nextElementSibling.textContent = xhr.responseText;
            }, false);

            xhr.addEventListener('error', () => {
                elm.nextElementSibling.textContent = '?';
            }, false);

            xhr.open('GET', elm.value);

            xhr.send(null);
        }, false);
    }
}, false);
