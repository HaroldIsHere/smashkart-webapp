const images = [
    '/img/1.png',
    '/img/2.png',
    '/img/3.png',
];

let currentIndex = 0;

function showImage(index) {
    const imgElement = document.getElementById('albumImage');
    imgElement.src = images[index];
    imgElement.alt = 'Image ' + (index + 1);
}

function nextImage() {
    currentIndex = (currentIndex + 1) % images.length;
    showImage(currentIndex);
}

function prevImage() {
    currentIndex = (currentIndex - 1 + images.length) % images.length;
    showImage(currentIndex);
}

