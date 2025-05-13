<template>
    <section class="md:h-screen py-36 flex items-center justify-center relative overflow-hidden zoom-image">
        <div
            class="absolute inset-0 image-wrap z-1 bg-[url('@backend-assets/images/01.jpg')] bg-no-repeat bg-center bg-cover">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black z-2" id="particles-snow"></div>
        <div class="container-fluid relative z-3">
            <div class="grid grid-cols-1">
                <div class="flex flex-col min-h-screen justify-center md:px-10 py-10 px-4">
                    <div class="text-center">
                        <Link :href="route('admin.dashboard')"><img src="@backend-assets/images/logo-icon-64.png" class="mx-auto" alt=""></Link>
                    </div>
                    <div class="title-heading text-center my-auto">
                        <h1 class="text-white mt-3 mb-6 md:text-5xl text-3xl font-bold">We Are Coming Soon...</h1>
                        <p class="text-white/70 text-lg max-w-xl mx-auto">A great plateform to buy, sell and rent your
                            properties without any agent or commisions.</p>

                        <div id="countdown">
                            <ul class="count-down list-none inline-block text-white text-center mt-8 m-6">
                                <ul class="count-down list-none inline-block text-white text-center mt-8 m-6">
                                    <li id="days" class="count-number inline-block m-2">{{ days }}<p class="count-head">
                                            Days
                                        </p>
                                    </li>
                                    <li id="hours" class="count-number inline-block m-2">{{ hours }}<p
                                            class="count-head">
                                            Hours</p>
                                    </li>
                                    <li id="mins" class="count-number inline-block m-2">{{ minutes }}<p
                                            class="count-head">
                                            minutes</p>
                                    </li>
                                    <li id="secs" class="count-number inline-block m-2">{{ seconds }}<p
                                            class="count-head">
                                            seconds</p>
                                    </li>
                                    <li id="end" class="h1"></li>
                                </ul>
                            </ul>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="mb-0 text-slate-400">© {{ date1 }} Hously. Design with <i
                                class="mdi mdi-heart text-red-600"></i> by <a href="https://shreethemes.in/"
                                target="_blank" class="text-reset">Shreethemes</a>.</p>
                    </div>
                </div>
            </div><!--end grid-->
        </div><!--end container-->
    </section><!--end section -->
    <Switcher :back=true />

</template>

<script setup>
import { ref, computed, watch } from 'vue'
import EmptyLayout from '@/layouts/empty-layout.vue'
import Switcher from '@/backend/components/switcher.vue'

const date1 = ref(new Date().getFullYear())
const now = ref(new Date().getTime())
const targetTime = ref(new Date("Sep 26, 2025 00:00:00").getTime())
const difference = ref(0)

const days = computed(() => Math.floor(difference.value / (1000 * 60 * 60 * 24)))
const hours = computed(() => 23 - new Date(now.value).getHours())
const minutes = computed(() => 60 - new Date(now.value).getMinutes())
const seconds = computed(() => 60 - new Date(now.value).getSeconds())

watch(now, () => {
    difference.value = targetTime.value - now.value
})

function updateNow() {
    now.value = new Date().getTime()
}

updateNow()
setInterval(updateNow, 1000)


</script>

<script>
    export default {
        layout: EmptyLayout
    }
</script>

<style lang="scss" scoped></style>



