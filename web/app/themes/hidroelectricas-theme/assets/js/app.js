import swiper from './swiper';

export default class App {
  initCore() {
    swiper.init();
    this.initStickyHeader();
  }

  initStickyHeader() {
    const header = document.getElementById('site-header');
    if (!header) return;

    const threshold = header.offsetTop;

    window.addEventListener('scroll', () => {
      if (window.scrollY > threshold) {
        header.classList.add('sticky', 'top-0', 'z-50', 'shadow-sm');
      } else {
        header.classList.remove('sticky', 'top-0', 'z-50', 'shadow-sm');
      }
    }, { passive: true });
  }
}

function LoadApp() {
  const app = new App();
  app.initCore();
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', LoadApp);
} else {
  LoadApp();
}
