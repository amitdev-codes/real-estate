<template>
    <!-- Start Content -->
    <div class="md:flex justify-between items-center">
        <div>
            <h5 class="text-lg font-semibold">Frequently Asked Questions</h5>

            <ul class="tracking-[0.5px] inline-block mt-2">
                <li
                    class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white/70 hover:text-green-600 dark:hover:text-white">
                    <Link :href="route('admin.dashboard')">Hously</Link></li>
                <li
                    class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                    <i class="mdi mdi-chevron-right"></i></li>
                <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white"
                    aria-current="page">FAQs</li>
            </ul>
        </div>

        <div>
            <a href="javascript:void(0)"
                class="h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-slate-800/5 hover:bg-slate-800/10 dark:bg-slate-700 border border-slate-100/5 dark:border-gray-700 text-slate-900 dark:text-white rounded-full"
                data-modal-toggle="addquestions" title="Add New"><i data-feather="plus" class="h-4 w-4"></i></a>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 grid-cols-1 mt-6 gap-6">
        <div class="rounded-md shadow dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900">
            <h5 class="font-semibold">Buying Product</h5>

            <div id="accordion-collapseone" data-accordion="collapse" class="mt-6">
                <div v-for="item in datas" :key="item"
                class="relative shadow dark:shadow-gray-800 rounded-md overflow-hidden mt-4">
                <h2 class="text-base font-semibold" id="accordion-collapse-heading-1">
                    <button type="button " @click="isActive = isActive === item.id ? null : item.id"
                        :class="item.id === isActive ? 'bg-gray-50 dark:bg-slate-800 text-green-600' : ''"
                        class=" flex justify-between items-center p-5 w-full font-medium text-start">
                        <span>{{ item.title }}</span>
                        <svg data-accordion-icon class="size-4  shrink-0"
                            :class="item.id === isActive ? 'rotate-180' : ''" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-1" class="" :class="item.id === isActive ? '' : 'hidden'">
                    <div class="p-5">
                        <p class="text-slate-400 dark:text-gray-400">{{ item.desc }}</p>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <div class="rounded-md shadow dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900">
            <h5 class="font-semibold">General Questions</h5>

            <div id="accordion-collapsetwo" data-accordion="collapse" class="mt-6">
                <div v-for="item in datas2" :key="item"
                class="relative shadow dark:shadow-gray-800 rounded-md overflow-hidden mt-4">
                <h2 class="text-base font-semibold" id="accordion-collapse-heading-5">
                    <button type="button" @click="isActive2 = isActive2 === item.id ? null : item.id"
                        :class="item.id === isActive2 ? 'bg-gray-50 dark:bg-slate-800 text-green-600' : ''"
                        class="flex justify-between items-center p-5 w-full font-medium text-start">
                        <span>{{ item.title }}</span>
                        <svg data-accordion-icon class="size-4  shrink-0"
                            :class="item.id === isActive2 ? 'rotate-180' : ''" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-5" class="" :class="item.id === isActive2 ? '' : 'hidden'"
                    aria-labelledby="accordion-collapse-heading-5">
                    <div class="p-5">
                        <p class="text-slate-400 dark:text-gray-400">
                            {{ item.desc }}</p>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <div class="rounded-md shadow dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900">
            <h5 class="font-semibold">Payments Questions</h5>

            <div id="accordion-collapsethree" data-accordion="collapse" class="mt-6">
                <div v-for="item in datas3" :key="item"
                class="relative shadow dark:shadow-gray-800 rounded-md overflow-hidden mt-4">
                <h2 class="text-base font-semibold" id="accordion-collapse-heading-9">
                    <button type="button" @click="activeIndex3 = activeIndex3 === item.id ? null : item.id"
                        :class="item.id === activeIndex3 ? 'bg-gray-50 dark:bg-slate-800 text-green-600' : ''"
                        class="flex justify-between items-center p-5 w-full font-medium text-start">
                        <span>{{ item.title }}</span>
                        <svg data-accordion-icon class="size-4 shrink-0"
                            :class="item.id === activeIndex3 ? 'rotate-180' : ''" fill="currentColor"
                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </h2>
                <div id="accordion-collapse-body-9" class="" :class="item.id === activeIndex3 ? '' : 'hidden'">
                    <div class="p-5">
                        <p class="text-slate-400 dark:text-gray-400">{{ item.desc }}</p>
                    </div>
                </div>
            </div>
            </div>
        </div>

        <div class="rounded-md shadow dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900">
            <h5 class="font-semibold">Support Questions</h5>

            <div id="accordion-collapsefour" data-accordion="collapse" class="mt-6">
                <div v-for="item in datas4" :key="item"
                    class="relative shadow dark:shadow-gray-800 rounded-md overflow-hidden mt-4">
                    <h2 class="text-base font-semibold" id="accordion-collapse-heading-13">
                        <button type="button" @click="activeIndex4 = activeIndex4 === item.id ? null : item.id"
                            :class="item.id === activeIndex4 ? 'bg-gray-50 dark:bg-slate-800 text-green-600' : ''"
                            class="flex justify-between items-center p-5 w-full font-medium text-start">
                            <span>{{ item.title }}</span>
                            <svg data-accordion-icon class="size-4  shrink-0"
                                :class="item.id === activeIndex4 ? 'rotate-180' : ''" fill="currentColor"
                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-13" class=""
                        :class="item.id === activeIndex4 ? '' : 'hidden'">
                        <div class="p-5">
                            <p class="text-slate-400 dark:text-gray-400">{{ item.desc }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->
</template>

<script setup>
import { ref} from 'vue';

const isActive = ref(1)
const isActive2 = ref(1)
const activeIndex3 = ref(1)
const activeIndex4 = ref(1)

const datas = ref([
    {
        id: 1,
        title: 'How does it work ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
    {
        id: 2,
        title: 'Do I need a designer to use Hously ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
    {
        id: 3,
        title: 'What do I need to do to start selling ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
    {
        id: 4,
        title: 'What happens when I receive an order ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
])

const datas2 = ref([
    {
        id: 1,
        title: 'How does it work ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
    {
        id: 2,
        title: 'Do I need a designer to use Hously ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
    {
        id: 3,
        title: 'What do I need to do to start selling ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
    {
        id: 4,
        title: 'What happens when I receive an order ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
])

const datas3 = ref([
    {
        id: 1,
        title: 'How does it work ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
    {
        id: 2,
        title: 'Do I need a designer to use Hously ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
    {
        id: 3,
        title: 'What do I need to do to start selling ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
    {
        id: 4,
        title: 'What happens when I receive an order ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
])

const datas4 = ref([
    {
        id: 1,
        title: 'How does it work ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
    {
        id: 2,
        title: 'Do I need a designer to use Hously ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
    {
        id: 3,
        title: 'What do I need to do to start selling ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
    {
        id: 4,
        title: 'What happens when I receive an order ?',
        desc: 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
    },
])


</script>

<style lang="scss" scoped></style>