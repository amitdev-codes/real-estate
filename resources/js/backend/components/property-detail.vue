<template>
    <!-- Start Content -->
    <div class="md:flex justify-between items-center">
        <h5 class="text-lg font-semibold">Starter Page</h5>

        <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
            <li
                class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white/70 hover:text-green-600 dark:hover:text-white">
                <Link :href="route('admin.dashboard')">Hously</Link></li>
            <li
                class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                <i class="mdi mdi-chevron-right"></i></li>
            <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white"
                aria-current="page">Starter Page</li>
        </ul>
    </div>

    <div class="md:flex mt-4">
        <div class="lg:w-1/2 md:w-1/2 p-1">
            <div class="group relative overflow-hidden">
                <img  src="@backend-assets/images/property/single/1.jpg" alt="">
                <div class="absolute inset-0 group-hover:bg-slate-900/70 duration-500 ease-in-out"></div>
                <div
                    class="absolute top-1/2 -translate-y-1/2 start-0 end-0 text-center invisible group-hover:visible">
                    <a @click="showMultiple(0)"
                        class="btn btn-icon bg-green-600 hover:bg-green-700 text-white rounded-full lightbox cursor-pointer"><i
                            class="uil uil-camera"></i></a>
                </div>
            </div>
        </div>

        <div class="lg:w-1/2 md:w-1/2">
            <div class="flex">
                <div class="w-1/2 p-1">
                    <div class="group relative overflow-hidden">
                        <img src="@backend-assets/images/property/single/2.jpg" alt="">
                        <div class="absolute inset-0 group-hover:bg-slate-900/70 duration-500 ease-in-out">
                        </div>
                        <div
                            class="absolute top-1/2 -translate-y-1/2 start-0 end-0 text-center invisible group-hover:visible">
                            <a @click="showMultiple(1)"
                                class="btn btn-icon bg-green-600 hover:bg-green-700 text-white rounded-full lightbox cursor-pointer"><i
                                    class="uil uil-camera"></i></a>
                        </div>
                    </div>
                </div>

                <div class="w-1/2 p-1">
                    <div class="group relative overflow-hidden">
                        <img src="@backend-assets/images/property/single/3.jpg" alt="">
                        <div class="absolute inset-0 group-hover:bg-slate-900/70 duration-500 ease-in-out">
                        </div>
                        <div
                            class="absolute top-1/2 -translate-y-1/2 start-0 end-0 text-center invisible group-hover:visible">
                            <a @click="showMultiple(2)"
                                class="btn btn-icon bg-green-600 hover:bg-green-700 text-white rounded-full lightbox cursor-pointer"><i
                                    class="uil uil-camera"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex">
                <div class="w-1/2 p-1">
                    <div class="group relative overflow-hidden">
                        <img src="@backend-assets/images/property/single/4.jpg" alt="">
                        <div class="absolute inset-0 group-hover:bg-slate-900/70 duration-500 ease-in-out">
                        </div>
                        <div
                            class="absolute top-1/2 -translate-y-1/2 start-0 end-0 text-center invisible group-hover:visible">
                            <a @click="showMultiple(3)"
                                class="btn btn-icon bg-green-600 hover:bg-green-700 text-white rounded-full lightbox cursor-pointer"><i
                                    class="uil uil-camera"></i></a>
                        </div>
                    </div>
                </div>

                <div class="w-1/2 p-1">
                    <div class="group relative overflow-hidden">
                        <img src="@backend-assets/images/property/single/5.jpg" alt="">
                        <div class="absolute inset-0 group-hover:bg-slate-900/70 duration-500 ease-in-out">
                        </div>
                        <div
                            class="absolute top-1/2 -translate-y-1/2 start-0 end-0 text-center invisible group-hover:visible">
                            <a @click="showMultiple(4)"
                                class="btn btn-icon bg-green-600 hover:bg-green-700 text-white rounded-full lightbox cursor-pointer"><i
                                    class="uil uil-camera"></i></a>
                        </div>
                    </div>
                </div>
                <div class="w-1/2 p-1">
                    <div class="group relative overflow-hidden">
                        <img src="@backend-assets/images/property/single/3.jpg" alt="">
                        <div class="absolute inset-0 group-hover:bg-slate-900/70 duration-500 ease-in-out">
                        </div>
                        <div
                            class="absolute top-1/2 -translate-y-1/2 start-0 end-0 text-center invisible group-hover:visible">
                            <a @click="showMultiple(4)"
                                class="btn btn-icon bg-green-600 hover:bg-green-700 text-white rounded-full lightbox cursor-pointer"><i
                                    class="uil uil-camera"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div><!--end flex-->

    <div class="grid lg:grid-cols-12 md:grid-cols-2 gap-6 mt-6">
        <div class="lg:col-span-8">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-md shadow dark:shadow-gray-700">
                <h4 class="text-2xl font-medium">{{data?.name ? data?.name : '10765 Hillshire Ave, Baton Rouge, LA 70810, USA'}}</h4>

                <ul class="py-6 flex items-center list-none">
                    <li class="flex items-center lg:me-6 me-4">
                        <i class="mdi mdi-arrow-expand-all lg:text-3xl text-2xl me-2 text-green-600"></i>
                        <span class="lg:text-xl">{{data?.sqf ? data?.sqf : '8000sqf'}}</span>
                    </li>

                    <li class="flex items-center lg:me-6 me-4">
                        <i class="mdi mdi-bed lg:text-3xl text-2xl me-2 text-green-600"></i>
                        <span class="lg:text-xl">{{data?.beds ? data?.beds : '4 Beds'}}</span>
                    </li>

                    <li class="flex items-center">
                        <i class="mdi mdi-shower lg:text-3xl text-2xl me-2 text-green-600"></i>
                        <span class="lg:text-xl">{{data?.baths ? data?.baths : '4 Baths'}}</span>

                    </li>
                </ul>

                <p class="text-slate-400">Sed ut perspiciatis unde omnis iste natus error sit voluptatem
                    accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore
                    veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem
                    quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui
                    ratione voluptatem sequi nesciunt.</p>
                <p class="text-slate-400 mt-4">But I must explain to you how all this mistaken idea of
                    denouncing pleasure and praising pain was born and I will give you a complete account of the
                    system, and expound the actual teachings of the great explorer of the truth, the
                    master-builder of human happiness.</p>
                <p class="text-slate-400 mt-4">Nor again is there anyone who loves or pursues or desires to
                    obtain pain of itself, because it is pain, but because occasionally circumstances occur in
                    which toil and pain can procure him some great pleasure.</p>

                <div class="w-full leading-[0] border-0 mt-6">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39206.002432144705!2d-95.4973981212445!3d29.709510002925988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8640c16de81f3ca5%3A0xf43e0b60ae539ac9!2sGerald+D.+Hines+Waterwall+Park!5e0!3m2!1sen!2sin!4v1566305861440!5m2!1sen!2sin"
                        style="border:0" class="w-full h-[500px]" allowfullscreen></iframe>
                </div>
            </div>
        </div>

        <div class="lg:col-span-4">
            <div class="rounded-md bg-white dark:bg-slate-900 shadow dark:shadow-gray-700">
                <div class="p-6">
                    <h5 class="text-2xl font-medium">Price:</h5>

                    <div class="flex justify-between items-center mt-4">
                        <span class="text-xl font-medium">{{data?.price ? data?.price : '$ 45,231'}}</span>

                        <span class="bg-green-600/10 text-green-600 text-sm px-2.5 py-0.75 rounded h-6">For
                            Sale</span>
                    </div>

                    <ul class="list-none mt-4">
                        <li class="flex justify-between items-center">
                            <span class="text-slate-400 text-sm">Days on Hously</span>
                            <span class="font-medium text-sm">124 Days</span>
                        </li>

                        <li class="flex justify-between items-center mt-2">
                            <span class="text-slate-400 text-sm">Price per sq ft</span>
                            <span class="font-medium text-sm">$ 186</span>
                        </li>

                        <li class="flex justify-between items-center mt-2">
                            <span class="text-slate-400 text-sm">Monthly Payment (estimate)</span>
                            <span class="font-medium text-sm">$ 1497/Monthly</span>
                        </li>
                    </ul>
                </div>

                <div class="flex">
                    <div class="p-1 w-1/2">
                        <a href="" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md w-full">Book
                            Now</a>
                    </div>
                    <div class="p-1 w-1/2">
                        <a href=""
                            class="btn bg-green-600 hover:bg-green-700 text-white rounded-md w-full">Offer
                            Now</a>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <h3 class="mb-6 text-xl leading-normal font-medium text-black dark:text-white">Have Question ?
                    Get in touch!</h3>

                <div class="mt-6">
                    <Link :href="''"
                        class="btn bg-transparent hover:bg-green-600 border border-green-600 text-green-600 hover:text-white rounded-md"><i
                            class="mdi mdi-phone align-middle me-2"></i> Contact us</Link>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->

    <vue-easy-lightbox :visible="visibleRef" :imgs="imgsRef" :index="indexRef" @hide="onHide"></vue-easy-lightbox>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import VueEasyLightbox from 'vue-easy-lightbox';
