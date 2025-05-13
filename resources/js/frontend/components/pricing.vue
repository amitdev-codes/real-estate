<template>
    <div class="container relative">
        <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-x-[30px] gap-y-[50px]">
            <!-- Content -->
            <div v-for="item in datas" :key="item "
                class="rounded-md shadow dark:shadow-gray-700 hover:shadow-md dark:hover:shadow-gray-700 duration-500 ease-in-out">
                <div class="border-b dark:border-gray-800 p-6 text-center">
                    <div
                        class="size-24 bg-green-600/5 text-green-600 flex items-center justify-center text-3xl rounded-full mx-auto">
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
                        <li v-for="pricing in item.pricing" :key="pricing" class="text-slate-400 mt-2"><span class="text-green-600 text-lg me-2"><i
                                    class="uil uil-check-circle align-middle"></i></span>{{pricing}}</li>
                    </ul>

                    <a href=""
                        class="btn bg-green-600 hover:bg-green-700 border-green-600 dark:border-green-600 text-white rounded-md w-full mt-4">Get
                        Started</a>
                </div>
            </div>
            <!-- Content -->
        </div><!--end grid-->
    </div><!--end container-->
</template>

<script setup>
import { ref } from 'vue'

const datas = ref([
    {
        icon: 'uil uil-trees',
        name: 'Basic',
        symbol: '$',
        price: '19',
        time: '/month',
        pricing: ['Full Access', 'Source Files', 'Free Appointments', 'Enhanced Security']
    },
    {
        icon: 'uil uil-shield',
        name: 'Premium',
        symbol: '$',
        price: '39',
        time: '/month',
        pricing: ['Full Access', 'Source Files', 'Free Appointments', 'Enhanced Security']
    },
    {
        icon: 'uil uil-rocket',
        name: 'Business',
        symbol: '$',
        price: '99',
        time: '/month',
        pricing: ['Full Access', 'Source Files', 'Free Appointments', 'Enhanced Security']
    },
])

</script>

<style lang="scss" scoped></style>