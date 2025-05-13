<template>
    <!-- Start Hero -->
    <section
        class="relative table w-full py-32 lg:py-36 bg-[url('@frontend-assets/images/bg/01.jpg')] bg-no-repeat bg-center bg-cover">
        <div class="absolute inset-0 bg-black opacity-80"></div>
        <div class="container relative">
            <div class="grid grid-cols-1 text-center mt-10">
                <h3 class="md:text-4xl text-3xl md:leading-normal leading-normal font-medium text-white">List View
                    Layout</h3>
            </div><!--end grid-->
        </div><!--end container-->
    </section><!--end section-->
    <div class="relative">
        <div class="shape overflow-hidden z-1 text-white dark:text-slate-900">
            <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
            </svg>
        </div>
    </div>
    <div class="container relative -mt-16 z-1">
        <div class="grid grid-cols-1">
            <PriceList :grids="'grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 lg:gap-0 gap-6'" />
        </div><!--end grid-->
    </div><!--end container-->
    <!-- End Hero -->
    <section class="relative lg:py-24 py-16">
        <div class="container relative">
            <Properties :grids="'grid lg:grid-cols-2 grid-cols-1 gap-[30px] mt-8'" :width="'md:w-48'"/>
            <Pagination />
        </div>
    </section>
</template>

<script setup>
import PriceList from '@/frontend/components/buy-sell-rent/price-list.vue';
import Properties from '@/frontend/components/featured-properties/properties.vue';
import Pagination from '@/frontend/components/pagination.vue';
</script>

<style lang="scss" scoped></style>