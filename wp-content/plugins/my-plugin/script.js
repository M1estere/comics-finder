const prevButton = document.querySelector('.prev');
const nextButton = document.querySelector('.next');
prevButton.style.display = 'none';
nextButton.style.display = 'none';

jQuery(document).ready(function($) {
    const carousel = document.querySelector('.news-carousel');
    let currentIndex = 0;

    const rows = document.querySelectorAll('.news-row');
    const totalRows = rows.length;

    function updateCarousel() {
        const offset = -currentIndex * 100;
        carousel.style.transform = `translateX(${offset}%)`;

        if (totalRows <= 1) {
            prevButton.style.display = 'none';
            nextButton.style.display = 'none';
        } else {
            prevButton.style.display = currentIndex === 0 ? 'none' : 'block';
            nextButton.style.display = currentIndex === totalRows - 1 ? 'none' : 'block';
        }
    }

    prevButton.addEventListener('click', function() {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = totalRows - 1;
        }
        updateCarousel();
    });

    nextButton.addEventListener('click', function() {
        if (currentIndex < totalRows - 1) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateCarousel();
    });

    updateCarousel();
});
