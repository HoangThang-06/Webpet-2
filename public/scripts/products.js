const productsContainer = document.getElementById('products-list');
const categoryBtns = document.querySelectorAll('.category-btn');
let currentPage = 1;
let currentCategory = 'all';

// Hàm load sản phẩm
function loadProducts(page = 1) {
    const searchInput = document.getElementById('searchInput');
    const search = searchInput ? searchInput.value : '';
    const params = new URLSearchParams({
        page: page,
        category: currentCategory,
        search: search
    });

    fetch('products-list.php?' + params.toString())
        .then(res => res.text())
        .then(html => {
            productsContainer.innerHTML = html;
            attachPaginationEvents();
        })
        .catch(err => console.error('Lỗi load sản phẩm:', err));
}

// Gắn sự kiện phân trang
function attachPaginationEvents() {
    const pageLinks = productsContainer.querySelectorAll('.pagination a.btn');
    pageLinks.forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const page = link.dataset.page;
            if (page) {
                currentPage = parseInt(page);
                loadProducts(currentPage);
            }
        });
    });
}

// Gắn sự kiện chọn category
categoryBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        categoryBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        currentCategory = btn.dataset.category;
        currentPage = 1;
        loadProducts();
    });
});

// Search input với debounce
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    let searchTimeout;
    searchInput.addEventListener('keyup', () => {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            currentPage = 1;
            loadProducts();
        }, 400);
    });
}

// Load sản phẩm lần đầu
document.addEventListener('DOMContentLoaded', () => {
    loadProducts();
});
