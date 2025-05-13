<template>
    <!-- Start Terms & Conditions -->
    <section class="relative lg:py-24 py-16">
        <div class="container relative">
            <div class="md:flex justify-center">
                <div class="md:w-3/4">
                    <div class="p-6 bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 rounded-md">
                        <h5 class="text-xl font-medium mb-4">Introduction :</h5>
                        <p class="text-slate-400">It seems that only fragments of the original text remain in the Lorem
                            Ipsum texts used today. One may speculate that over the course of time certain letters were
                            added or deleted at various positions within the text.</p>

                        <h5 class="text-xl font-medium mb-4 mt-8">User Agreements :</h5>
                        <p class="text-slate-400">The most well-known dummy text is the 'Lorem Ipsum', which is said to
                            have <b class="text-danger-600">originated</b> in the 16th century. Lorem Ipsum is <b
                                class="text-danger-600">composed</b> in a pseudo-Latin language which more or less <b
                                class="text-danger-600">corresponds</b> to 'proper' Latin. It contains a series of real
                            Latin words. This ancient dummy text is also <b
                                class="text-danger-600">incomprehensible</b>, but it imitates the rhythm of most
                            European languages in Latin script. The <b class="text-danger-600">advantage</b> of its
                            Latin origin and the relative <b class="text-danger-600">meaninglessness</b> of Lorum Ipsum
                            is that the text does not attract attention to itself or distract the viewer's <b
                                class="text-danger-600">attention</b> from the layout.</p>
                        <p class="text-slate-400 mt-3">There is now an <b class="text-danger-600">abundance</b> of
                            readable dummy texts. These are usually used when a text is <b
                                class="text-danger-600">required purely</b> to fill a space. These alternatives to the
                            classic Lorem Ipsum texts are often amusing and tell short, funny or <b
                                class="text-danger-600">nonsensical</b> stories.</p>
                        <p class="text-slate-400 mt-3">It seems that only <b class="text-danger-600">fragments</b> of
                            the original text remain in the Lorem Ipsum texts used today. One may speculate that over
                            the course of time certain letters were added or deleted at various positions within the
                            text.</p>

                        <h5 class="text-xl font-medium mb-4 mt-8">Restrictions :</h5>
                        <p class="text-slate-400">You are specifically restricted from all of the following :</p>
                        <ul class="list-none text-slate-400 mt-3">
                            <li v-for="item in restrictions" :key="item" class="flex mt-2"><i
                                    class="uil uil-arrow-right text-green-600 align-middle me-2"></i>{{ item }}</li>
                        </ul>

                        <h5 class="text-xl font-medium mt-8">Users Question & Answer :</h5>

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
                                <div id="accordion-collapse-body-1" class=""
                                    :class="item.id === isActive ? '' : 'hidden'">
                                    <div class="p-5">
                                        <p class="text-slate-400 dark:text-gray-400">{{ item.desc }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <a href="" class="btn bg-green-600 hover:bg-green-700 text-white rounded-md">Accept</a>
                            <a href=""
                                class="btn bg-transparent hover:bg-green-600 border border-green-600 text-green-600 hover:text-white rounded-md ms-2">Decline</a>
                        </div>
                    </div>
                </div><!--end -->
            </div><!--end grid-->
        </div><!--end container-->
    </section><!--end section-->
    <!-- End Terms & Conditions -->
</template>

<script setup>
import { ref } from 'vue';

const isActive = ref(1)

const restrictions = ref(['Digital Marketing Solutions for Tomorrow', 'Our Talented & Experienced Marketing Agency', 'Create your own skin to match your brand', 'Digital Marketing Solutions for Tomorrow', 'Our Talented & Experienced Marketing Agency', 'Create your own skin to match your brand'])


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
</script>

<style lang="scss" scoped></style>