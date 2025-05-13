<template>
    <div class="grid md:grid-cols-6 grid-cols-2 justify-center gap-[30px]">
        <div v-for="item in images" :key="item" class="mx-auto py-4">
            <img :src="item" class="h-6" alt="">
        </div>
    </div><!--end grid-->
</template>

<script setup>
import {ref} from 'vue'
import image from '@frontend-assets/images/client/amazon.svg';
import image2 from '@frontend-assets/images/client/google.svg';
import image3 from '@frontend-assets/images/client/lenovo.svg';
import image4 from '@frontend-assets/images/client/paypal.svg';
import image5 from '@frontend-assets/images/client/shopify.svg';
import image6 from '@frontend-assets/images/client/spotify.svg'

const images = ref([image, image2, image3, image4, image5, image6])
</script>

<style lang="scss" scoped></style>