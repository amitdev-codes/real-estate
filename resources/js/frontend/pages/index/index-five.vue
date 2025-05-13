<template>
    <!-- Hero Start -->
    <section class="relative md:pt-44 pt-36 bg-gradient-to-b from-slate-50 dark:from-slate-800 to-transparent">
        <div class="container relative">
            <div class="grid grid-cols-1">
                <div class="text-center">
                    <h1 class="font-bold lg:leading-normal leading-normal text-4xl lg:text-5xl mb-6">Are you ready to
                        find your dream home</h1>
                    <p class="text-slate-400 mx-auto text-xl max-w-xl">A great plateform to buy, sell and rent your
                        properties without any agent or commisions.</p>

                    <div class="subcribe-form relative z-1 mt-8">
                        <form class="relative max-w-2xl mx-auto">
                            <i data-feather="search" class="size-5 absolute top-[47%] -translate-y-1/2 start-4"></i>
                            <input type="name" id="search_name" name="name"
                                class="rounded-full bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 ps-12"
                                placeholder="City, Address, Zip :">
                            <button type="submit"
                                class="btn bg-green-600 hover:bg-green-700 text-white rounded-full">Search</button>
                        </form><!--end form-->
                    </div>
                </div>
                <div class="relative -mt-[25px]">
                    <img src="@frontend-assets/images/bg/05.jpg" class="rounded-xl shadow-md dark:shadow-gray-700" alt="">
                    <div class="absolute bottom-2/4 translate-y-2/4 start-0 end-0 text-center">
                        <a @click="toggle" data-type="youtube" data-id="yba7hPeTSjk"
                            class="lightbox size-20 rounded-full shadow-md dark:shadow-gray-800 inline-flex items-center justify-center bg-white dark:bg-slate-900 text-green-600 cursor-pointer">
                            <i class="mdi mdi-play inline-flex items-center justify-center text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div><!--end Container-->
    </section>

    <!-- iframe start  -->
    <div :class="isActive ? 'fixed' : 'hidden'" class="bg-black/[0.9] top-0 left-0 bottom-0 w-[100%] h-[100%] z-999">
        <div class="h-[100%] flex items-center justify-center">
            <iframe src="https://www.youtube.com/embed/S_CGed6E610?feature=oembed" width="700" height="500"
                frameborder="0"></iframe>
        </div><button class="text-slate-400 absolute top-[20px] right-[20px]">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round" class="size-5" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"
                @click="toggle">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    <!-- iframe end  -->

    <section class="relative md:py-24 py-16">
        <ListingCategories :categories="true"/>
        <div class="container relative lg:mt-24 mt-16">
            <TransparencyControl :transparency="true" />
        </div>
        <div class="container relative lg:mt-24 mt-16">
        <HowItWorks />
        </div>
        <FeaturedPropertiesSlider />
        <div class="container relative lg:mt-24 mt-16">
            <Client />
        </div>
        <GetInTouch />
    </section>
</template>

<script setup>
import { ref } from 'vue';
import ListingCategories from '@/frontend/components/listing-categories.vue';
import TransparencyControl from '@/frontend/components/transparency-control.vue';
import HowItWorks from '@/frontend/components/how-it-work.vue';
import FeaturedPropertiesSlider from '@/frontend/components/featured-properties/featured-properties-slider.vue'
import Client from '@/frontend/components/clients/client.vue';
import GetInTouch from '@/frontend/components/get-in-touch.vue';
const isActive = ref(false);

function toggle() {
    isActive.value = !isActive.value;
}

</script>

<style lang="scss" scoped></style>