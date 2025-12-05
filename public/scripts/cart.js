document.addEventListener('DOMContentLoaded', function(){

    function showToast(message, type='info'){
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.innerText = message;
        document.body.appendChild(toast);
        setTimeout(()=>toast.remove(),3000);
    }

    function updateCartTotal(){
        let total = 0;
        document.querySelectorAll('.item-price').forEach(e=>{
            const val = parseFloat(e.innerText.replace(/\./g,'').replace('₫',''));
            total += val;
        });
        const totalElem = document.querySelector('.cart-total-box .value');
        if(totalElem){
            totalElem.innerText = new Intl.NumberFormat('vi-VN').format(total) + '₫';
        }
    }

    // + / -
    document.querySelectorAll('.btn-qty').forEach(btn=>{
        btn.addEventListener('click', function(){
            const id = this.dataset.id;
            const action = this.dataset.action;
            fetch(`cart_action.php?action=${action}&id=${id}`)
            .then(res=>res.json())
            .then(data=>{
                if(data.newQty!==undefined){
                    const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
                    input.value = data.newQty;

                    const priceElem = document.querySelector(`.item-price[data-id="${id}"]`);
                    const unitPrice = parseFloat(priceElem.dataset.price);
                    priceElem.innerText = new Intl.NumberFormat('vi-VN').format(unitPrice * data.newQty) + '₫';

                    updateCartTotal();
                    showToast(data.message, data.status);
                }
            });
        });
    });

    // Lưu số lượng
    document.querySelectorAll('.btn-info').forEach(btn=>{
        btn.addEventListener('click', function(){
            const id = this.dataset.id;
            const input = document.querySelector(`.quantity-input[data-id="${id}"]`);
            let qty = parseInt(input.value);
            if(isNaN(qty) || qty < 1) qty = 1;

            fetch(`cart_action.php?action=save&id=${id}`,{
                method:'POST',
                headers:{'Content-Type':'application/x-www-form-urlencoded'},
                body:`quantity=${qty}`
            })
            .then(res=>res.json())
            .then(data=>{
                if(data.newQty!==undefined){
                    input.value = data.newQty;

                    const priceElem = document.querySelector(`.item-price[data-id="${id}"]`);
                    const unitPrice = parseFloat(priceElem.dataset.price);
                    priceElem.innerText = new Intl.NumberFormat('vi-VN').format(unitPrice * data.newQty) + '₫';

                    updateCartTotal();
                    showToast(data.message, data.status);
                }
            });
        });
    });

    // Xóa sản phẩm
    document.querySelectorAll('.btn-danger').forEach(btn=>{
        btn.addEventListener('click', function(){
            const id = this.dataset.id;
            fetch(`cart_action.php?action=delete&id=${id}`)
            .then(res=>res.json())
            .then(data=>{
                if(data.status==='success'){
                    const card = document.querySelector(`.order-card[data-id="${id}"]`);
                    if(card) card.remove();
                    updateCartTotal();
                    showToast(data.message, data.status);
                }
            });
        });
    });

});
