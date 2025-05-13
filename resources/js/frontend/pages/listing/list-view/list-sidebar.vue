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
    <!-- End Hero -->
    <!-- Start -->
    <section class="relative lg:py-24 py-16">
        <div class="container relative">
            <div class="grid md:grid-cols-12 grid-cols-1 gap-[30px]">
                <Sidebar />

                <div class="lg:col-span-8 md:col-span-6">
                    <Properties :grids="'grid grid-cols-1 gap-[30px]'" :width="'md:w-64'" />
                    <Pagination />
                </div>
            </div>
        </div><!--end container-->
    </section><!--end section-->
    <!-- End -->
</template>

<script setup>
import Pagination from '@/frontend/components/pagination.vue';
import Sidebar from '@/frontend/components/listing/grid-view/grid-sidebar.vue';
import Properties from '@/frontend/components/featured-properties/properties.vue';
</script>

<style lang="scss" scoped></style>