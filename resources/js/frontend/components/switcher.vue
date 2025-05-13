<template>
  <!-- Switcher -->
  <!-- Switcher -->
  <div class="fixed top-1/4 -left-2 z-3">
    <span class="relative inline-block rotate-90">
      <input
        type="checkbox"
        class="checkbox opacity-0 absolute"
        id="chk"
        @change="changeMode($event)"
      />
      <label
        class="label bg-slate-900 dark:bg-white shadow dark:shadow-gray-700 cursor-pointer rounded-full flex justify-between items-center p-1 w-14 h-8"
        for="chk"
      >
        <i class="uil uil-moon text-[20px] text-yellow-500 mt-1"></i>
        <i class="uil uil-sun text-[20px] text-yellow-500 mt-1"></i>
        <span
          class="ball bg-white dark:bg-slate-900 rounded-full absolute top-[2px] left-[2px] size-7"
        ></span>
      </label>
    </span>
  </div>
  <!-- Switcher -->

  <!-- LTR & RTL Mode Code -->
  <div class="fixed top-[40%] -left-3 z-50">
    <a id="switchRtl">
      <span
        class="py-1 px-3 relative inline-block rounded-b-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-800 font-semibold rtl:block ltr:hidden cursor-pointer"
        @click="changeThem($event)"
        >LTR</span
      >
      <span
        class="py-1 px-3 relative inline-block rounded-b-md -rotate-90 bg-white dark:bg-slate-900 shadow-md dark:shadow dark:shadow-gray-800 font-semibold ltr:block rtl:hidden cursor-pointer"
        @click="changeThem($event)"
        >RTL</span
      >
    </a>
  </div>
  <!-- LTR & RTL Mode Code -->

  <div v-if="back" class="fixed bottom-3 end-3 z-10">
    <Link
      :href="route('frontend.index-one')"
      class="back-button btn btn-icon bg-green-600 hover:bg-green-700 text-white rounded-full"
    >
      <i data-feather="arrow-left" class="size-4"></i>
    </Link>
  </div>

  <!-- Back to top -->
  <Link
    :href="''"
    v-else
    @click="scrollToTop"
    v-show="showTopButton"
    id="back-to-top"
    class="fixed text-lg cursor-pointer rounded-full z-10 bottom-5 end-5 h-9 w-9 text-center bg-green-600 text-white leading-9"
  >
    <i class="uil uil-arrow-up"></i>
  </Link>
  <!-- Back to top -->
  <!-- Back to top -->
</template>

<script>
import feather from "feather-icons";
import logoDark from "@frontend-assets/images/logo-dark.png";
import logoLight from "@frontend-assets/images/logo-light.png";
import logoLightMobile from "@frontend-assets/images/02.png";
import logoDarkMobile from "@frontend-assets/images/01.png";

export default {
  props: {
    back: {
      type: Boolean,
      required: false,
      default: false,
    },
  },
  computed: {
    baseUrl() {
      return import.meta.env.VITE_APP_BASE_URL;
    },
  },
  data() {
    return {
      htmlTag: document.getElementsByTagName("html")[0],
      showTopButton: false,
      isMobile: false,
    };
  },
  mounted() {
    // Check if mobile and set the state
    this.isMobile = this.checkIfMobile();

    this.mobileLogo();
    feather.replace();
  },

  created() {
    window.addEventListener("scroll", this.handleScroll);
  },
  unmounted() {
    window.removeEventListener("scroll", this.handleScroll);
  },

  methods: {
    checkIfMobile() {
      const userAgent = navigator.userAgent || navigator.vendor || window.opera;
      return /android|webos|iphone|ipad|ipod|blackberry|iemobile|opera mini/i.test(
        userAgent.toLowerCase()
      );
    },
    mobileLogo() {
      const mobileLightLogo = document.querySelector(".is-mobile");
      if (mobileLightLogo) {
        // Apply the saved theme on mount
        const savedTheme = localStorage.getItem("theme") || "theme-green";
        const color = savedTheme === "theme-yellow" ? "#ffd400" : "#00423a";
        document.documentElement.style.setProperty("--color-green-600", color);

        const lightLogo = document.querySelector(".l-light");
        const toggle =
          savedTheme === "theme-yellow"
            ? this.isMobile
              ? logoLightMobile
              : logoLight
            : this.isMobile
            ? logoDarkMobile
            : logoDark;

        if (mobileLightLogo) {
          mobileLightLogo.src = toggle;
        }
        if (mobileLightLogo) {
          // Add a class if on mobile
          if (this.isMobile) {
            mobileLightLogo.style.setProperty("width", "50px", "important");
            mobileLightLogo.classList.add("mobile-class");
          } else {
            if(document.querySelector(".mobile-class").length){
                mobileLightLogo.classList.remove("mobile-class");
            }
          }
        } else {
          console.error('Element with class "is-mobile" not found');
        }
      }
    },
    handleScroll() {
      if (
        document.body.scrollTop >= 400 ||
        document.documentElement.scrollTop >= 400
      ) {
        this.showTopButton = true;

        const savedTheme = localStorage.getItem("theme") || "theme-green";
        const lightLogo = document.querySelector(".l-dark");
        const mobileLightLogo = document.querySelector(".mobile-class");

        if (mobileLightLogo) {
          if (savedTheme == "theme-green") {
            lightLogo.src = logoDark;
            mobileLightLogo ? (mobileLightLogo.src = logoDarkMobile) : "";
          } else {
            lightLogo.src = logoLight;
            mobileLightLogo ? (mobileLightLogo.src = logoLightMobile) : "";
          }
        } else {
          this.showTopButton = false;
        }
      }
    },
    changeThem(event) {
      if (event.target.innerText === "LTR") {
        this.htmlTag.dir = "ltr";
      } else {
        this.htmlTag.dir = "rtl";
      }
    },

    changeMode() {
      console.log("LOG >>>> ", logoLight);

      if (this.htmlTag.className.includes("dark")) {
        this.htmlTag.className = "light";
        const toggleLogo = document.querySelector(".toggle-image");
        toggleLogo.src = logoDark;
      } else {
        this.htmlTag.className = "dark";
        const toggleLogo = document.querySelector(".toggle-image");
        toggleLogo.src = logoLight;
      }
    },

    scrollToTop() {
      window.scrollTo({ top: 0, behavior: "smooth" });
    },
  },
};
</script>

<style lang="scss" scoped></style>
