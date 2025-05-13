<template>
    <!-- Hero Start -->
    <section class="relative py-40 lg:h-screen flex justify-center items-center bg-green-600/10">
        <div class="container relative">
            <div class="grid md:grid-cols-2 gap-[30px] mt-10 items-center">
                <div class="md:text-start text-center">
                    <h1 class="font-bold lg:leading-normal leading-normal text-4xl lg:text-5xl mb-6">Find Your <span
                            class="text-green-600">Perfect <br> & Wonderful</span> Home</h1>
                    <p class="text-slate-400 text-xl max-w-xl">A great plateform to buy, sell and rent your properties
                        without any agent or commisions.</p>

                    <div class="relative mt-8">
                        <div class="grid grid-cols-1">
                            <ul class="inline-block sm:w-fit w-full flex-wrap justify-center text-center p-4 bg-white dark:bg-slate-900 rounded-t-xl shadow dark:shadow-gray-700"
                                id="myTab" data-tabs-toggle="#StarterContent" role="tablist">
                                <li role="presentation" class="inline-block me-1">
                                    <button @click="toggles(1)"
                                        :class="Active === 1 ? 'text-white bg-green-600' : 'dark:hover:bg-slate-800 hover:text-green-600  hover:bg-gray-50 dark:hover:text-white'"
                                        class="px-6 py-2 text-base font-medium rounded-full w-full hover:text-green-600 transition-all duration-500 ease-in-out"
                                        id="buy-home-tab" data-tabs-target="#buy-home" type="button" role="tab"
                                        aria-controls="buy-home" aria-selected="true">Buy</button>
                                </li>
                                <li role="presentation" class="inline-block me-1">
                                    <button @click="toggles(2)"
                                        :class="Active === 2 ? 'text-white bg-green-600' : 'dark:hover:bg-slate-800 hover:text-green-600  hover:bg-gray-50 dark:hover:text-white'"
                                        class="px-6 py-2 text-base font-medium rounded-full w-full transition-all duration-500 ease-in-out"
                                        id="sell-home-tab" data-tabs-target="#sell-home" type="button" role="tab"
                                        aria-controls="sell-home" aria-selected="false">Sell</button>
                                </li>
                                <li role="presentation" class="inline-block">
                                    <button @click="toggles(3)"
                                        :class="Active === 3 ? 'text-white bg-green-600' : 'dark:hover:bg-slate-800 hover:text-green-600  hover:bg-gray-50 dark:hover:text-white'"
                                        class="px-6 py-2 text-base font-medium rounded-full w-full transition-all duration-500 ease-in-out"
                                        id="rent-home-tab" data-tabs-target="#rent-home" type="button" role="tab"
                                        aria-controls="rent-home" aria-selected="false">Rent</button>
                                </li>
                            </ul>

                            <div id="StarterContent"
                                class="p-6 bg-white dark:bg-slate-900 rounded-ss-none rounded-se-none md:rounded-se-xl rounded-xl shadow dark:shadow-gray-700">
                                <div :class="Active === 1 ? '' : 'hidden'" id="buy-home" role="tabpanel"
                                    aria-labelledby="buy-home-tab">
                                    <div class="subcribe-form z-1">
                                        <form class="relative max-w-2xl mx-auto">
                                            <i data-feather="search"
                                                class="size-5 absolute top-[47%] -translate-y-1/2 start-4"></i>
                                            <input type="name" id="search_name" name="name"
                                                class="rounded-full bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 ps-12"
                                                placeholder="City, Address, Zip :">
                                            <button type="submit"
                                                class="btn bg-green-600 hover:bg-green-700 text-white rounded-full">Find
                                                Out</button>
                                        </form><!--end form-->
                                    </div>
                                </div>

                                <div :class="Active === 2 ? '' : 'hidden'" id="sell-home" role="tabpanel"
                                    aria-labelledby="sell-home-tab">
                                    <div class="subcribe-form z-1">
                                        <form class="relative max-w-2xl mx-auto">
                                            <i data-feather="search"
                                                class="size-5 absolute top-[47%] -translate-y-1/2 start-4"></i>
                                            <input type="name" id="search_name" name="name"
                                                class="rounded-full bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 ps-12"
                                                placeholder="City, Address, Zip :">
                                            <button type="submit"
                                                class="btn bg-green-600 hover:bg-green-700 text-white rounded-full">Find
                                                Out</button>
                                        </form><!--end form-->
                                    </div>
                                </div>

                                <div :class="Active === 3 ? '' : 'hidden'" id="rent-home" role="tabpanel"
                                    aria-labelledby="rent-home-tab">
                                    <div class="subcribe-form z-1">
                                        <form class="relative max-w-2xl mx-auto">
                                            <i data-feather="search"
                                                class="size-5 absolute top-[47%] -translate-y-1/2 start-4"></i>
                                            <input type="name" id="search_name" name="name"
                                                class="rounded-full bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 ps-12"
                                                placeholder="City, Address, Zip :">
                                            <button type="submit"
                                                class="btn bg-green-600 hover:bg-green-700 text-white rounded-full">Find
                                                Out</button>
                                        </form><!--end form-->
                                    </div>
                                </div>
                            </div>
                        </div><!--end grid-->
                    </div>
                </div>

                <div class="relative lg:ms-10">
                    <div class="p-5 shadow dark:shadow-gray-700 rounded-t-full bg-white dark:bg-slate-900">
                        <img src="@frontend-assets/images/hero.jpg" class="shadow-md rounded-t-full rounded-md" alt="">
                    </div>
                    <div class="absolute bottom-2/4 translate-y-2/4 start-0 end-0 text-center">
                        <a @click="toggle" data-type="youtube" data-id="yba7hPeTSjk"
                            class="lightbox size-20 rounded-full shadow-md dark:shadow-gray-800 inline-flex items-center justify-center bg-white dark:bg-slate-900 text-green-600 cursor-pointer">
                            <i class="mdi mdi-play inline-flex items-center justify-center text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div><!--end Container-->
    </section><!--end section-->
    <!-- Hero End -->

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
        <div class="container relative">
            <TransparencyControl />
        </div>
        <div class="container relative lg:mt-24 mt-16">
            <HowItWorks />
        </div>
        <div class="container relative lg:mt-24 mt-16">
            <FeaturedProperties :featured=true :featureds=true :featuredgrid="'grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-[30px]'" />
        </div>
        <div class="container relative lg:mt-24 mt-16">
            <Client />
        </div>
        <GeiInTouch />
    </section>
</template>

<script setup>
import { ref } from 'vue'
import TransparencyControl from '@/frontend/components/transparency-control.vue';
import HowItWorks from '@/frontend/components/how-it-work.vue';
import FeaturedProperties from '@/frontend/components/featured-properties/featured-properties.vue';
import Client from '@/frontend/components/clients/client.vue';
import GeiInTouch from '@/frontend/components/get-in-touch.vue';

const isActive = ref(false)
const Active = ref(1)

function toggle() {
    isActive.value = !isActive.value
}

function toggles(Number) {
    Active.value = Number
}
</script>

<style lang="scss" scoped></style>