import singleImage from '@backend-assets/images/property/single/1.jpg';
import singleImage2 from '@backend-assets/images/property/single/2.jpg';
import singleImage3 from '@backend-assets/images/property/single/3.jpg';
import singleImage4 from '@backend-assets/images/property/single/4.jpg';
import singleImage5 from '@backend-assets/images/property/single/5.jpg';
// import { useRoute } from 'vue-router';
const id = ref('');
const data = ref('');
// const route = useRoute();

const visibleRef = ref(false)
const imgsRef = ref([])
const indexRef = ref(0)

const images = ref([
    singleImage,
    singleImage2,
    singleImage3,
    singleImage4,
    singleImage5,
    singleImage5,
    singleImage5,
])

import image1 from '@backend-assets/images/property/1.jpg';
import image2 from '@backend-assets/images/property/2.jpg';
import image3 from '@backend-assets/images/property/3.jpg';
import image4 from '@backend-assets/images/property/4.jpg';
import image5 from '@backend-assets/images/property/5.jpg';
import image6 from '@backend-assets/images/property/6.jpg';
import image7 from '@backend-assets/images/property/7.jpg';
import image8 from '@backend-assets/images/property/8.jpg';
import image9 from '@backend-assets/images/property/9.jpg';
import image10 from '@backend-assets/images/property/10.jpg';
import image11 from '@backend-assets/images/property/11.jpg';
import image12 from '@backend-assets/images/property/12.jpg';

