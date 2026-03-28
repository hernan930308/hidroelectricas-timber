import Swiper from "swiper";
import { Autoplay } from "swiper/modules";
import { Navigation, Pagination } from 'swiper/modules';

import "swiper/swiper.css";
import 'swiper/modules/navigation.css';
import 'swiper/modules/pagination.css'

const swiper = {
  init: () => {

    const hero_swiper_container = document.querySelector('.hero-swiper');

    if (hero_swiper_container) {
  
      const hero_swiper = new Swiper('.hero-swiper', {
        // configure Swiper to use modules
        modules: [Autoplay, Navigation],
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        loop: true,
        autoplay: {
          delay: 10000
        }
      });
    }

    const featured_producs_swiper_container = document.querySelector('.featured-products-swiper');

    if (featured_producs_swiper_container) {
      const featured_producs_swiper = new Swiper('.featured-products-swiper', {
        // configure Swiper to use modules
        modules: [Autoplay, Navigation, Pagination],
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        loop: true, 
        pagination: {
        el: ".swiper-pagination",
        },
        autoplay: {
          delay: 3000
        }
      });
    }

    const comments_swiper_container = document.querySelector('.comments-swiper');

    if (comments_swiper_container) {
      const comments_swiper = new Swiper('.comments-swiper', {
        // configure Swiper to use modules
        modules: [Autoplay, Navigation, Pagination],
        navigation: {
          nextEl: ".swiper-button-next",
          prevEl: ".swiper-button-prev",
        },
        loop: true,
        pagination: {
        el: ".swiper-pagination",
        },
        autoplay: {
          delay: 3000
        }
      });
    }

    const quickly_access_container = document.querySelector('.quickly-access-swiper');

    if (quickly_access_container) {
      const quickly_access_swiper = new Swiper('.quickly-access-swiper', {
        modules: [Autoplay],
        slidesPerView: 3,
        loop: true,
        autoplay: {
          delay: 3000
        },
        breakpoints: {
          768: {
            slidesPerView: 4,
          },
        },
      });
    }

  },
};

export default swiper;