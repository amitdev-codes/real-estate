<template>
    <!-- Start CTA -->
    <section class="relative py-24 bg-[url('@frontend-assets/images/bg/01.jpg')] bg-no-repeat bg-center bg-fixed bg-cover">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="container relative">
            <div class="grid lg:grid-cols-12 grid-cols-1 md:text-start text-center justify-center">
                <div class="lg:col-start-2 lg:col-span-10">
                    <div class="grid md:grid-cols-3 grid-cols-1 items-center">

                        <div class="counter-box text-center">
                            <h1 class="text-white lg:text-5xl text-4xl font-semibold mb-2 flex justify-center"><count-up class="counter-value"
                                  :start-val="1010"   :end-val="1548">1010</count-up>+</h1>
                            <h5 class="counter-head text-white text-lg font-medium">Properties Sell</h5>
                        </div><!--end counter box-->


                        <div class="counter-box text-center">
                            <h1 class="text-white lg:text-5xl text-4xl font-semibold mb-2 flex justify-center"><count-up class="counter-value"
                                  :start-val="2"   :end-val="25">2</count-up>+</h1>
                            <h5 class="counter-head text-white text-lg font-medium">Award Gained</h5>
                        </div><!--end counter box-->


                        <div class="counter-box text-center">
                            <h1 class="text-white lg:text-5xl text-4xl font-semibold mb-2 flex justify-center"><count-up class="counter-value"
                                  :start-val="0"   :end-val="9">0</count-up>+</h1>
                            <h5 class="counter-head text-white text-lg font-medium">Years Experience</h5>
                        </div><!--end counter box-->
                    </div>
                </div>
            </div><!--end grid-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- End CTA -->
</template>

<script setup>
import  CountUp from 'vue-countup-v3';
</script>

<style lang="scss" scoped></style>