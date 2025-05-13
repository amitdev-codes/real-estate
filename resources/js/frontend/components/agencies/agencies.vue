<template>
    <div class="container relative">
        <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-[30px]">
            <div v-for="item in datas" :key="item" class="group text-center">
                <div
                    class="relative inline-block mx-auto size-64 rounded-full overflow-hidden shadow dark:shadow-gray-700">
                    <img :src="item.image" class="" alt="">
                </div>

                <div class="content mt-3">
                    <!-- <Link href="{name: 'agency-profile', params : {id: item.id}}" -->
                    <Link :href="route('frontend.agency-profile')"
                        class="text-xl font-medium hover:text-green-600 transition-all duration-500 ease-in-out">{{ item.name }}</Link>
                    <p class="text-slate-400">{{item.agency}}</p>

                    <ul class="list-none mt-2">
                        <li v-for="social in item.social" :key="social" class="inline me-1"><a href=""
                                class="btn btn-icon btn-sm border border-gray-100 dark:border-gray-800 rounded-md text-slate-400 hover:border-green-600 hover:text-white hover:bg-green-600"><i
                                    :data-feather="social" class="size-4"></i></a></li>
                    </ul><!--end icon-->
                </div>
            </div><!--end contant-->
        </div><!--end grid-->
    </div><!--end container-->
</template>

<script setup>
import { ref } from 'vue';

const datas = ref([
    {
        id: 1,
        image: getImage('1.png'),
        name: 'Realty Zen',
        agency: 'Real Estate Agency',
        social: ['facebook', 'instagram', 'twitter', 'linkedin']
    },
    {
        id: 2,
        image: getImage('2.png'),
        name: 'Highrises Realty',
        agency: 'Real Estate Agency',
        social: ['facebook', 'instagram', 'twitter', 'linkedin']
    },
    {
        id: 3,
        image: getImage('3.png'),
        name: 'Avenue Realty',
        agency: 'Real Estate Agency',
        social: ['facebook', 'instagram', 'twitter', 'linkedin']
    },
    {
        id: 4,
        image: getImage('4.png'),
        name: 'Ambrose Properties',
        agency: 'Real Estate Agency',
        social: ['facebook', 'instagram', 'twitter', 'linkedin']
    },
    {
        id: 5,
        image: getImage('5.png'),
        name: 'Arrow Realtors',
        agency: 'Real Estate Agency',
        social: ['facebook', 'instagram', 'twitter', 'linkedin']
    },
    {
        id: 6,
        image: getImage('6.png'),
        name: 'Aspire Brokers',
        agency: 'Real Estate Agency',
        social: ['facebook', 'instagram', 'twitter', 'linkedin']
    },
    {
        id: 7,
        image: getImage('7.png'),
        name: 'Beachfront Properties',
        agency: 'Real Estate Agency',
        social: ['facebook', 'instagram', 'twitter', 'linkedin']
    },
    {
        id: 8,
        image: getImage('8.png'),
        name: 'Climb Real Estate',
        agency: 'Real Estate Agency',
        social: ['facebook', 'instagram', 'twitter', 'linkedin']
    },
    {
        id: 9,
        image: getImage('9.png'),
        name: 'Dream Homes',
        agency: 'Real Estate Agency',
        social: ['facebook', 'instagram', 'twitter', 'linkedin']
    },
])

function getImage(fileName) {
    return new URL(`/resources/assets/frontend/images/agency/${fileName}`, import.meta.url).href;
}

</script>

<style lang="scss" scoped></style>
