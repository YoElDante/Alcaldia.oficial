/* ===========================================
   ALCALD+IA - JavaScript Principal
   =========================================== */

document.addEventListener('DOMContentLoaded', function () {

  // ===========================================
  // SMOOTH SCROLL
  // ===========================================
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
      e.preventDefault();
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        const navbarHeight = document.getElementById('navbar').offsetHeight;
        const targetPosition = target.offsetTop - navbarHeight;

        window.scrollTo({
          top: targetPosition,
          behavior: 'smooth'
        });

        // Cerrar menú móvil si está abierto
        document.getElementById('navLinks').classList.remove('active');
        document.getElementById('hamburger').classList.remove('active');
      }
    });
  });

  // ===========================================
  // NAVBAR MOBILE - Hamburger Menu
  // ===========================================
  const hamburger = document.getElementById('hamburger');
  const navLinks = document.getElementById('navLinks');

  hamburger.addEventListener('click', function () {
    this.classList.toggle('active');
    navLinks.classList.toggle('active');
  });

  // Cerrar menú al hacer click fuera
  document.addEventListener('click', function (e) {
    if (!hamburger.contains(e.target) && !navLinks.contains(e.target)) {
      hamburger.classList.remove('active');
      navLinks.classList.remove('active');
    }
  });

  // ===========================================
  // NAVBAR - Cambio de fondo al scroll
  // ===========================================
  const navbar = document.getElementById('navbar');

  window.addEventListener('scroll', function () {
    if (window.scrollY > 100) {
      navbar.style.background = 'linear-gradient(to right, #E0F7FA, #00A8B5)';
      navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.15)';
    } else {
      navbar.style.background = 'linear-gradient(to right, #E0F7FA, #00A8B5)';
      navbar.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.1)';
    }
  });

  // ===========================================
  // CARRUSEL - Portal de Pago
  // ===========================================
  const carousel = document.getElementById('carousel');
  const slides = document.querySelectorAll('.slide');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  const dotsContainer = document.getElementById('carouselDots');

  let slideIndex = 0;
  const totalSlides = slides.length;
  let autoSlideInterval;

  // Crear dots
  function createDots() {
    for (let i = 0; i < totalSlides; i++) {
      const dot = document.createElement('span');
      dot.classList.add('carousel-dot');
      if (i === 0) dot.classList.add('active');
      dot.addEventListener('click', () => goToSlide(i));
      dotsContainer.appendChild(dot);
    }
  }

  // Actualizar dots
  function updateDots() {
    const dots = document.querySelectorAll('.carousel-dot');
    dots.forEach((dot, index) => {
      dot.classList.toggle('active', index === slideIndex);
    });
  }

  // Ir a slide específico
  function goToSlide(n) {
    slideIndex = n;
    if (slideIndex >= totalSlides) slideIndex = 0;
    if (slideIndex < 0) slideIndex = totalSlides - 1;

    carousel.style.transform = `translateX(-${slideIndex * 100}%)`;
    updateDots();
  }

  // Siguiente slide
  function nextSlide() {
    goToSlide(slideIndex + 1);
  }

  // Slide anterior
  function prevSlide() {
    goToSlide(slideIndex - 1);
  }

  // Auto-slide
  function startAutoSlide() {
    autoSlideInterval = setInterval(nextSlide, 5000);
  }

  function stopAutoSlide() {
    clearInterval(autoSlideInterval);
  }

  // Event listeners carrusel
  if (slides.length > 0) {
    createDots();
    startAutoSlide();

    prevBtn.addEventListener('click', () => {
      prevSlide();
      stopAutoSlide();
      startAutoSlide();
    });

    nextBtn.addEventListener('click', () => {
      nextSlide();
      stopAutoSlide();
      startAutoSlide();
    });

    // Pausar auto-slide al hover
    carousel.parentElement.addEventListener('mouseenter', stopAutoSlide);
    carousel.parentElement.addEventListener('mouseleave', startAutoSlide);

    // Soporte touch/swipe
    let touchStartX = 0;
    let touchEndX = 0;

    carousel.addEventListener('touchstart', (e) => {
      touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    carousel.addEventListener('touchend', (e) => {
      touchEndX = e.changedTouches[0].screenX;
      handleSwipe();
    }, { passive: true });

    function handleSwipe() {
      const swipeThreshold = 50;
      const diff = touchStartX - touchEndX;

      if (Math.abs(diff) > swipeThreshold) {
        if (diff > 0) {
          nextSlide();
        } else {
          prevSlide();
        }
        stopAutoSlide();
        startAutoSlide();
      }
    }
  }

  // ===========================================
  // ANIMACIONES SCROLL - Intersection Observer
  // ===========================================
  const fadeElements = document.querySelectorAll('.feature-card, .cliente-card, .sobre-content, .institucional-content, .contacto-content');

  fadeElements.forEach(el => el.classList.add('fade-in'));

  const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
  };

  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, observerOptions);

  fadeElements.forEach(el => observer.observe(el));

  // ===========================================
  // FORMULARIO DE CONTACTO
  // ===========================================
  const contactForm = document.getElementById('contactForm');

  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      e.preventDefault();

      const nombre = document.getElementById('nombre').value;
      const email = document.getElementById('email').value;
      const municipio = document.getElementById('municipio').value;
      const mensaje = document.getElementById('mensaje').value;

      // Crear mensaje para WhatsApp
      let whatsappMessage = `Hola, soy ${nombre}`;
      if (municipio) whatsappMessage += ` de ${municipio}`;
      whatsappMessage += `.%0A%0AEmail: ${email}`;
      if (mensaje) whatsappMessage += `%0A%0AMensaje: ${mensaje}`;
      whatsappMessage += `%0A%0AMe interesa conocer más sobre ALCALD+IA.`;

      // Abrir WhatsApp con el mensaje
      const whatsappURL = `https://wa.me/+543515575700?text=${whatsappMessage}`;
      window.open(whatsappURL, '_blank');

      // Mostrar confirmación
      alert('¡Gracias por contactarnos! Se abrirá WhatsApp para continuar la conversación.');

      // Limpiar formulario
      contactForm.reset();
    });
  }

  // ===========================================
  // ACTIVE LINK EN NAVBAR SEGÚN SCROLL
  // ===========================================
  const sections = document.querySelectorAll('section[id]');
  const navItems = document.querySelectorAll('.nav-links a');

  function highlightNavOnScroll() {
    const scrollY = window.pageYOffset;
    const navbarHeight = navbar.offsetHeight;

    sections.forEach(section => {
      const sectionTop = section.offsetTop - navbarHeight - 100;
      const sectionHeight = section.offsetHeight;
      const sectionId = section.getAttribute('id');

      if (scrollY >= sectionTop && scrollY < sectionTop + sectionHeight) {
        navItems.forEach(item => {
          item.classList.remove('active');
          if (item.getAttribute('href') === `#${sectionId}`) {
            item.classList.add('active');
          }
        });
      }
    });
  }

  window.addEventListener('scroll', highlightNavOnScroll);

  // ===========================================
  // LAZY LOADING PARA IMÁGENES
  // ===========================================
  const lazyImages = document.querySelectorAll('img[data-src]');

  if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          const img = entry.target;
          img.src = img.dataset.src;
          img.removeAttribute('data-src');
          imageObserver.unobserve(img);
        }
      });
    });

    lazyImages.forEach(img => imageObserver.observe(img));
  } else {
    // Fallback para navegadores sin IntersectionObserver
    lazyImages.forEach(img => {
      img.src = img.dataset.src;
    });
  }

  // ===========================================
  // CONSOLE LOG - Info del proyecto
  // ===========================================
  console.log('%c ALCALD+IA ', 'background: #00A8B5; color: white; font-size: 20px; font-weight: bold; padding: 10px;');
  console.log('%c Gestión Municipal Inteligente ', 'color: #003E5C; font-size: 14px;');
  console.log('%c www.alcaldia.store ', 'color: #00A8B5; font-size: 12px;');

});
