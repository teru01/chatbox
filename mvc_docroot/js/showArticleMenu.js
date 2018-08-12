const switch_article_menu = (i) => {
    const menu = document.getElementsByClassName('article_menu_wrapper')[i];
    if(menu.style.display === 'block'){
        menu.style.display = 'none';
    } else {
        menu.style.display = 'block';
    }
};

document.addEventListener('DOMContentLoaded', () => {
    Array.from(document.getElementsByClassName('arrow')).forEach(
        (arrow, i) => {
            arrow.addEventListener('click', () => {
                event.preventDefault();
                switch_article_menu(i);
            }, false);
        }
    );
}, false);

const find_closest_parent = (elm, name) => {
    while(elm){
        elm = elm.parentElement;
        if(elm.className && elm.className === name){
            return elm;
        }
    }
};

/**
 * メッセージの部分をtextareaに置換し、編集できるようにする。
 * @param elm
 */
const editArticle = (elm) => {
    const article = find_closest_parent(elm, 'article').getElementsByClassName('article_content')[0];
    const message_box = article.getElementsByClassName('message')[0];

    let message = document.createTextNode(message_box.textContent);
    const text_input_area = document.createElement('textarea');
    text_input_area.appendChild(message);

    article.replaceChild(text_input_area, message_box);
    text_input_area.focus();

};

document.addEventListener('DOMContentLoaded', () => {
    for(let elm of Array.from(document.getElementsByClassName('edit_article')).entries()){
        elm[1].addEventListener('click', (event) => {
            event.preventDefault();
            editArticle(elm[1]);
        }, false);
    }
}, false);