const datas = ref([
    {
        id: 1,
        // image: require('@backend-assets/images/property/1.jpg'),
        image: image1,
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
        // image: require('@backend-assets/images/property/2.jpg'),
        image: image2,
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
        // image: require('@backend-assets/images/property/3.jpg'),
        image: image3,
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
        // image: require('@backend-assets/images/property/4.jpg'),
        image: image4,
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
        // image: require('@backend-assets/images/property/5.jpg'),
        image: image5,
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
        // image: require('@backend-assets/images/property/6.jpg'),
        image: image6,
        name: '5133 MCLAIN WAY, Baton Rouge, LA 70809, USA',
        sqf: '8000sqf',
        beds: '4 Beds',
        baths: '4 Baths',
        price: '$5000',
        rating: '5.0(30)',
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        id: 7,
        // image: require('@backend-assets/images/property/7.jpg'),
        image: image7,
        name: '2141 Fiero Street, Baton Rouge, LA 70808',
        sqf: '8000sqf',
        beds: '4 Beds',
        baths: '4 Baths',
        price: '$5000',
        rating: '5.0(30)',
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        id: 8,
        // image: require('@backend-assets/images/property/8.jpg'),
        image: image8,
        name: '9714 Inniswold Estates Ave, Baton Rouge, LA 70809',
        sqf: '8000sqf',
        beds: '4 Beds',
        baths: '4 Baths',
        price: '$5000',
        rating: '5.0(30)',
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        id: 9,
        // image: require('@backend-assets/images/property/9.jpg'),
        image: image9,
        name: '1433 Beckenham Dr, Baton Rouge, LA 70808, USA',
        sqf: '8000sqf',
        beds: '4 Beds',
        baths: '4 Baths',
        price: '$5000',
        rating: '5.0(30)',
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        id: 10,
        // image: require('@backend-assets/images/property/10.jpg'),
        image: image10,
        name: '1574 Sharlo Ave, Baton Rouge, LA 70820, USA',
        sqf: '8000sqf',
        beds: '4 Beds',
        baths: '4 Baths',
        price: '$5000',
        rating: '5.0(30)',
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        id: 11,
        // image: require('@backend-assets/images/property/11.jpg'),
        image: image11,
        name: '2528 BOCAGE LAKE DR, Baton Rouge, LA 70809, USA',
        sqf: '8000sqf',
        beds: '4 Beds',
        baths: '4 Baths',
        price: '$5000',
        rating: '5.0(30)',
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        id: 12,
        // image: require('@backend-assets/images/property/12.jpg'),
        image: image12,
        name: '1533 NICHOLSON DR, Baton Rouge, LA 70802, USA',
        sqf: '8000sqf',
        beds: '4 Beds',
        baths: '4 Baths',
        price: '$5000',
        rating: '5.0(30)',
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
])

// onMounted(() => {
//     id.value = route.params.id
//     data.value = datas.value.find((item) => item.id === parseInt(id.value))
// })

function showMultiple(index) {
    indexRef.value = index,
        imgsRef.value = images.value,
        visibleRef.value = true
}
function onHide() {
    visibleRef.value = false
}
</script>

<style lang="scss" scoped></style>
