document.addEventListener("DOMContentLoaded", () => {
  const counters = document.querySelectorAll(".counter");
  let hasCounted = false;
  const countObserver = new IntersectionObserver(
    (entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting && !hasCounted) {
          counters.forEach((counter) => {
            const target = +counter.getAttribute("data-target");
            let count = 0;
            const speed = target / 100;
            const updateCount = () => {
              if (count < target) {
                count += speed;
                counter.innerText = Math.ceil(count);
                requestAnimationFrame(updateCount);
              } else {
                counter.innerText = target;
              }
            };
            updateCount();
          });
          hasCounted = true;
        }
      });
    },
    {
      threshold: 0.6
    }
  );
  counters.forEach((counter) => {
    countObserver.observe(counter);
  });
});
document.addEventListener("DOMContentLoaded", function () {
  let currentPage = window.location.pathname.split("/").pop();
  if (!currentPage || currentPage === "index.php") {
    currentPage = "index.php";
  }
  document.querySelectorAll(".navbar-nav .nav-link").forEach(function (link) {
    const href = link.getAttribute("href");
    if (href === currentPage) {
      link.classList.add("active");
    } else {
      link.classList.remove("active");
    }
  });
});

