(function () {
    const projectBttonAdd = document.querySelector('.project__button_add');
    const productAdd = document.querySelector('.product_add');

    function setCounter(countCreated) {
        const projectProduct = document.querySelector(`.project__product._${countCreated}`);
    
        const productUnitMeasurement = document.querySelector(`#product_unit_measurement_${countCreated}`);
        const productPrice = document.querySelector(`#product_price_${countCreated}`);
        const productAmount = document.querySelector(`#product_amount_${countCreated}`);
        const productPurchasePrice = document.querySelector(`#product_purchase_price_${countCreated}`);
        const productPurchaseAmount = document.querySelector(`#product_purchase_amount_${countCreated}`);
    
        projectProduct.oninput = () => {
            productPurchasePrice.value = +productUnitMeasurement.value * +productPrice.value;
            productPurchaseAmount.value = +productUnitMeasurement.value * +productAmount.value;
        }
    }

    if (!productAdd) return;

    productAdd.onclick = function (e) {
        e.preventDefault();

        projectBttonAdd.insertAdjacentHTML('beforebegin', renderProductHtml(countCreated));

        setCounter(countCreated);

        const select = document.querySelectorAll('select');
        M.FormSelect.init(select);

        if (countCreated !== undefined) return;

        countCreated += 1;

        console.log(countCreated)
    }
})();