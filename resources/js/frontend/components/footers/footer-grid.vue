<template>
    <footer class="relative bg-neutral-900">
        <div class="py-[30px] px-0">
            <div class="container relative text-center px-6">
                <div class="grid md:grid-cols-2 items-center gap-6">
                    <div class="md:text-start text-center">
                        <p class="mb-0 text-gray-300">©
                            {{date}} Hously. Design & Develop with <i
                                class="mdi mdi-heart text-red-600"></i> by <a href="https://shreethemes.in/"
                                target="_blank" class="text-reset">Shreethemes</a>.
                        </p>
                    </div>

                    <ul class="list-none md:text-end text-center">
                        <li v-for="item in social" :key="item" class="inline me-1">
                            <a href=""
                                class="btn btn-icon btn-sm text-gray-400 hover:text-white border !border-gray-800 rounded-md hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600">
                                <i :data-feather="item" class="size-4"></i>
                            </a>
                        </li>
                    </ul><!--end icon-->
                </div><!--end grid-->
            </div><!--end container-->
        </div>
    </footer><!--end footer-->
</template>

<script setup>
import {ref} from 'vue';

const date = ref(new Date().getFullYear())

const social = ref(['facebook', 'instagram', 'twitter', 'linkedin'])
</script>

<style lang="scss" scoped></style>