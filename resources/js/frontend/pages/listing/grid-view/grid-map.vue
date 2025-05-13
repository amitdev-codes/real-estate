<template>
    <section class="relative">
        <div class="container-fluid">
            <div class="grid lg:grid-cols-2 md:grid-cols-2">
                <div>
                    <div class="relative mt-12 md:p-8 py-8 px-3">
                        <div class="grid grid-cols-1">
                            <PriceList :grids="'grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 lg:gap-0 gap-6'" />
                        </div>
                        <Properties :grids="'grid lg:grid-cols-2 grid-cols-1 mt-8 gap-[30px]'" />
                        <Pagination />
                    </div>
                </div>
                <div class="relative md:block hidden">
                    <div class="map border-0 fixed w-full leading-[0]">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39206.002432144705!2d-95.4973981212445!3d29.709510002925988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8640c16de81f3ca5%3A0xf43e0b60ae539ac9!2sGerald+D.+Hines+Waterwall+Park!5e0!3m2!1sen!2sin!4v1566305861440!5m2!1sen!2sin"
                            style="border:0" class="w-full h-screen" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import PriceList from '@/frontend/components/buy-sell-rent/price-list.vue';
import Properties from '@/frontend/components/featured-properties/featured-properties.vue';
import Pagination from '@/frontend/components/pagination.vue';
</script>

<style lang="scss" scoped></style>