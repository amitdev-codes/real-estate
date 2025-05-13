<template>
    <!-- Start Content -->
    <div class="md:flex justify-between items-center">
        <!-- <h5 class="text-sm font-semibold">{{ pageTitle }}</h5> -->

        <!-- <a v-if="breadcrumbs"  href="javascript:void(0)" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100  focus:ring-1 focus:outline-none focus:ring-blue-300 rounded-sm px-3 py-2 text-sm font-medium text-center inline-flex items-center dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"> -->
        <a v-if="breadcrumbs"  href="javascript:void(0)" class="rounded-sm px-3 py-2 text-sm font-medium text-center inline-flex items-center me-2 mb-2 text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
        <svg class="ltr:rotate-180 w-3.5 h-3.5 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
        </svg>
        <Link :href="route(breadcrumbs[0].route)">Back</Link>
        </a>

        <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
            <li class="inline-block capitalize text-sm font-semibold duration-500 dark:text-white/70 hover:text-green-600 dark:hover:text-white">
                <Link :href="route('admin.dashboard')">Dreamestate</Link>
            </li>
            <div v-for="breadcrumb in breadcrumbs" :key="breadcrumb.route" class="inline-block">
                <li class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                <i class="mdi mdi-chevron-right"></i></li>
                <li class="inline-block capitalize text-sm font-medium dark:text-white" aria-current="page">
                    <Link :href="route(breadcrumb.route)">{{ breadcrumb.name }}</Link>
                </li>
            </div>
            <li class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                <i class="mdi mdi-chevron-right"></i></li>
            <li class="inline-block capitalize text-sm font-medium dark:text-white"
                aria-current="page">{{ pageTitle }}</li>
        </ul>
    </div>
</template>

<script setup>
    const props = defineProps({
        pageTitle: {
            type: String,
        },
        breadcrumbs: {
            type: Array,
        },
    });
</script>

<style lang="scss" scoped>

</style>
