document.addEventListener('DOMContentLoaded', function() {
  // Product card functionality
  document.querySelectorAll('.product-card').forEach(card => {
      // Product click
      card.addEventListener('click', (e) => {
          if (!e.target.closest('.action-button')) {
              // Navigate to product detail page
              console.log('Navigate to product detail page');
          }
      });

      // Action buttons
      card.querySelectorAll('.action-button').forEach(button => {
          button.addEventListener('click', (e) => {
              e.stopPropagation();
              const action = button.getAttribute('title');
              
              switch(action) {

                  case 'Add to wishlist':
                      console.log('Added to wishlist');
                      // Add wishlist functionality
                      break;
                  case 'Share':
                      console.log('Share dialog opened');
                      // Add share functionality
                      break;
              }
          });
      });
  });

  // Filter functionality
  document.querySelector('.filter-options button').addEventListener('click', () => {
      console.log('Filter menu opened');
      // Add filter functionality
  });

  // Sort functionality
  document.querySelector('.sort-options select').addEventListener('change', (e) => {
      console.log('Sorting products by:', e.target.value);
      // Add sort functionality
  });

  // Pagination functionality
  document.querySelectorAll('.pagination button').forEach(button => {
      button.addEventListener('click', () => {
          // Remove active class from all buttons
          document.querySelectorAll('.pagination button').forEach(btn => {
              btn.classList.remove('active');
          });
          
          // Add active class to clicked button
          if (button.textContent !== 'Next') {
              button.classList.add('active');
          }
          
          console.log('Page changed to:', button.textContent);
          // Add pagination functionality
      });
  });
});