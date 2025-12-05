const track = document.querySelector('.pet-track');
        const items = document.querySelectorAll('.pet-item');
        const btnNext = document.querySelector('.btn-next');
        const btnPrev = document.querySelector('.btn-prev');
        let index = 0;
        const visibleCount = 3;
        const itemStyle = getComputedStyle(items[0]);
        const itemWidth = items[0].offsetWidth + parseInt(itemStyle.marginLeft) + parseInt(itemStyle.marginRight);
        btnNext.addEventListener('click', () => {
            if (index < items.length - visibleCount) { 
                index++;
                track.style.transform = `translateX(-${index * itemWidth}px)`;
            }
        });
        btnPrev.addEventListener('click', () => {
            if (index > 0) {
                index--;
                track.style.transform = `translateX(-${index * itemWidth}px)`;
            }
        });