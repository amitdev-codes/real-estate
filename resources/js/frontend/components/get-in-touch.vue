<template>
    <div class="container relative lg:mt-24 mt-16">
        <div class="grid grid-cols-1 text-center">
            <h3 class="mb-6 md:text-3xl md:leading-normal text-2xl leading-normal font-semibold">Have Question ? Get in
                touch!</h3>

            <p class="text-slate-400 max-w-xl mx-auto">A great plateform to buy, sell and rent your properties without
                any agent or commisions.</p>

            <div class="mt-6">
                <Link :href="route('frontend.contact')" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md"><i
                        class="uil uil-phone align-middle me-2"></i> Contact us</Link>
            </div>
        </div><!--end grid-->
    </div><!--end container-->
</template>

<script setup>
import { Link } from '@inertiajs/vue3';

</script>

<style lang="scss" scoped></style>
