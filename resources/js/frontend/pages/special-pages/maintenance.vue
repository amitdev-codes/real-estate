<template>
   <!-- Loader End -->
   <section class="md:h-screen py-36 flex items-center justify-center relative overflow-hidden">
            <div class="absolute inset-0 image-wrap z-1 bg-[url('@frontend-assets/images/bg/01.jpg')] bg-no-repeat bg-center bg-cover"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black z-2" id="particles-snow"></div>
            <div class="container relative z-3 text-center">
                <div class="grid grid-cols-1">
                    <img src="@frontend-assets/images/logo-icon-64.png" class="mx-auto" alt="">
                    <h1 class="text-white mb-6 mt-8 md:text-5xl text-3xl font-bold">We Are Back Soon...</h1>
                    <p class="text-white/70 text-lg max-w-xl mx-auto">A great plateform to buy, sell and rent your properties without any agent or commisions.</p>
                </div><!--end grid-->

                <div class="grid grid-cols-1 mt-10">
                    <div class="text-center">
                        <span id="maintenance" class="timer text-white text-[56px] tracking-[1px]"></span>
                        <span class="block text-base font-semibold uppercase text-white">Minutes</span>
                    </div>
                </div><!--end grid-->

                <div class="grid grid-cols-1 mt-8">
                    <div class="text-center subcribe-form">
                        <form class="relative mx-auto max-w-xl">
                            <input type="email" id="subemail" name="name" class="pt-4 pe-40 pb-4 ps-6 w-full h-[50px] outline-none text-black dark:text-white rounded-full bg-white/70 dark:bg-slate-900/70 border dark:border-gray-700" placeholder="Enter your email id..">
                            <button type="submit" class="btn absolute top-[2px] end-[3px] h-[46px] bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-full">Subcribe Now</button>
                        </form><!--end form-->
                    </div>
                </div><!--end grid-->
            </div><!--end container-->
        </section><!--end section -->
        <!-- <Switcher :back=true /> -->
</template>
<script setup>
import { ref, onMounted } from 'vue'
import EmptyLayout from '@/layouts/empty-layout.vue'
// import Switcher from '@/frontend/components/switcher.vue'

let timer = ref(60 * 60) // 1 hour in seconds
let minutes = ref('')
let seconds = ref('')

onMounted(() => {
  const display = document.querySelector('#maintenance')
  setInterval(() => {
    minutes.value = String(Math.floor(timer.value / 60)).padStart(2, '0')
    seconds.value = String(timer.value % 60).padStart(2, '0')
    display.textContent = `${minutes.value}:${seconds.value}`
    timer.value--
    if (timer.value < 0) {
      timer.value = 60 * 60
    }
  }, 1000)
})
</script>

<script>
    export default {
        layout: EmptyLayout
    }
</script>

<style lang="scss" scoped>

</style>
