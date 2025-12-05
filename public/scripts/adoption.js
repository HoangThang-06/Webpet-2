const petsContainer = document.getElementById('pets-container');
const filterBtns = document.querySelectorAll('.filter-btn');
const form = document.getElementById('filterForm');
let currentPage = 1;
let currentType = 'all';
function loadPets(page = 1) {
  const searchInput = form.querySelector('input[name="search"]').value;
  const params = new URLSearchParams({
    page: page,
    type: currentType,
    search: searchInput
  });

  fetch('pets_list.php?' + params.toString())
    .then(res => res.text())
    .then(html => {
      petsContainer.innerHTML = html;
      attachPaginationEvents();
    });
}
function attachPaginationEvents() {
  document.querySelectorAll('.page-link').forEach(link => {
    link.addEventListener('click', e => {
      e.preventDefault();
      const page = link.dataset.page;
      if(page) {
        currentPage = page;
        loadPets(currentPage);
      }
    });
  });
}
filterBtns.forEach(btn => {
  btn.addEventListener('click', () => {
    filterBtns.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentType = btn.dataset.type;
    currentPage = 1;
    loadPets();
  });
});
form.addEventListener('submit', e => {
  e.preventDefault();
  currentPage = 1;
  loadPets();
});
loadPets();
//load
const overlays = document.querySelectorAll('.overlay-text');

const observer = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, { threshold: 0.5 });

overlays.forEach(el => observer.observe(el));
//chi tiet pet