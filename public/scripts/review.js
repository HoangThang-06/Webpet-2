const reviewList = document.getElementById('reviewList');
const filterBtns = document.querySelectorAll('.filter-btn');

let currentPage = 1;
let currentStar = 0;
const productId = document.querySelector('.review-box').dataset.product;

function loadReviews(page = 1) {
    const params = new URLSearchParams({
        star: currentStar,
        page: page,
        product: productId
    });

    fetch('review-list.php?' + params.toString())
        .then(res => res.text())
        .then(html => {
            reviewList.innerHTML = html;
            attachPaginationEvents();
        })
        .catch(err => {
            reviewList.innerHTML = '<p>Lỗi tải đánh giá</p>';
            console.error(err);
        });
}

function attachPaginationEvents() {
    document.querySelectorAll('.page-link').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const page = link.dataset.page;
            if (page) {
                currentPage = page;
                loadReviews(currentPage);
            }
        });
    });
}

// Click filter sao
filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        currentStar = btn.dataset.star;
        currentPage = 1;
        loadReviews(currentPage);
    });
});

loadReviews();
document.querySelectorAll('.add-cart').forEach(btn => {
    btn.addEventListener('click', function(e){
        e.preventDefault(); // ngăn href reload
        const productId = this.dataset.id;

        fetch('../../model/add-cart.php?id=' + productId)
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success'){
                // Popup đơn giản
                alert('Thêm giỏ hàng thành công!');
                // Load lại trang detail-product
                location.reload();
            } else {
                alert('Thêm giỏ hàng thất bại: ' + data.message);
            }
        })
        .catch(err => {
            alert('Có lỗi xảy ra');
            console.error(err);
        });
    });
});
