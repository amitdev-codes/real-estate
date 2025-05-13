<template>
    <div class="container relative">
        <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-x-[30px] gap-y-[50px]">
            <!-- Content -->
            <div v-for="item in datas" :key="item"
                class="group relative lg:px-10 transition-all duration-500 ease-in-out rounded-xl bg-white dark:bg-slate-900 overflow-hidden">
                <div class="relative overflow-hidden text-transparent -m-3">
                    <i data-feather="hexagon" class="size-32 fill-green-600/5"></i>
                    <div
                        class="absolute top-[50%] -translate-y-[50%] start-[45px] text-green-600 rounded-xl transition-all duration-500 ease-in-out text-4xl flex align-middle justify-center items-center">
                        <i :class="item.icon"></i>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="" class="text-xl hover:text-green-600 font-medium">{{item.name}}</a>
                    <p class="text-slate-400 mt-3">{{ item.title }}</p>
                </div>
            </div>
            <!-- Content -->
        </div><!--end grid-->
    </div><!--end container-->
</template>

<script setup>
import { ref } from 'vue';

const datas = ref([
    {
        icon: 'mdi mdi-cards-heart',
        name: 'Comfortable',
        title: "If the distribution of letters and 'words' is random, the reader will not be distracted from making."
    },
    {
        icon: 'mdi mdi-shield-sun',
        name: 'Extra Security',
        title: "If the distribution of letters and 'words' is random, the reader will not be distracted from making."
    },
    {
        icon: 'mdi mdi-star',
        name: 'Luxury',
        title: "If the distribution of letters and 'words' is random, the reader will not be distracted from making."
    },
    {
        icon: 'mdi mdi-currency-usd',
        name: 'Best Price',
        title: "If the distribution of letters and 'words' is random, the reader will not be distracted from making."
    },
    {
        icon: 'mdi mdi-map-marker',
        name: 'Stratagic Location',
        title: "If the distribution of letters and 'words' is random, the reader will not be distracted from making."
    },
    {
        icon: 'mdi mdi-chart-arc',
        name: 'Efficient',
        title: "If the distribution of letters and 'words' is random, the reader will not be distracted from making."
    },
])
</script>

<style lang="scss" scoped></style>