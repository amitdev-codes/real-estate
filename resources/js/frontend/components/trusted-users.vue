<template>
    <div class="container relative lg:mt-24 mt-16 lg:pt-24 pt-16">
        <div
            class="absolute inset-0 opacity-25 dark:opacity-50 bg-[url('@frontend-assets/images/map.png')] bg-no-repeat bg-center bg-cover">
        </div>
        <div class="relative grid grid-cols-1 pb-8 text-center z-1">
            <h3 class="mb-4 md:text-3xl md:leading-normal text-2xl leading-normal font-semibold">Trusted by more than
                10K users</h3>

            <p class="text-slate-400 max-w-xl mx-auto">A great plateform to buy, sell and rent your properties without
                any agent or commisions.</p>
        </div><!--end grid-->

        <div class="relative grid md:grid-cols-3 grid-cols-1 items-center mt-8 gap-[30px] z-1">
            <div class="counter-box text-center">
                <h1 class="lg:text-5xl text-4xl font-semibold mb-2 text-slate-400 dark:text-white flex justify-center"><count-up
                        class="counter-value" :start-val="1010" :end-val="1548"></count-up>+</h1>
                <h5 class="counter-head text-lg font-medium">Properties Sell</h5>
            </div><!--end counter box-->

            <div class="counter-box text-center">
                <h1 class="lg:text-5xl text-4xl font-semibold mb-2 text-slate-400 dark:text-white flex justify-center"><count-up
                        class="counter-value" :start-val="2" :end-val="25"></count-up>+</h1>
                <h5 class="counter-head text-lg font-medium">Award Gained</h5>
            </div><!--end counter box-->

            <div class="counter-box text-center">
                <h1 class="lg:text-5xl text-4xl font-semibold mb-2 text-slate-400 dark:text-white flex justify-center"><count-up
                        class="counter-value" :start-val="0" :end-val="9"></count-up>+</h1>
                <h5 class="counter-head text-lg font-medium">Years Experience</h5>
            </div><!--end counter box-->
        </div>
    </div><!--end container-->
</template>

<script setup>
import  CountUp from 'vue-countup-v3';
</script>

<style lang="scss" scoped></style>