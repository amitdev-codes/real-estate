<template>
    <Card>
        <!-- <p class="font-medium mb-4">Upload your property image here, Please click "Upload Image" Button.</p> -->
        <p class="font-medium mb-4">Upload your property image here.</p>
        <div v-if="imageSrc === null ? 'd-none' : ''"
            class="preview-box flex justify-center rounded-md shadow dark:shadow-gray-800 overflow-hidden bg-gray-50 dark:bg-slate-800 text-slate-400 p-2 text-center small w-auto max-h-60">
            Supports JPG, PNG and MP4 videos. Max file size : 10MB.</div>
        <div v-else
            class="preview-box flex justify-center rounded-md shadow dark:shadow-gray-800 overflow-hidden bg-gray-50 dark:bg-slate-800 text-slate-400 p-2 text-center small w-auto max-h-60">
            <img class="preview-content" :src="imageSrc">
        </div>
    </Card>
</template>


<script setup>
import { ref } from 'vue';

import Card from '@backend-components/ui/card.vue';


const imageSrc = ref(null)
const image = ref('')

function loadFile(event) {
    image.value = document.getElementById(event.target.name)
    imageSrc.value = URL.createObjectURL(event.target.files[0])
}
</script>


<style lang="scss" scoped>

</style>