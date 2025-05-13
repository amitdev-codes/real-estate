<template>
    <!-- Hero Start -->
    <section
        class="relative overflow-hidden md:h-screen pt-36 md:pb-48 pb-64 bg-green-600/10 dark:bg-green-600/20 bg-[url('@frontend-assets/images/bg/bg2.png')] bg-no-repeat bg-bottom bg-cover">
        <div class="container relative">
            <div class="grid grid-cols-1 items-center mt-10">
                <div class="text-center">
                    <h1 class="font-bold lg:leading-normal leading-normal text-4xl lg:text-5xl mb-6">Explore Listings
                        and <br> Make Move Today</h1>
                    <p class="text-slate-400 text-xl max-w-xl mx-auto">A great plateform to buy, sell and rent your
                        properties without any agent or commisions.</p>

                    <div class="subcribe-form z-1 max-w-2xl mx-auto mt-8">
                        <form class="relative">
                            <i data-feather="search" class="size-5 absolute top-[47%] -translate-y-1/2 start-4"></i>
                            <input type="name" id="search_name" name="name"
                                class="rounded-full bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 ps-12"
                                placeholder="City, Address, Zip :">
                            <button type="submit"
                                class="btn bg-green-600 hover:bg-green-700 text-white rounded-full">Find Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </div><!--end container-->
    </section><!--end section-->
    <!-- Hero End -->
    <section class="relative md:py-24 py-16">
        <ListingCategories :categories=true />
        <WhatWeDo />
        <div class="container relative lg:mt-24 mt-16">
        <Properties :featured=true  :featureds=true :featuredgrid="'grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-[30px]'" />
        </div>
    </section>
    <Cta />
    <section class="pt-10">
        <div class="container relative">
            <Logos />
        </div><!--end container-->
    </section><!--end section-->
    <section class="relative md:py-24 py-16">
        <div class="container relative">
            <Client />
        </div>
        <AgentTeam />
        <GetInTouch />
    </section>
    <Switcher :back="true" />
</template>

<script setup>
import Switcher from '@/frontend/components/switcher.vue';
import ListingCategories from '@/frontend/components/listing-categories.vue';
import WhatWeDo from '@/frontend/components/what-we-do.vue'
import Properties from '@/frontend/components/featured-properties/featured-properties.vue';
import Cta from '@/frontend/components/cta/cta.vue';
import Logos from '@/frontend/components/company-logo.vue';
import Client from '@/frontend/components/clients/client.vue';
import AgentTeam from '@/frontend/components/agent-team.vue';
import GetInTouch from '@/frontend/components/get-in-touch.vue';
</script>

<style lang="scss" scoped></style>