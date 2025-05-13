<template>
    <!-- Start Content -->
    <div class="md:flex justify-between items-center">
        <h5 class="text-lg font-semibold">Reviews</h5>

        <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
            <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white/70 hover:text-green-600 dark:hover:text-white"><Link :href="route('admin.dashboard')">Hously</Link></li>
            <li class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180"><i class="mdi mdi-chevron-right"></i></li>
            <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white" aria-current="page">Review</li>
        </ul>
    </div>

    <div id="grid" class="xl:columns-4 lg:columns-3 md:columns-2  columns-1 gap-5 mx-3 mt-8">
        <div v-for="item in datas" :key="item" class="picture-item mb-4">
            <div class="bg-white dark:bg-slate-900 rounded-lg shadow dark:shadow-gray-800 p-6">
                <div class="flex items-center pb-6 border-b border-gray-100 dark:border-gray-800">
                    <img :src="item.image" class="h-16 w-16 rounded-full shadow dark:shadow-gray-800" alt="">

                    <div class="ps-4">
                        <a href="" class="text-lg hover:text-green-600 duration-500 ease-in-out">{{item.name}}</a>
                        <p class="text-slate-400">{{item.position}}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <p class="text-slate-400">{{ item.desc }}</p>
                    <ul class="list-none mb-0 text-amber-400 mt-2">
                        <li v-for="star in item.star" :key="star" class="inline me-1"><i :class="star"></i></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->
</template>

<script setup>
import {ref} from 'vue';

const datas = ref([
    {
        image: getImage('01.jpg'),
        name: 'Thomas Israel',
        position: 'Student',
        desc: "I didn't know a thing about icon design until I read this book. Now I can create any icon I need in no time. Great resource!",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('03.jpg'),
        name: 'Carl Oliver',
        position: 'Student',
        desc: "I used to have to remit tax to the EU and with Hously I somehow don't have to do that anymore. Nervous to travel there now though.",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('02.jpg'),
        name: 'Carl Oliver',
        position: 'Student',
        desc: "The best part about Hously is every time I pay my employees, my bank balance doesn't go down like it used to. Looking forward to spending this extra cash when I figure out why my card is being declined.",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('05.jpg'),
        name: 'Barbara McIntosh',
        position: 'Student',
        desc: "There are so many things I had to do with my old software that I just don't do at all with Hously. Suspicious but I can't say I don't love it.",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('05.jpg'),
        name: 'Barbara McIntosh',
        position: 'Student',
        desc: "There are so many things I had to do with my old software that I just don't do at all with Hously. Suspicious but I can't say I don't love it.",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('06.jpg'),
        name: 'Janisha Doll',
        position: 'Student',
        desc: "This is the fourth email I've sent to your support team. I am literally being held in jail for tax fraud. Please answer your damn emails, this is important.",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('03.jpg'),
        name: 'Barbara McIntosh',
        position: 'Student',
        desc: "I used to have to remit tax to the EU and with Hously I somehow don't have to do that anymore. Nervous to travel there now though.",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('02.jpg'),
        name: 'Carl Oliver',
        position: 'Student',
        desc: "The best part about Hously is every time I pay my employees, my bank balance doesn't go down like it used to. Looking forward to spending this extra cash when I figure out why my card is being declined.",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('02.jpg'),
        name: 'Carl Oliver',
        position: 'Student',
        desc: "The best part about Hously is every time I pay my employees, my bank balance doesn't go down like it used to. Looking forward to spending this extra cash when I figure out why my card is being declined.",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('05.jpg'),
        name: 'Barbara McIntosh',
        position: 'Student',
        desc: "There are so many things I had to do with my old software that I just don't do at all with Hously. Suspicious but I can't say I don't love it.",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('06.jpg'),
        name: 'Janisha Doll',
        position: 'Student',
        desc: "This is the fourth email I've sent to your support team. I am literally being held in jail for tax fraud. Please answer your damn emails, this is important.",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('04.jpg'),
        name: 'Jill Webb',
        position: 'Student',
        desc: "I'm trying to get a hold of someone in support, I'm in a lot of trouble right now and they are saying it has something to do with my books. Please get back to me right away.",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('01.jpg'),
        name: 'Thomas Israel',
        position: 'Student',
        desc: "I didn't know a thing about icon design until I read this book. Now I can create any icon I need in no time. Great resource!",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('04.jpg'),
        name: 'Jill Webb',
        position: 'Student',
        desc: "I'm trying to get a hold of someone in support, I'm in a lot of trouble right now and they are saying it has something to do with my books. Please get back to me right away.",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('01.jpg'),
        name: 'Thomas Israel',
        position: 'Student',
        desc: "I didn't know a thing about icon design until I read this book. Now I can create any icon I need in no time. Great resource!",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
    {
        image: getImage('04.jpg'),
        name: 'Jill Webb',
        position: 'Student',
        desc: "I'm trying to get a hold of someone in support, I'm in a lot of trouble right now and they are saying it has something to do with my books. Please get back to me right away.",
        star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
    },
])

function getImage(fileName){
    return new URL(`/resources/assets/backend/images/client/${fileName}`, import.meta.url).href;
}



</script>

<style lang="scss" scoped></style>