<template>

    <!-- Start Hero -->
    <section class="swiper-slider-hero relative block h-screen" id="home">
        <div class="swiper-container absolute end-0 top-0 w-full h-full">
            <swiper class="swiper-wrapper duration-500" :modules="setup().modules"  :autoplay="autoplay" :speed="2000" >
                <swiper-slide class="swiper-slide flex items-center overflow-hidden ">
                    <div
                        class="slide-inner absolute end-0 top-0 w-full h-full slide-bg-image flex items-center bg-[url('@frontend-assets/images/bg/01.jpg')] bg-center;">
                        <div class="absolute inset-0 bg-black/70"></div>
                        <div class="container relative">
                            <div class="grid grid-cols-1">
                                <div class="text-center">
                                    <h1
                                        class="font-bold text-white lg:leading-normal leading-normal text-4xl lg:text-5xl mb-6">
                                        Easy way to find your <br> dream property</h1>
                                    <p class="text-white/70 text-xl max-w-xl mx-auto">A great plateform to buy, sell and
                                        rent your properties without any agent or commisions.</p>

                                    <div class="mt-6">
                                        <a href="" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md">See
                                            More</a>
                                    </div>
                                </div>
                            </div><!--end grid-->
                        </div><!--end container-->
                    </div><!-- end slide-inner -->
                </swiper-slide> <!-- end swiper-slide -->

                <swiper-slide class="swiper-slide flex items-center overflow-hidden">
                    <div
                        class="slide-inner absolute end-0 top-0 w-full h-full slide-bg-image flex items-center bg-[url('@frontend-assets/images/bg/02.jpg')] bg-center;">
                        <div class="absolute inset-0 bg-black/70"></div>
                        <div class="container relative">
                            <div class="grid grid-cols-1">
                                <div class="text-center">
                                    <h1
                                        class="font-bold text-white lg:leading-normal leading-normal text-4xl lg:text-5xl mb-6">
                                        We will help you find <br> your Wonderful home</h1>
                                    <p class="text-white/70 text-xl max-w-xl mx-auto">A great plateform to buy, sell and
                                        rent your properties without any agent or commisions.</p>

                                    <div class="mt-6">
                                        <a href="" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md">See
                                            More</a>
                                    </div>
                                </div>
                            </div><!--end grid-->
                        </div><!--end container-->
                    </div><!-- end slide-inner -->
                </swiper-slide> <!-- end swiper-slide -->
            </swiper>
            <!-- end swiper-wrapper -->

            <!-- swipper controls -->
            <!-- <div class="swiper-pagination"></div> -->
            <!-- <div
                class="swiper-button-next bg-transparent size-[35px] leading-[35px] -mt-[30px] bg-none border border-solid border-white/50 text-white hover:bg-green-600 hover:border-green-600 rounded-full text-center">
            </div>
            <div
                class="swiper-button-prev bg-transparent size-[35px] leading-[35px] -mt-[30px] bg-none border border-solid border-white/50 text-white hover:bg-green-600 hover:border-green-600 rounded-full text-center">
            </div> -->
        </div><!--end container-->
    </section><!--end section-->
    <!-- Hero End -->
    <section class="relative md:pb-24 pb-16">
        <div class="container relative z-1">
            <div class="grid grid-cols-1 justify-center">
                <div class="relative md:-mt-52 -mt-40">
                    <div class="grid grid-cols-1">
                        <BuySellRent />
                    </div>
                </div>
            </div>
        </div>
        <div class="container relative lg:mt-24 mt-16">
            <TransparencyControl :transparency=true />
        </div>
        <div class="container relative lg:mt-24 mt-16">
            <HowItWork />
        </div>
        <div  class="container relative lg:mt-24 mt-16">
        <Properties :properties=true :moreview=true :propertie=true />
        </div>
        <TrustedUsers />
        <AgentTeam />
        <div class="container relative lg:mt-24 mt-16">
            <Client />
        </div>
        <GetInTouch />
    </section>
</template>

<script setup>
import {ref} from 'vue'
import { Swiper, SwiperSlide } from 'swiper/vue';
import { Autoplay } from 'swiper/modules';
import 'swiper/css';
import BuySellRent from '@/frontend/components/buy-sell-rent/buy-sell-rent.vue';
import TransparencyControl from '@/frontend/components/transparency-control.vue';
import HowItWork from '@/frontend/components/how-it-work.vue';
import Properties from '@/frontend/components/featured-properties/properties.vue';
import TrustedUsers from '@/frontend/components/trusted-users.vue';
import AgentTeam from '@/frontend/components/agent-team.vue';
import Client from '@/frontend/components/clients/client.vue';
import GetInTouch from '@/frontend/components/get-in-touch.vue';

const autoplay = ref({
        delay: 4000,
        disableOnInteraction: true
      })

const setup = () => {
    return {
        modules: [Autoplay,],
    };
};

</script>

<style lang="scss" scoped></style>