<template>
    <div class="container relative lg:mt-24 mt-16">
                <div class="grid grid-cols-1 pb-8 text-center">
                    <h3 class="mb-4 md:text-3xl md:leading-normal text-2xl leading-normal font-semibold">Buyer Benefits</h3>

                    <p class="text-slate-400 max-w-xl mx-auto">A great plateform to buy, sell and rent your properties without any agent or commisions.</p>
                </div><!--end grid-->

                <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-[30px]">
                    <!-- Content -->
                    <div v-for="item in datas" :key="item" class="group relative lg:px-10 transition-all duration-500 ease-in-out rounded-xl bg-transparent overflow-hidden text-center">
                        <div class="relative overflow-hidden text-transparent -m-3">
                            <i data-feather="hexagon" class="size-32 fill-green-600/5 mx-auto"></i>
                            <div class="absolute top-2/4 -translate-y-2/4 start-0 end-0 mx-auto text-green-600 rounded-xl transition-all duration-500 ease-in-out text-4xl flex align-middle justify-center items-center">
                                <i :class="item.icon"></i>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h5 class="text-xl font-medium">{{item.name}}</h5>
                            <p class="text-slate-400 mt-3">{{item.title}}</p>
                        </div>
                    </div>
                    <!-- Content -->
                </div><!--end grid-->
            </div><!--end container-->
</template>

<script setup>
import {ref} from 'vue'

const datas = ref([
    {
        icon: 'uil uil-estate',
        name: 'Free Consultation',
        title: "If the distribution of letters and 'words' is random, the reader will not be distracted from making."
    },
    {
        icon: 'uil uil-bag',
        name: 'Buyer Rebate Programs',
        title: "If the distribution of letters and 'words' is random, the reader will not be distracted from making."
    },
    {
        icon: 'uil uil-key-skeleton',
        name: 'Save Money',
        title: "If the distribution of letters and 'words' is random, the reader will not be distracted from making."
    },
])
</script>

<style lang="scss" scoped>

</style>