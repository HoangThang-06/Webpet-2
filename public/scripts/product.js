const productsContainer = document.getElementById('products-container');
const filterBtns = document.querySelectorAll('.filter-btn');
const form = document.getElementById('filterForm');

let currentPage = 1;
let currentType = 'all';

function loadProducts(page = 1) {
    const searchValue = document.getElementById('search').value;

    const params = new URLSearchParams({
        page: page,
        type: currentType,
        search: searchValue
    });

    fetch('product-list.php?' + params.toString())
        .then(res => res.text())
        .then(html => {
            productsContainer.innerHTML = html;
            attachPaginationEvents();
        });
}

function attachPaginationEvents() {
    document.querySelectorAll('.page-link').forEach(link => {
        link.addEventListener('click', e => {
            e.preventDefault();
            const page = link.dataset.page;
            if (page) {
                currentPage = page;
                loadProducts(currentPage);
            }
        });
    });
}

// Click loại sản phẩm
filterBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        filterBtns.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        currentType = btn.dataset.type;
        currentPage = 1;
        loadProducts();
    });
});

// Submit form tìm kiếm
form.addEventListener('submit', e => {
    e.preventDefault();
    currentPage = 1;
    loadProducts();
});

// Load lần đầu
loadProducts();
