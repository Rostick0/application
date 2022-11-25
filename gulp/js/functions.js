function setCounter(countCreated) {
    const projectProduct = document.querySelector(`.project__product._${countCreated}`);

    const productСount = document.querySelector(`#product_count_${countCreated}`);
    const productPrice = document.querySelector(`#product_price_${countCreated}`);
    const productAmount = document.querySelector(`#product_amount_${countCreated}`);
    const productPurchasePrice = document.querySelector(`#product_purchase_price_${countCreated}`);
    const productPurchaseAmount = document.querySelector(`#product_purchase_amount_${countCreated}`);

    projectProduct.oninput = () => {
        productAmount.value = +productСount.value * +productPrice.value;
        productPurchaseAmount.value = +productСount.value * +productPurchasePrice.value;
    }
}