<template>
    <div class="container relative lg:mt-24 mt-16">
        <div class="grid grid-cols-1 pb-8 text-center">
            <h3 class="mb-4 md:text-3xl md:leading-normal text-2xl leading-normal font-semibold">Featured Properties
            </h3>

            <p class="text-slate-400 max-w-xl mx-auto">A great plateform to buy, sell and rent your properties without
                any agent or commisions.</p>
        </div><!--end grid-->

        <div class="grid grid-cols-1 mt-8 relative">
            <div class="tiny-home-slide-three">
                <div v-for="item in datas" :key="item" class="tiny-slide">
                    <div
                        class="group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-md dark:hover:shadow-md dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500 m-3">
                        <div class="relative">
                            <img :src="item.image" alt="">

                            <div class="absolute top-4 end-4">
                                <a href="javascript:void(0)"
                                    class="btn btn-icon bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 rounded-full text-slate-100 dark:text-slate-700 focus:text-red-600 dark:focus:text-red-600 hover:text-red-600 dark:hover:text-red-600"><i
                                        class="mdi mdi-heart text-[20px]"></i></a>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="pb-6">
                                <!-- <Link href="{name: 'property-detail', params: {id: item.id}}" -->
                                <Link :href="route('frontend.property-detail-one')"
                                    class="text-lg hover:text-green-600 font-medium ease-in-out duration-500">{{item.name }}</Link>
                            </div>

                            <ul class="py-6 border-y border-slate-100 dark:border-gray-800 flex items-center list-none">
                                <li class="flex items-center me-4">
                                    <i class="uil uil-compress-arrows text-2xl me-2 text-green-600"></i>
                                    <span>{{ item.sqf }}</span>
                                </li>

                                <li class="flex items-center me-4">
                                    <i class="uil uil-bed-double text-2xl me-2 text-green-600"></i>
                                    <span>{{ item.beds }}</span>
                                </li>

                                <li class="flex items-center">
                                    <i class="uil uil-bath text-2xl me-2 text-green-600"></i>
                                    <span>{{ item.baths }}</span>
                                </li>
                            </ul>

                            <ul class="pt-6 flex justify-between items-center list-none">
                                <li>
                                    <span class="text-slate-400">Price</span>
                                    <p class="text-lg font-medium">{{ item.price }}</p>
                                </li>

                                <li>
                                    <span class="text-slate-400">Rating</span>
                                    <ul class="text-lg font-medium text-amber-400 list-none">
                                        <li v-for="star in item.star" :key="star" class="inline me-1"><i
                                                :class="star"></i></li>
                                        <li class="inline text-black dark:text-white">{{item.rating}}</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div><!--end property content-->
                </div>
            </div>
        </div><!--en grid-->
    </div><!--end container-->
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { tns } from 'tiny-slider/src/tiny-slider';
const datas = ref([
    {
        id: 1,
        image: getImage('1.jpg'),
        name: '10765 Hillshire Ave, Baton Rouge, LA 70810, USA',
        sqf: '8000sqf',
        beds: '4 Beds',
        baths: '4 Baths',
        price: '$5000',
        rating: '5.0(30)',
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        id: 2,
        image: getImage('2.jpg'),
        name: '59345 STONEWALL DR, Plaquemine, LA 70764, USA',
        sqf: '8000sqf',
        beds: '4 Beds',
        baths: '4 Baths',
        price: '$5000',
        rating: '5.0(30)',
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        id: 3,
        image: getImage('3.jpg'),
        name: '3723 SANDBAR DR, Addis, LA 70710, USA',
        sqf: '8000sqf',
        beds: '4 Beds',
        baths: '4 Baths',
        price: '$5000',
        rating: '5.0(30)',
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        id: 4,
        image: getImage('4.jpg'),
        name: 'Lot 21 ROYAL OAK DR, Prairieville, LA 70769, USA',
        sqf: '8000sqf',
        beds: '4 Beds',
        baths: '4 Baths',
        price: '$5000',
        rating: '5.0(30)',
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        id: 5,
        image: getImage('5.jpg'),
        name: '710 BOYD DR, Unit #1102, Baton Rouge, LA 70808, USA',
        sqf: '8000sqf',
        beds: '4 Beds',
        baths: '4 Baths',
        price: '$5000',
        rating: '5.0(30)',
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        id: 6,
        image: getImage('6.jpg'),
        name: '5133 MCLAIN WAY, Baton Rouge, LA 70809, USA',
        sqf: '8000sqf',
        beds: '4 Beds',
        baths: '4 Baths',
        price: '$5000',
        rating: '5.0(30)',
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
])

onMounted(() => {
    tns({
        container: '.tiny-home-slide-three',
        controls: true,
        mouseDrag: true,
        loop: true,
        rewind: true,
        autoplay: true,
        autoplayButtonOutput: false,
        autoplayTimeout: 3000,
        navPosition: "bottom",
        controlsText: ['<i class="mdi mdi-chevron-left "></i>', '<i class="mdi mdi-chevron-right"></i>'],
        nav: false,
        speed: 400,
        gutter: 0,
        responsive: {
            992: {
                items: 3
            },

            767: {
                items: 2
            },

            320: {
                items: 1
            },
        },
    });
});

function getImage(fileName){
    return new URL(`/resources/assets/frontend/images/property/${fileName}`, import.meta.url).href;
}
</script>

<style lang="scss" scoped></style>
