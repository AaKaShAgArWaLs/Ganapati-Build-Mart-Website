
const categories = document.querySelectorAll('.category h2');

categories.forEach(category => {
    category.addEventListener('click', () => {
        const productTiles = category.nextElementSibling; // Get the <div class="product-tiles">
        const arrow = category.querySelector('.arrow'); // Get the arrow inside the <h2>

        // Toggle the 'open' class for smooth transition
        productTiles.classList.toggle('open');
        category.classList.toggle('open');
    });
});

console.log("shop.js is loaded");