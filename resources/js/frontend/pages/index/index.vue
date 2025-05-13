<template>
  <!-- Hero Start -->
  <section class="relative mt-20">
    <div class="container-fluid md:mx-4 mx-2">
      <div
        class="relative pt-40 pb-52 table w-full rounded-2xl shadow-md overflow-hidden duration-1000"
        id="home"
        :style="{
          'background-image': `url(${randomImage})`,
          backgroundPosition: 'center',
        }"
      >
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="container relative">
          <div class="grid grid-cols-1">
            <div class="md:text-start text-center">
              <h1 class="font-bold text-white lg:leading-normal leading-normal text-4xl lg:text-5xl mb-6" >
                We will help you find <br /> your <span class="text-green-600">Wonderful</span> home
              </h1>
              <p class="text-white/70 text-xl max-w-xl">
                A great plateform to buy, sell and rent your properties without any agent or commisions.
              </p>
            </div>
          </div>
          <!--end grid-->
        </div>
        <!--end container-->
      </div>
    </div>
    <!--end Container-->
  </section>
  <!--end section-->
  <!-- Hero End -->
  <section class="relative md:pb-24 pb-16">
    <BuySell />
    <div class="container relative lg:mt-24 mt-16">
      <TransparencyControl/>
    </div>
    <div class="container relative lg:mt-24 mt-16">
      <HowItWorks />
    </div>
    <div class="container relative lg:mt-24 mt-16">
      <FeaturedProperties
        :featured="true"
        :featureds="true"
        :featuredgrid="'grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-[30px]'"
        :grids="''"
      />
    </div>
    <div class="container relative lg:mt-24 mt-16">
      <Client />
    </div>
    <GetInTouch />
  </section>
</template>

<script setup>
import { ref, onMounted } from "vue";

import BuySell from "@/frontend/components/buy-sell-rent/home-search.vue";
import TransparencyControl from "@/frontend/components/transparency-control.vue";
import HowItWorks from "@/frontend/components/how-it-work.vue";
import FeaturedProperties from "@/frontend/components/featured-properties/featured-properties.vue";
import Client from "@/frontend/components/clients/client.vue";
import GetInTouch from "@/frontend/components/get-in-touch.vue";

import image from "@frontend-assets/images/bg/01.jpg";
import image2 from "@frontend-assets/images/bg/02.jpg";
import image3 from "@frontend-assets/images/bg/03.jpg";

const backgroundImages = [image, image2, image3];

const randomImage = ref("");

const changeBackground = () => {
  const randomIndex = Math.floor(Math.random() * backgroundImages.length);
  randomImage.value = backgroundImages[randomIndex];
};

onMounted(() => {
  changeBackground();
  setInterval(changeBackground, 4000);
});
</script>

<style lang="scss" scoped></style>
