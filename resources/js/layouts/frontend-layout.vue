<template>
  <Head :title="meta.title">
    <link rel="icon" :href="favicon" type="image/x-icon">
    <meta
      head-key="dreamestate"
      :name="meta.meta_key"
      :content="meta.meta_description"
    />
    <meta property="og:url" :content="meta.url" />
    <meta property="og:title" :content="meta.title" />
    <meta property="og:description" :content="meta.description" />
    <meta property="og:type" :content="meta.type" />
    <meta property="og:image" :content="`${meta.image}`" />
  </Head>
  <div :class="mainClass">
    <Navbar
      :container="'container'"
      :nav-light="'justify-end'"
      :logo-light="true"
    />

    <main>
      <slot></slot>
    </main>
    <Footers />
    <!-- <Switcher/>
    <ColorSwitcher/> -->
  </div>
</template>

<script setup>

import defaultImg from '@frontend-assets/images/bg/01.jpg';
import favicon from '@frontend-assets/images/02.png';

import Navbar from "@/frontend/components/navbar/navbar.vue";
import Footers from "@/frontend/components/footers/footer.vue";
// import Switcher from "@/frontend/components/switcher.vue";
// import ColorSwitcher from '@/frontend/components/color-switcher.vue';

// @@
import { Head } from "@inertiajs/vue3";
import { onMounted } from "vue";
import { loadScript, loadStyle } from "@utils/load-scripts.js";
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

onMounted(async () => {
  try {
    // Load stylesheets
    await loadStyle(
      "https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.4/tiny-slider.css"
    );
    await loadStyle(
      "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
    );

    // Load scripts
    await loadScript(
      "https://cdnjs.cloudflare.com/ajax/libs/tiny-slider/2.9.2/min/tiny-slider.js"
    );
    await loadScript(
      "https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"
    );

    // extra Initialize eta garda huncha aba
  } catch (error) {
    console.error(error);
  }
});


const page = usePage();

const meta = computed(() => ({
  url: window.location.href,
  title: page.props?.meta?.title || 'Search for Real Estate, Property & Homes',
  description: page.props?.meta?.description || 'Search for Real Estate, Property & Homes',
  meta_key: page.props?.meta?.meta_key || 'Real Estate, Property & Homes, Land, Rent, Buy, Sell',
  meta_description: page.props?.meta?.meta_description || 'Search for Real Estate, Property & Homes',
  type: 'website',
  image: page.props?.meta?.image || defaultImg,
}));

</script>


<script>

export default {
  components: {
    // ColorSwitcher,
  },
  computed: {
    mainClass() {
      return this.$root.colorScheme === 'dark' ? 'text-primaryTextDark' : 'text-primaryTextLight';
    },
  },
};
</script>

<style src="../../css/frontend.css"></style>
