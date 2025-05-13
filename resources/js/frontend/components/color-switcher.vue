<template>
    <div class="fixed top-[55%] -start-2 z-50">
      <span class="relative inline-block rotate-90">
        <input
          type="checkbox"
          @change="toggleTheme"
          class="checkbox opacity-0 absolute"
          id="color-switcher"
          :checked="isYellowTheme"
        />
            <label
                class="label bg-slate-900 yellow:bg-white shadow yellow:shadow-gray-700 cursor-pointer rounded-full flex justify-between items-center p-1 w-14 h-8"
                for="color-switcher">
                <i class="text-[20px] text-yellow-500 mt-1"></i>
                <i class="text-[20px] text-yellow-500 mt-1"></i>
                <span
            class="ball bg-white rounded-full absolute top-[2px] left-[2px] size-7 transform transition-transform"
            :class="isYellowTheme ? 'translate-x-6 bg-[#ffd400]' : 'translate-x-0 bg-[#00423a]'"
          ></span>
            </label>
        </span>
    </div>
  </template>

  <script>

  import logoDark from '@frontend-assets/images/logo-dark.png';
  import logoLight from '@frontend-assets/images/logo-light.png';
  import logoLightMobile from '@frontend-assets/images/02.png';
  import logoDarkMobile from '@frontend-assets/images/01.png';

  export default {

  data() {
    return {
      isYellowTheme: localStorage.getItem('theme') === 'theme-yellow',
      isMobile:false,
    };
  },
  computed: {
    baseUrl() {
      return import.meta.env.VITE_APP_BASE_URL;
    }
  },
  methods: {
    checkIfMobile() {
      const userAgent = navigator.userAgent || navigator.vendor || window.opera;
      return /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(userAgent.toLowerCase());
    },
    toggleTheme(event) {
      this.isYellowTheme = event.target.checked;
      const color = this.isYellowTheme ? '#ffd400' : '#00423a';
      document.documentElement.style.setProperty('--color-green-600', color);
      localStorage.setItem('theme', this.isYellowTheme ? 'theme-yellow' : 'theme-green');

      const lightLogo = document.querySelector('.l-light');
      const mobileLightLogo = document.querySelector('.is-mobile');
      const darkLogo = document.querySelector('.l-dark');

      if (this.isYellowTheme) {
        console.log('here1 >>>',logoLightMobile);
          lightLogo.src = logoLight;
          darkLogo.src = logoLight;
          mobileLightLogo.src = this.isMobile ? logoLightMobile : '';

      } else {
        console.log('down here1 >>>', logoDarkMobile);
          lightLogo.src = logoDark;
          darkLogo.src = logoDark;
          mobileLightLogo.src = this.isMobile ? logoDarkMobile : '';
      }
      if (mobileLightLogo) {
        // Add a class if on mobile
        if (this.isMobile) {
            mobileLightLogo.style.setProperty('width', '50px', 'important');
            mobileLightLogo.classList.add('mobile-class');
        } else {
            mobileLightLogo.classList.remove('mobile-class');
        }
      } else {
        console.error('Element with class "is-mobile" not found');
      }

    },
  },
  mounted() {
    // Check if mobile and set the state
    this.isMobile = this.checkIfMobile();

    console.log(this.isMobile);
    // Apply the saved theme on mount
    const savedTheme = localStorage.getItem('theme') || 'theme-green';
    const color = savedTheme === 'theme-yellow' ? '#ffd400' : '#00423a';
    document.documentElement.style.setProperty('--color-green-600', color);

    const lightLogo = document.querySelector('.l-light');
    const toggle = savedTheme === 'theme-yellow'
      ? (this.isMobile ? logoLightMobile : logoLight)
      : (this.isMobile ? logoDarkMobile : logoDark);

    if (lightLogo) {
      lightLogo.src = toggle;
    }

  },
};

  </script>

  <style scoped>
  .size-7 {
    width: 28px;
    height: 28px;
  }

  </style>
