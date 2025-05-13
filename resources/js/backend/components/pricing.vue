<template>
    <!-- Start Content -->
    <div class="md:flex justify-between items-center">
        <h5 class="text-lg font-semibold">Pricing</h5>

        <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
            <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white/70 hover:text-green-600 dark:hover:text-white"><Link :href="route('admin.dashboard')">Hously</Link></li>
            <li class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180"><i class="mdi mdi-chevron-right"></i></li>
            <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white" aria-current="page">Pricing</li>
        </ul>
    </div>

    <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6 mt-6">
        <!-- Content -->
        <div v-for="item in datas" :key="item" class="rounded-md bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 hover:shadow-md dark:hover:shadow-gray-700 duration-500 ease-in-out">
            <div class="border-b dark:border-gray-800 p-6 text-center">
                <div class="w-24 h-24 bg-green-600/5 text-green-600 flex items-center justify-center text-3xl rounded-full mx-auto">
                    <i :class="item.icon"></i>
                </div>

                <h3 class="text-2xl text-green-600 font-medium mt-4">{{item.name}}</h3>
            
                <div class="flex justify-center mt-4">
                    <span class="text-xl">{{item.symbol}}</span>
                    <span class="text-3xl font-semibold">{{item.price}}</span>
                    <span class="text-xl self-end">{{item.time}}</span>
                </div>
            </div>

            <div class="p-6">
                <h5>Pricing Features:</h5>

                <ul class="list-none">
                    <li v-for="pricing in item.pricing" :key="pricing" class="text-slate-400 mt-2"><span class="text-green-600 text-lg me-2"><i class="mdi mdi-check-circle-outline align-middle"></i></span>{{pricing}}</li>
                </ul>
                
                <a href="" class="btn bg-green-600 hover:bg-green-700 border-green-600 dark:border-green-600 text-white rounded-md w-full mt-4">Get Started</a>
            </div>
        </div>
        <!-- Content -->
    </div><!--end grid-->
    <!-- End Content -->
</template>

<script setup>
import { ref } from 'vue'

const datas = ref([
    {
        icon: 'mdi mdi-tree-outline',
        name: 'Basic',
        symbol: '$',
        price: '19',
        time: '/month',
        pricing: ['Full Access', 'Source Files', 'Free Appointments', 'Enhanced Security']
    },
    {
        icon: 'mdi mdi-shield-star-outline',
        name: 'Premium',
        symbol: '$',
        price: '39',
        time: '/month',
        pricing: ['Full Access', 'Source Files', 'Free Appointments', 'Enhanced Security']
    },
    {
        icon: 'mdi mdi-rocket-launch-outline',
        name: 'Business',
        symbol: '$',
        price: '99',
        time: '/month',
        pricing: ['Full Access', 'Source Files', 'Free Appointments', 'Enhanced Security']
    },
])

</script>

<style lang="scss" scoped>

</style>