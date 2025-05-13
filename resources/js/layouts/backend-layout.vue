<template>
    <Head>
        <title>www.dreamestate.com.au</title>
    </Head>
    <div class="page-wrapper" :class="toggle === true ? 'toggled' : ''">
        <Sidebar />
        <main class="page-content bg-gray-50 dark:bg-slate-800">
            <Header :handlerClick="toggled" />
            <!--Container Start-->
            <div class="container-fluid relative px-3 md:px-4 lg:px-12 xl:px-32">
              <div class="layout-specing">
                <slot></slot>
              </div>
            </div>
            <!--Container End-->
            <Footer />
        </main>
    </div>
    <Switcher />
</template>

<script setup>
import { ref } from 'vue';
import Header from "@/backend/components/header/header.vue";
import Footer from "@/backend/components/footer/footer.vue";
import Sidebar from "@/backend/components/sidebar/sidebar.vue";
import Switcher from "@/backend/components/switcher.vue";

// @@
import { Head } from '@inertiajs/vue3';
import { onMounted } from 'vue';
import { loadScript, loadStyle } from '@utils/load-scripts.js';

const toggle = ref(true)

function toggled() {
    toggle.value = !toggle.value
}

onMounted(async () => {
  try {
    // Load stylesheets
    await loadStyle('https://unpkg.com/simplebar@latest/dist/simplebar.css');
    // Load scripts
    await loadScript('https://unpkg.com/simplebar@latest/dist/simplebar.min.js');

    // extra Initialize eta garda huncha aba

  } catch (error) {
    console.error(error);
  }
});

</script>

<style src="../../css/backend.css"></style>

