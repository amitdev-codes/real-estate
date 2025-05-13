<template>
    <!-- Hero Start -->
    <section class="relative table w-full py-36 lg:py-44 overflow-hidden zoom-image">
        <div
            class="absolute inset-0 image-wrap z-1 bg-[url('@frontend-assets/images/bg/04.jpg')] bg-no-repeat bg-center bg-cover">
        </div>
        <div class="absolute inset-0 bg-black/70 z-2"></div>
        <div class="container relative z-3">
            <div class="grid grid-cols-1 mt-10">
                <div class="text-center">
                    <h1 class="font-bold text-white lg:leading-normal leading-normal text-4xl lg:text-5xl mb-6">Easy way
                        to find your <br> dream property</h1>
                    <p class="text-white/70 text-xl max-w-xl mx-auto">A great plateform to buy, sell and rent your
                        properties without any agent or commisions.</p>
                </div>

                <BuySell />
            </div><!--end grid-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- Hero End -->
    <section class="relative lg:py-24 py-16">
        <div class="container relative">
            <TransparencyControl  :transparency="false"/>
        </div>
        <div class="container relative lg:mt-24 mt-16">
            <HowItWorks />
        </div>
        <FeaturedProperties :featured="true" :featureds="true"  />
    </section>
    <Cta />
    <section class="pt-10">
        <div class="container relative">
            <CompanyLogos />
        </div><!--end container-->
    </section><!--end section-->
    <section class="relative lg:py-24 py-16">
        <div class="container relative">
            <Client />
        </div>
        <GetInTouch />
    </section>
</template>

<script setup>
import BuySell from '@/frontend/components/buy-sell-rent/buy-sell-rent.vue';
import TransparencyControl from '@/frontend/components/transparency-control.vue';
import HowItWorks from '@/frontend/components/how-it-work.vue';
import FeaturedProperties from '@/frontend/components/featured-properties/featured-properties-slider.vue';
import Cta from '@/frontend/components/cta/cta.vue';
import CompanyLogos from '@/frontend/components/company-logo.vue';
import Client from '@/frontend/components/clients/client-slider.vue';
import GetInTouch from '@/frontend/components/get-in-touch.vue';
</script>

<style lang="scss" scoped></style>