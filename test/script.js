// Get all category titles
const categories = document.querySelectorAll('.category h2');

// Add event listener to toggle product tiles and rotate arrow
categories.forEach(category => {
  category.addEventListener('click', () => {
    const productTiles = category.nextElementSibling; // Find the corresponding product tiles
    const arrow = category.querySelector('.arrow'); // Find the arrow element

    // Toggle the 'open' class to animate the product tiles and arrow
    productTiles.classList.toggle('open');
    category.classList.toggle('open');
  });
});
