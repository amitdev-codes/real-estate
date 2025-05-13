<template>
    <!-- Hero Start -->
    <section
        class="relative table w-full py-36 md:py-44 lg:py-56 bg-[url('@frontend-assets/images/bg/6.jpg')] bg-no-repeat bg-center bg-cover">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="container relative z-3">
            <div class="grid md:grid-cols-12 mt-10">
                <div class="lg:col-span-8 md:col-span-6">
                    <h1 class="font-semibold text-white lg:leading-normal leading-normal text-4xl lg:text-6xl mb-6">Find
                        the perfect <br>
                        <VueTypewriterEffect class="typewrite" data-period="2000"
                            :strings='["home", "villa", "office"]' /> for you
                    </h1>
                    <p class="text-white/70 text-xl max-w-xl">A great plateform to buy, sell and rent your properties
                        without any agent or commisions.</p>

                    <div class="mt-4">
                        <a href="" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md mt-3">Learn More
                        </a>
                    </div>
                </div>
            </div><!--end grid-->
        </div><!--end container-->
    </section><!--end section-->
    <div class="container relative -mt-16 z-1">
        <div class="grid grid-cols-1">
            <PriceList :grids="'grid lg:grid-cols-5 md:grid-cols-2 grid-cols-1 lg:gap-0 gap-6'" />
        </div>
    </div>
    <section class="relative md:py-24 py-16">
        <TransparencyControl :transparency=true />
        <FeaturedPropertiesSlider />
        <div class="lg:mt-24 mt-16">
            <ListingCategories />
        </div>
        <div class="container relative lg:mt-24 mt-16">
            <Client />
        </div>
    </section>
</template>

<script setup>
import VueTypewriterEffect from "vue-typewriter-effect";
import PriceList from '@/frontend/components/buy-sell-rent/price-list.vue';
import TransparencyControl from '@/frontend/components/transparency-control.vue';
import FeaturedPropertiesSlider from '@/frontend/components/featured-properties/featured-properties-slider.vue';
import ListingCategories from '@/frontend/components/listing-categories.vue';
import Client from '@/frontend/components/clients/client.vue';
</script>

<style lang="scss" scoped></style>