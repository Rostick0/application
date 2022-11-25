(function () {
    const projectBttonAdd = document.querySelector('.project__button_add');
    const productAdd = document.querySelector('.product_add');

    if (!productAdd) return;

    productAdd.onclick = function (e) {
        e.preventDefault();

        projectBttonAdd.insertAdjacentHTML('beforebegin', renderProductHtml(countCreated));

        setCounter(countCreated);

        const select = document.querySelectorAll('select');
        M.FormSelect.init(select);

        if (countCreated !== undefined) return;

        countCreated += 1;
    }
})();