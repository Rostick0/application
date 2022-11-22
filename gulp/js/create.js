(function () {
    const projectBttonAdd = document.querySelector('.project__button_add');
    const productAdd = document.querySelector('.product_add');

    if (!productAdd || !productHtml) return;

    productAdd.onclick = function(e) {
        e.preventDefault();

        projectBttonAdd.insertAdjacentHTML('beforebegin', productHtml);

        const select = document.querySelectorAll('select');
        M.FormSelect.init(select);

        if (!count_created) return;

        count_created++;
    }
})();