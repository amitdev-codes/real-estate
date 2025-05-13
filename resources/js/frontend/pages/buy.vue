<template>
    <!-- Start Hero -->
    <section
        class="relative table w-full py-32 lg:py-36 bg-[url('@frontend-assets/images/bg/01.jpg')] bg-no-repeat bg-center bg-cover">
        <div class="absolute inset-0 bg-black opacity-80"></div>
        <div class="container relative">
            <div class="grid grid-cols-1 text-center mt-10">
                <h3 class="md:text-4xl text-3xl md:leading-normal leading-normal font-medium text-white">Find Your Dream
                    Home</h3>
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

    <div class="container relative -mt-[25px]">
        <div class="grid grid-cols-1">
            <div class="subcribe-form z-1">
                <form class="relative max-w-2xl mx-auto">
                    <i data-feather="search" class="size-5 absolute top-[47%] -translate-y-1/2 start-4"></i>
                    <input type="name" id="search_name" name="name"
                        class="rounded-md bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 ps-12"
                        placeholder="City, Address, Zip :">
                    <button type="submit"
                        class="btn bg-green-600 hover:bg-green-700 text-white rounded-md">Search</button>
                </form><!--end form-->
            </div>
        </div><!--end grid-->
    </div><!--end container-->
    <!-- End Hero -->

    <section class="relative lg:py-24 py-16">
        <div class="container relative">
            <FeaturedProperties :featured=true :featureds=true  :featuredgrid="'grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-[30px]'" />
        </div>
        <BuyerBenefits />
        <Buy />
        <GetInTouch />
    </section>
</template>

<script setup>
import FeaturedProperties from '@/frontend/components/featured-properties/featured-properties.vue';
import BuyerBenefits from '@/frontend/components/buyer-benefits.vue';
import Buy from '@/frontend/components/buy.vue';
import GetInTouch from '@/frontend/components/get-in-touch.vue';
</script>

<style lang="scss" scoped></style>