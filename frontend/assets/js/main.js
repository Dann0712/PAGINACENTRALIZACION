// Carrusel 1: Horizontal
const carouselInner1 = document.querySelectorAll('.carousel-horizontal .carousel-inner')[0];
let currentIndex1 = 0;

// Carrusel 2: Horizontal (Antes era vertical)
const carouselInner2 = document.querySelectorAll('.carousel-horizontal .carousel-inner')[1];
let currentIndex2 = 0;

// Función para mover los carruseles
function moveCarousels() {
    // Mover carrusel 1
    currentIndex1 = (currentIndex1 + 1) % carouselInner1.children.length;
    carouselInner1.style.transform = `translateX(-${currentIndex1 * 100}%)`;

    // Mover carrusel 2
    currentIndex2 = (currentIndex2 + 1) % carouselInner2.children.length;
    carouselInner2.style.transform = `translateX(-${currentIndex2 * 100}%)`;
}

// Iniciar movimiento automático cada 3 segundos
setInterval(moveCarousels, 3000);
