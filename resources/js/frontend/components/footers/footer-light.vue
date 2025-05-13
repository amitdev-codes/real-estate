<template>
   <!-- Start Footer -->
   <footer class="relative bg-slate-50 dark:bg-slate-800 border-t dark:border-gray-700 mt-24">
            <div class="container relative">
                <div class="grid grid-cols-1">
                    <div class="relative py-16">
                        <!-- Subscribe -->
                        <div class="relative w-full">
                            <div class="relative -top-40 bg-black dark:bg-slate-900 lg:px-8 px-6 py-10 rounded-xl shadow-lg dark:shadow-gray-700 overflow-hidden">
                                <div class="grid md:grid-cols-2 grid-cols-1 items-center gap-[30px]">
                                    <div class="md:text-start text-center z-1">
                                        <h3 class="md:text-3xl text-2xl md:leading-normal leading-normal font-medium text-white">Subscribe to Newsletter!</h3>
                                        <p class="text-slate-400 max-w-xl mx-auto">Subscribe to get latest updates and information.</p>
                                    </div>

                                    <div class="subcribe-form z-1">
                                        <form class="relative max-w-lg md:ms-auto">
                                            <input type="email" id="subcribe" name="email" class="rounded-full bg-white dark:bg-slate-900 shadow dark:shadow-gray-700" placeholder="Enter your email :">
                                            <button type="submit" class="btn bg-green-600 hover:bg-green-700 text-white rounded-full">Subscribe</button>
                                        </form><!--end form-->
                                    </div>
                                </div>

                                <div class="absolute -top-5 -start-5">
                                    <div class="uil uil-envelope lg:text-[150px] text-7xl text-white/5 ltr:-rotate-45 rtl:rotate-45"></div>
                                </div>

                                <div class="absolute -bottom-5 -end-5">
                                    <div class="uil uil-pen lg:text-[150px] text-7xl text-white/5 rtl:-rotate-90"></div>
                                </div>
                            </div>

                            <div class="grid md:grid-cols-12 grid-cols-1 gap-[30px] -mt-24">
                                <div class="lg:col-span-4 md:col-span-12">
                                    <a href="#" class="text-[22px] focus:outline-none">
                                        <img src="@frontend-assets/images/logo-dark.png" class="block dark:hidden" alt="">
                                        <img src="@frontend-assets/images/logo-light.png" class="hidden dark:block" alt="">
                                    </a>
                                    <p class="mt-6 text-slate-400">A great plateform to buy, sell and rent your properties without any agent or commisions.</p>

                                </div><!--end col-->

                                <div class="lg:col-span-2 md:col-span-4">
                                    <h5 class="tracking-[1px] text-black dark:text-white font-semibold">Company</h5>
                                    <ul class="list-none footer-list mt-6">
                                        <li v-for="item in company" :key="item" class="mt-[10px] first:mt-0">
                                            <Link :href="route(item.link)" class="text-slate-400 hover:text-slate-500 dark:text-slate-300 dark:hover:text-slate-400 duration-500 ease-in-out">
                                                <i class="uil uil-angle-right-b me-1"></i> {{item.name}}
                                            </Link>
                                        </li>
                                    </ul>
                                </div><!--end col-->

                                <div class="lg:col-span-3 md:col-span-4">
                                    <h5 class="tracking-[1px] text-black dark:text-white font-semibold">Usefull Links</h5>
                                    <ul class="list-none footer-list mt-6">
                                        <li v-for="item in usefulls" :key="item" class="mt-[10px] first:mt-0">
                                            <Link :href="route(item.link)" class="text-slate-400 hover:text-slate-500 dark:text-slate-300 dark:hover:text-slate-400 duration-500 ease-in-out">
                                                <i class="uil uil-angle-right-b me-1"></i> {{item.name}}
                                            </Link>
                                        </li>
                                    </ul>
                                </div><!--end col-->

                                <div class="lg:col-span-3 md:col-span-4">
                                    <h5 class="tracking-[1px] text-black dark:text-white font-semibold">Contact Details</h5>


                                    <div class="flex mt-6">
                                        <i data-feather="map-pin" class="size-5 text-green-600 me-3"></i>
                                        <div class="">
                                            <h6 class="text-slate-400 mb-2">C/54 Northwest Freeway, <br> Suite 558, <br> Houston, USA 485</h6>
                                            <a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39206.002432144705!2d-95.4973981212445!3d29.709510002925988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8640c16de81f3ca5%3A0xf43e0b60ae539ac9!2sGerald+D.+Hines+Waterwall+Park!5e0!3m2!1sen!2sin!4v1566305861440!5m2!1sen!2sin" data-type="iframe" class="text-green-600 hover:text-green-700 duration-500 ease-in-out lightbox">View on Google map</a>
                                        </div>
                                    </div>

                                    <div class="flex mt-6">
                                        <i data-feather="mail" class="size-5 text-green-600 me-3"></i>
                                        <div class="">
                                            <a href="mailto:contact@example.com" class="text-slate-400 hover:text-slate-500 dark:text-slate-300 dark:hover:text-slate-400 duration-500 ease-in-out">contact@example.com</a>
                                        </div>
                                    </div>

                                    <div class="flex mt-6">
                                        <i data-feather="phone" class="size-5 text-green-600 me-3"></i>
                                        <div class="">
                                            <a href="tel:+152534-468-854" class="text-slate-400 hover:text-slate-500 dark:text-slate-300 dark:hover:text-slate-400 duration-500 ease-in-out">+152 534-468-854</a>
                                        </div>
                                    </div>
                                </div><!--end col-->
                            </div><!--end grid-->
                        </div>
                        <!-- Subscribe -->
                    </div>
                </div>
            </div><!--end container-->

            <div class="py-[30px] px-0 border-t dark:border-gray-700">
                <div class="container relative text-center">
                    <div class="grid md:grid-cols-2 items-center gap-6">
                        <div class="md:text-start text-center">
                            <p class="mb-0 text-slate-400">© {{date}} Hously. Design & Develop with <i class="mdi mdi-heart text-red-600"></i> by <a href="https://shreethemes.in/" target="_blank" class="text-reset">Shreethemes</a>.</p>
                        </div>

                        <ul class="list-none md:text-end text-center">
                            <li v-for="item in social" :key="item" class="inline me-1"><a :href="item.link" target="_blank" class="btn btn-icon btn-sm text-gray-400 hover:text-white border dark:border-gray-700 rounded-md hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600"><i :data-feather="item.icon" class="size-4"></i></a></li>
                        </ul><!--end icon-->
                    </div><!--end grid-->
                </div><!--end container-->
            </div>
        </footer><!--end footer-->
        <!-- End Footer -->
