<template>

    <div v-if="transparency" class="container relative">
        <div class="grid md:grid-cols-12 grid-cols-1 items-center gap-[30px]">
            <div class="md:col-span-5">
                <div class="relative">
                    <div class="p-5 shadow dark:shadow-gray-700 rounded-t-full bg-white dark:bg-slate-900">
                        <img src="@frontend-assets/images/hero.jpg" class="shadow-md rounded-t-full rounded-md" alt="">
                    </div>
                    <div class="absolute bottom-2/4 translate-y-2/4 start-0 end-0 text-center">
                        <a @click="toggle" data-type="youtube" data-id="yba7hPeTSjk"
                            class="lightbox size-20 rounded-full shadow-md dark:shadow-gray-800 inline-flex items-center justify-center bg-white dark:bg-slate-900 text-green-600 cursor-pointer">
                            <i class="mdi mdi-play inline-flex items-center justify-center text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div><!--end col-->

            <div class="md:col-span-7">
                <div class="lg:ms-4">
                    <h4 class="mb-6 md:text-3xl text-2xl lg:leading-normal leading-normal font-semibold">Efficiency.
                        Transparency. <br> Control.</h4>
                    <p class="text-slate-400 max-w-xl">Hously developed a platform for the Real Estate marketplace that
                        allows buyers and sellers to easily execute a transaction on their own. The platform drives
                        efficiency, cost transparency and control into the hands of the consumers. Hously is Real Estate
                        Redefined.</p>

                    <div class="mt-4">
                        <a href="" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md mt-3">Learn More
                        </a>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end grid-->
    </div><!--end container-->


    <div v-else class="grid md:grid-cols-12 grid-cols-1 items-center gap-[30px]">
        <div class="md:col-span-5">
            <div class="relative">
                <img src="@frontend-assets/images/about.jpg" class="rounded-xl shadow-md" alt="">
                <div class="absolute bottom-2/4 translate-y-2/4 start-0 end-0 text-center">
                    <a @click="toggle" data-type="youtube" data-id="yba7hPeTSjk"
                        class="lightbox size-20 rounded-full shadow-md dark:shadow-gyay-700 inline-flex items-center justify-center bg-white dark:bg-slate-900 text-green-600 cursor-pointer">
                        <i class="mdi mdi-play inline-flex items-center justify-center text-2xl"></i>
                    </a>
                </div>
            </div>
        </div><!--end col-->

        <div class="md:col-span-7">
            <div class="lg:ms-4">
                <h4 class="mb-6 md:text-3xl text-2xl lg:leading-normal leading-normal font-semibold">Efficiency.
                    Transparency. <br> Control.</h4>
                <p class="text-slate-400 max-w-xl">Hously developed a platform for the Real Estate marketplace that
                    allows buyers and sellers to easily execute a transaction on their own. The platform drives
                    efficiency, cost transparency and control into the hands of the consumers. Hously is Real Estate
                    Redefined.</p>

                <div class="mt-4">
                    <a href="" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md mt-3">Learn More
                    </a>
                </div>
            </div>
        </div><!--end col-->
    </div><!--end grid-->




    <!-- iframe start  -->
    <div :class="isActive ? 'fixed' : 'hidden'" class="bg-black/[0.9] top-0 left-0 bottom-0 w-[100%] h-[100%] z-999">
        <div class="h-[100%] flex items-center justify-center">
            <iframe src="https://www.youtube.com/embed/S_CGed6E610?feature=oembed" width="700" height="500"
                frameborder="0"></iframe>
        </div><button class="text-slate-400 absolute top-[20px] right-[20px]">
            <svg stroke="currentColor" fill="none" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round"
                stroke-linejoin="round" class="size-5" height="1em" width="1em" xmlns="http://www.w3.org/2000/svg"
                @click="toggle">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    <!-- iframe end  -->
</template>

<script setup>
    import { ref } from 'vue';

    const isActive = ref(false)

    const props = defineProps({
        transparency:{
            type: Boolean,
            // required: true,
            default: false
        }
    })

    function toggle() {
        isActive.value = !isActive.value
    }
</script>

<style lang="scss" scoped></style>
