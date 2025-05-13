<template>
    <Card>
        <template #header>
            Search Engine Optimization
        </template>
    
        <div class="grid gap-5">
            <div>
                <InputLabel for="seo_title" value="SEO Title" />
                <input name="seo_title" id="seo_title" type="text" class="form-input mt-2" placeholder="SEO Title :">
            </div>
            <div>
                <InputLabel for="seo_description" value="SEO Description" />
                <textarea name="seo_description" id="seo_description" type="text" class="form-input mt-2 textarea" placeholder="SEO description :"></textarea>
            </div>
            <div>
                <InputLabel for="seo_title" value="SEO Images" />
                <div v-if="imageSrc === null ? 'd-none' : ''"
                    class="preview-box flex justify-center rounded-md shadow dark:shadow-gray-800 overflow-hidden bg-gray-50 dark:bg-slate-800 text-slate-400 p-2 text-center small w-auto max-h-60">
                    Supports JPG, PNG and MP4 videos. Max file size : 10MB.</div>
                <div v-else
                    class="preview-box flex justify-center rounded-md shadow dark:shadow-gray-800 overflow-hidden bg-gray-50 dark:bg-slate-800 text-slate-400 p-2 text-center small w-auto max-h-60">
                    <img class="preview-content" :src="imageSrc">
                </div>
            </div>
            <!-- radio button with Label Index and No Index-->
            <div class="mt-2 flex gap-6">
                <div class="form-radio">
                    <input type="radio" name="name" id="index" class="form-radio-input me-2">
                    <InputLabel for="index" value="Index" />
                </div>
                <div class="form-radio">
                    <input type="radio" name="name" id="noindex" class="form-radio-input me-2">
                    <InputLabel for="noindex" value="No Index" />
                </div>
            </div>
        </div>
    </Card>
</template>


<script setup>
import { ref } from 'vue';

import Card from '@backend-components/ui/card.vue';
import InputLabel from '@backend-components/ui/input-label.vue';


const imageSrc = ref(null)
const image = ref('')

function loadFile(event) {
    image.value = document.getElementById(event.target.name)
    imageSrc.value = URL.createObjectURL(event.target.files[0])
}
</script>


<style lang="scss" scoped>

</style>


