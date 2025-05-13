<template>
     <!-- Start Hero -->
     <section class="relative table w-full py-32 lg:py-36 bg-[url('@frontend-assets/images/bg/01.jpg')] bg-no-repeat bg-center bg-cover">
            <div class="absolute inset-0 bg-black opacity-80"></div>
            <div class="container relative">
                <div class="grid grid-cols-1 text-center mt-10">
                    <h3 class="md:text-3xl text-2xl md:leading-snug tracking-wide leading-snug font-medium text-white mb-3">{{data?.title ? data?.title : 'Skills That You Can Learn In The Real Estate Market'}}</h3>

                    <ul class="list-none mt-6">
                        <li class="inline-block text-white/50 mx-5"> <span class="text-white block">Author :</span> <span class="block">Calvin Carlo</span></li>
                        <li class="inline-block text-white/50 mx-5"> <span class="text-white block">Date :</span> <span class="block">{{data?.date ? data?.date : '3rd March, 2023'}}</span></li>
                        <li class="inline-block text-white/50 mx-5"> <span class="text-white block">Time :</span> <span class="block">{{data?.time ? data?.time : '8 Min Read'}}</span></li>
                    </ul>
                </div><!--end grid-->
            </div><!--end container-->
        </section><!--end section-->
        <div class="relative">
            <div class="shape overflow-hidden z-1 text-white dark:text-slate-900">
                <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
                </svg>
            </div>
        </div>
        <!-- End Hero -->

            <!-- Start -->
            <section class="relative md:py-24 py-16">
            <div class="container relative">
                <div class="grid lg:grid-cols-12 md:grid-cols-2 grid-cols-1 gap-[30px]">
                    <div class="lg:col-span-8 md:order-1 order-2">
                        <div class="relative overflow-hidden rounded-xl shadow dark:shadow-gray-800">

                            <img :src="data?.image ? data?.image : image" alt="">

                            <div class="p-6">
                                <p class="text-slate-400">The most well-known dummy text is the 'Lorem Ipsum', which is said to have originated in the 16th century. Lorem Ipsum is composed in a pseudo-Latin language which more or less corresponds to 'proper' Latin. It contains a series of real Latin words. This ancient dummy text is also incomprehensible, but it imitates the rhythm of most European languages in Latin script.</p>
                                <p class="text-slate-400 italic border-x-4 border-green-600 rounded-ss-xl rounded-ee-xl mt-3 p-3">" There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable. "</p>
                                <p class="text-slate-400 mt-3">The advantage of its Latin origin and the relative meaninglessness of Lorum Ipsum is that the text does not attract attention to itself or distract the viewer's attention from the layout.</p>
                            </div>
                        </div>

                        <div class="p-6 rounded-md shadow dark:shadow-gray-800 mt-8">
                            <h5 class="text-lg font-semibold">Leave A Comment:</h5>

                            <form class="mt-8">
                                <div class="grid lg:grid-cols-12 lg:gap-6">
                                    <div class="lg:col-span-6 mb-5">
                                        <div class="text-start">
                                            <label for="name" class="font-semibold">Your Name:</label>
                                            <div class="form-icon relative mt-2">
                                                <i data-feather="user" class="size-5 absolute top-3 start-4"></i>
                                                <input name="name" id="name" type="text" class="form-input ps-11" placeholder="Name :">
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="lg:col-span-6 mb-5">
                                        <div class="text-start">
                                            <label for="email" class="font-semibold">Your Email:</label>
                                            <div class="form-icon relative mt-2">
                                                <i data-feather="mail" class="size-5 absolute top-3 start-4"></i>
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
                                                <i data-feather="message-circle" class="size-5 absolute top-3 start-4"></i>
                                                <textarea name="comments" id="comments" class="form-input ps-11 h-28" placeholder="Message :"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" id="submit" name="send" class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md w-full">Send Message</button>
                            </form>
                        </div>
                    </div><!--end col-->

                    <sidebar />
                </div><!--end grid-->
            </div><!--end container-->
        </section><!--end section-->
        <!-- End -->
</template>

<script setup>
import {ref, onMounted} from 'vue'
import sidebar from '@/frontend/components/blog/sidebar.vue'
// import { useRoute } from 'vue-router';
import image from '@frontend-assets/images/property/9.jpg'

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
    {
        id: 9,
        image: getImage('9.jpg'),
        category: 'Industrial',
        date: '3rd March, 2023',
        time: '5 min read',
        title: 'Using Banner Stands To Increase Trade Show Traffic'
    },
])

function getImage(fileName) {
    return new URL(`/resources/assets/frontend/images/property/${fileName}`, import.meta.url).href;
}

// onMounted(() => {
//     id.value = route.params.id
//     data.value = datas.value.find((item) => item.id === parseInt(id.value))
// })
</script>

<style lang="scss" scoped>

</style>