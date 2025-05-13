<template>
    <section class="relative md:py-24 py-16">
        <div class="container relative">
            <div class="grid lg:grid-cols-12 md:grid-cols-2 grid-cols-1 gap-[30px]">
                <div class="lg:col-span-8 md:order-1 order-2">
                    <blogs :grids="'grid lg:grid-cols-2 grid-cols-1 gap-[30px]'" />

                  
                </div><!--end col-->

              <sidebar />
            </div><!--end grid-->
        </div><!--end container-->
    </section><!--end section-->
</template>

<script setup>
import sidebar from '@/frontend/components/blog/sidebar.vue';
import blogs from '@/frontend/components/blog/blogs.vue'
</script>

<style lang="scss" scoped></style>