import Swiper from 'swiper/bundle';

import 'swiper/css/bundle';

const swiper = new Swiper(".swiper-animal-thumbnails", {
  loop: true,
  watchSlidesVisibility: true,
  watchSlidesProgress: true,
  spaceBetween: 10,
  slidesPerView: 5.5,
  freeMode: true,

});


const swiper2 = new Swiper(".mySwiper2", {
  spaceBetween: 10,
  thumbs: {
    swiper: swiper,
  },
});


document.addEventListener('livewire:init', () => {

Livewire.on('animalSponsored', url => {
  window.open(url, '_blank');
});

});
