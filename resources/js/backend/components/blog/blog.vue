<template>
    <!-- Start Content -->
    <div class="md:flex justify-between items-center">
        <div>
            <h5 class="text-lg font-semibold">Blogs</h5>

            <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
                <li class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white/70 hover:text-green-600 dark:hover:text-white"><Link :href="route('admin.dashboard')">Hously</Link></li>
                <li class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180"><i class="mdi mdi-chevron-right"></i></li>
                <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white" aria-current="page">Blogs</li>
            </ul>
        </div>

        <div>
            <a @click="toggle" href="javascript:void(0)" class="h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-slate-800/5 hover:bg-slate-800/10 dark:bg-slate-700 border border-slate-100/5 dark:border-gray-700 text-slate-900 dark:text-white rounded-full" data-modal-toggle="addblog" title="Add New"><i data-feather="plus" class="h-4 w-4"></i></a>
        </div>
    </div>

    <div class="grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6 mt-6">
        <div v-for="item in datas" :key="item" class="group relative h-fit hover:-mt-[5px] overflow-hidden bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700 transition-all duration-500">
            <div class="relative overflow-hidden">
                <img :src="item.image" class="" alt="">
                <div class="absolute end-4 top-4">
                    <span class="bg-green-600 text-white text-[14px] px-2.5 py-1 font-medium rounded-full h-5">{{item.category}}</span>
                </div>
            </div>

            <div class="relative p-6">
                <div class="">
                    <div class="flex justify-between mb-4">
                        <span class="text-slate-400 text-sm"><i class="mdi mdi-calendar-month align-middle text-base text-slate-900 dark:text-white me-2"></i>{{item.date}}</span>
                        <span class="text-slate-400 text-sm ms-3"><i class="mdi mdi-clock-outline align-middle text-base text-slate-900 dark:text-white me-2"></i>{{item.time}}</span>
                    </div>

                    <Link :href="route('admin.blog-details', item.id)" class="title text-xl font-medium hover:text-green-600 duration-500 ease-in-out">{{ item.title }}</Link>
                    
                    <div class="mt-3">
                        <Link :href="route('admin.blog-details', item.id)" class="btn btn-link hover:text-green-600 after:bg-green-600 duration-500 ease-in-out">Read More <i class="mdi mdi-chevron-right"></i></Link>
                    </div>
                </div>
            </div>
        </div>
        <!--end content-->
        
        
    </div><!--end grid-->

    <Pagination />
    <!-- End Content -->

    <!-- Modal -->
    <div :class="isActive ? 'fixed' : 'hidden'"  id="addblog" tabindex="10" class="z-50  flex items-center justify-center overflow-hidden m-auto bg-gray-900 bg-opacity-50 dark:bg-opacity-80 inset-0">
        <div class="relative w-full h-auto max-w-lg p-4">
            <div class="relative bg-white dark:bg-slate-900 rounded-lg shadow dark:shadow-gray-700">
                <div class="flex justify-between items-center p-4 border-b border-gray-100 dark:border-gray-700">
                    <h5 class="text-xl font-semibold">Add blog or news</h5>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ms-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="addblog">
                        <svg @click="toggle" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>  
                    </button>
                </div>
                <div class="p-4">
                    <div>
                        <p class="font-semibold mb-4">Upload your blog image here, Please click "Upload Image" Button.</p>
                        <div v-if="imageSrc === null ? 'd-none' : ''" class="preview-box flex justify-center rounded-md shadow dark:shadow-gray-800 overflow-hidden bg-gray-50 dark:bg-slate-800 text-slate-400 p-2 text-center small w-auto max-h-60">Supports JPG, PNG and MP4 videos. Max file size : 10MB.</div>
                        <div v-else class="preview-box flex justify-center rounded-md shadow dark:shadow-gray-800 overflow-hidden bg-gray-50 dark:bg-slate-800 text-slate-400 p-2 text-center small w-auto max-h-60"> <img class="preview-content" :src="imageSrc"></div>
                        <input type="file" id="input-file" name="input-file" accept="image/*" @change="loadFile" hidden>
                        <label class="btn-upload py-2 px-5 inline-block font-semibold tracking-wide border align-middle duration-500 text-base text-center bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md mt-6 cursor-pointer" for="input-file">Upload Image</label>
                    </div>
                    
                    <form class="mt-4">
                        <div class="grid grid-cols-12 gap-3">
                            <div class="col-span-12">
                                <label class="font-semibold">Blog Title <span class="text-red-600">*</span></label>
                                <input name="name" id="name" type="text" class="form-input w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0 mt-2" placeholder="Title :">
                            </div><!--end col-->

                            <div class="col-span-12">
                                <label class="font-semibold"> Description : </label>
                                <textarea name="comments" id="comments" class="form-input w-full py-2 px-3 h-24 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0 mt-2" placeholder="Description :"></textarea>
                            </div><!--end col-->

                            <div class="col-span-12">
                                <button type="submit" class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md">Create Blog</button>
                            </div><!--end col-->
                        </div>
                    </form>
                </div>                    
            </div>
        </div>
    </div>
    <!-- Modal -->

</template>

<script setup>
import {ref} from 'vue';
import Pagination from '@/backend/components/pagination.vue'

const imageSrc = ref(null)
const image = ref('')

function loadFile(event) {
    image.value = document.getElementById(event.target.name)
    imageSrc.value = URL.createObjectURL(event.target.files[0])
}

const isActive = ref(false)

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

function toggle(){
    isActive.value = !isActive.value
}

</script>

<style lang="scss" scoped>

</style>