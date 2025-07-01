// Galería de imágenes
const current = document.getElementById('current');
const thumbnails = document.querySelectorAll('.thumb');

thumbnails.forEach(thumb => {
  thumb.addEventListener('click', () => {
    thumbnails.forEach(img => img.classList.remove('active'));
    current.src = thumb.src;
    current.style.transform = 'scale(1.05)';
    setTimeout(() => {
      current.style.transform = 'scale(1)';
    }, 300);
    thumb.classList.add('active');
  });
});

// Animación de las tarjetas al cargar
document.addEventListener('DOMContentLoaded', function() {
  const cards = document.querySelectorAll('.card-flip');
  
  cards.forEach((card, index) => {
    setTimeout(() => {
      card.style.opacity = '0';
      card.style.transform = 'translateY(20px)';
      card.style.transition = 'all 0.5s ease';
      
      setTimeout(() => {
        card.style.opacity = '1';
        card.style.transform = 'translateY(0)';
      }, 100);
    }, index * 200);
  });
  
  // Animación para elementos de FAQ
  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach((item, index) => {
    setTimeout(() => {
      item.style.opacity = '0';
      item.style.transform = 'translateY(20px)';
      item.style.transition = 'all 0.5s ease';
      
      setTimeout(() => {
        item.style.opacity = '1';
        item.style.transform = 'translateY(0)';
      }, 100);
    }, index * 150 + 1000);
  });
});