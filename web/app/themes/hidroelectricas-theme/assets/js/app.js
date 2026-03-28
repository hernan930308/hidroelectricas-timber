import swiper from './swiper';

export default class App {
  initCore() {
    swiper.init();
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
