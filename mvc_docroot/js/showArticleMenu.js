const switch_article_menu = (i) => {
    const menu = document.getElementsByClassName('article_menu_wrapper')[i];
    if(menu.style.display === 'block'){
        menu.style.display = 'none';
    }else {
        menu.style.display = 'block';
    }
};


document.addEventListener('DOMContentLoaded', () => {
    const it = Array.from(document.getElementsByClassName('arrow')).entries();
    for(let elm of it){
        elm[1].addEventListener('click', () => {
            switch_article_menu(elm[0]);
        }, false);
    }
}, false);