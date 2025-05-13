<template>
    <!-- Start Content -->
    <div class="md:flex justify-between items-center">
        <h5 class="text-lg font-semibold">{{data?.title ? data?.title : 'Skills That You Can Learn In The Real Estate Market'}}</h5>

        <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
            <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white/70 hover:text-green-600 dark:hover:text-white"><Link :href="route('admin.dashboard')">Hously</Link></li>
            <li class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180"><i class="mdi mdi-chevron-right"></i></li>
            <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white" aria-current="page">Blog Detail</li>
        </ul>
    </div>

    <div class="grid lg:grid-cols-12 md:grid-cols-2 grid-cols-1 gap-6 mt-6">
        <div class="lg:col-span-8 md:order-1 order-2">
            <div class="relative overflow-hidden bg-white dark:bg-slate-900 rounded-md shadow dark:shadow-gray-700">

                <img :src="data?.image ? data?.image : image" alt="">

                <div class="p-6">
                    <p class="text-slate-400">The most well-known dummy text is the 'Lorem Ipsum', which is said to have originated in the 16th century. Lorem Ipsum is composed in a pseudo-Latin language which more or less corresponds to 'proper' Latin. It contains a series of real Latin words. This ancient dummy text is also incomprehensible, but it imitates the rhythm of most European languages in Latin script.</p>
                    <p class="text-slate-400 italic border-x-4 border-green-600 rounded-ss-xl rounded-ee-xl mt-3 p-3">" There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. "</p>
                    <p class="text-slate-400 mt-3">The advantage of its Latin origin and the relative meaninglessness of Lorum Ipsum is that the text does not attract attention to itself or distract the viewer's attention from the layout.</p>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-900 rounded-md p-6 shadow dark:shadow-gray-700 mt-6">
                <h5 class="text-lg font-semibold">Leave A Comment:</h5>

                <form class="mt-8">
                    <div class="grid lg:grid-cols-12 lg:gap-6">
                        <div class="lg:col-span-6 mb-5">
                            <div class="text-start">
                                <label for="name" class="font-semibold">Your Name:</label>
                                <div class="form-icon relative mt-2">
                                    <i data-feather="user" class="w-4 h-4 absolute top-3 start-4"></i>
                                    <input name="name" id="name" type="text" class="form-input ps-11" placeholder="Name :">
                                </div>
                            </div>
                        </div>

                        <div class="lg:col-span-6 mb-5">
                            <div class="text-start">
                                <label for="email" class="font-semibold">Your Email:</label>
                                <div class="form-icon relative mt-2">
                                    <i data-feather="mail" class="w-4 h-4 absolute top-3 start-4"></i>
                                    <input name="email" id="email" type="email" class="form-input ps-11" placeholder="Email :">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1">
                        <div class="mb-5">
                            <div class="text-start">
                                <label for="comments" class="font-semibold">Your Comment:</label>
                                <div class="form-icon relative mt-2">
                                    <i data-feather="message-circle" class="w-4 h-4 absolute top-3 start-4"></i>
                                    <textarea name="comments" id="comments" class="form-input ps-11 h-28" placeholder="Message :"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" id="submit" name="send" class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md w-full">Send Message</button>
                </form>
            </div>
        </div><!--end col-->

        <div class="lg:col-span-4 md:order-2 order-1">
            <div class="bg-white dark:bg-slate-900 rounded-md p-6 shadow dark:shadow-gray-700">
                <BlogSidebar />
            </div>
        </div><!--end col-->
    </div><!--end grid-->
    <!-- End Content -->
</template>

<script setup>
import BlogSidebar from '@/backend/components/blog/blog-sidebar.vue'
import {ref, onMounted} from 'vue'
// import { useRoute } from 'vue-router';
import image from '@backend-assets/images/property/9.jpg'

const id = ref('')
const data = ref('')
// const route = useRoute()

const datas = ref([
    {
        id: 1,
        image: getImage('1.jpg'),
        category: 'Residential',
        date: '3rd March, 2023',
        time: '5 min read',
        title: 'Skills That You Can Learn In The Real Estate Market'
    },
    {
        id: 2,
        image: getImage('2.jpg'),
        category: 'Land',
        date: '3rd March, 2023',
        time: '5 min read',
        title: 'Learn The Truth About Real Estate Industry'
    },
    {
        id: 3,
        image: getImage('3.jpg'),
        category: 'Commercial',
        date: '3rd March, 2023',
        time: '5 min read',
        title: '10 Quick Tips About Business Development'
    },
    {
        id: 4,
        image: getImage('4.jpg'),
        category: 'Industrial',
        date: '3rd March, 2023',
        time: '5 min read',
        title: '14 Common Misconceptions About Business Development'
    },
    {
        id: 5,
        image: getImage('5.jpg'),
        category: 'Investment',
        date: '3rd March, 2023',
        time: '5 min read',
        title: '10 Things Your Competitors Can Teach You About Real Estate'
    },
    {
        id: 6,
        image: getImage('6.jpg'),
        category: 'Residential',
        date: '3rd March, 2023',
        time: '5 min read',
        title: 'Why We Love Real Estate'
    },
    {
        id: 7,
        image: getImage('7.jpg'),
        category: 'Land',
        date: '3rd March, 2023',
        time: '5 min read',
        title: '110 Quick Tips About Real Estate'
    },
    {
        id: 8,
        image: getImage('8.jpg'),
        category: 'Commercial',
        date: '3rd March, 2023',
        time: '5 min read',
        title: '15 Best Blogs To Follow About Real Estate'
    },
])

function getImage(fileName){
    return new URL(`/resources/assets/backend/images/property/${fileName}`, import.meta.url).href;
}

// onMounted(() => {
//     id.value = route.params.id
//     data.value = datas.value.find((item) => item.id === parseInt(id.value))
// })
</script>

<style lang="scss" scoped>

</style>