</template>

<script setup>
import { ref } from 'vue';

const date = ref(new Date().getFullYear())

const social = ref([
    {
        icon: 'shopping-cart',
        link: 'https://1.envato.market/hously-vue'
    },
    {
        icon: 'dribbble',
        link: 'https://dribbble.com/shreethemes'
    },
    {
        icon: 'linkedin',
        link: 'http://linkedin.com/company/shreethemes'
    },
    {
        icon: 'facebook',
        link: 'https://www.facebook.com/shreethemes'
    },
    {
        icon: 'instagram',
        link: 'https://www.instagram.com/shreethemes/'
    },
    {
        icon: 'twitter',
        link: 'https://twitter.com/shreethemes'
    },
    {
        icon: 'mail',
        link: 'mailto:support@shreethemes.in'
    },
    {
        icon: 'file-text',
        link: 'https://forms.gle/QkTueCikDGqJnbky9'
    }
])

const company = ref([
    {
        link: 'frontend.about-us',
        name: 'About us'
    },
    {
        link: 'frontend.features',
        name: 'Services'
    },
    {
        link: 'frontend.pricing',
        name: 'Pricing'
    },
    {
        link: 'frontend.blogs',
        name: 'Blog'
    },
    {
        link: 'login',
        name: 'Login'
    },
])

const usefulls = ref([
    {
        link: 'frontend.terms',
        name: 'Terms of Services',
    },
    {
        link: 'frontend.privacy',
        name: 'Privacy Policy',
    },
    {
        link: 'frontend.list',
        name: 'Listing',
    },
    {
        link: 'frontend.contact',
        name: 'Contact',
    },
])
</script>

<style lang="scss" scoped>

</style>
