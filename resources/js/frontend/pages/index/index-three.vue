<template>
    <!-- Google Map -->
    <div class="container-fluid relative mt-20">
        <div class="grid grid-cols-1">
            <div class="w-full leading-[0] border-0">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39206.002432144705!2d-95.4973981212445!3d29.709510002925988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8640c16de81f3ca5%3A0xf43e0b60ae539ac9!2sGerald+D.+Hines+Waterwall+Park!5e0!3m2!1sen!2sin!4v1566305861440!5m2!1sen!2sin"
                    style="border:0" class="w-full h-[500px]" allowfullscreen></iframe>
            </div>
        </div><!--end grid-->
    </div><!--end container-->

    <div class="container relative -mt-[25px]">
        <div class="grid grid-cols-1">
            <div class="subcribe-form z-1">
                <form class="relative max-w-2xl mx-auto">
                    <i data-feather="search" class="size-5 absolute top-[47%] -translate-y-1/2 start-4"></i>
                    <input type="name" id="search_name" name="name"
                        class="rounded-md bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 ps-12"
                        placeholder="City, Address, Zip :">
                    <button type="submit"
                        class="btn bg-green-600 hover:bg-green-700 text-white rounded-md">Search</button>
                </form><!--end form-->
            </div>
        </div><!--end grid-->
    </div><!--end container-->
    <!-- Google Map -->

    <section class="relative lg:py-24 py-16">
        <div class="container relative">
            <Properties :moreview=true :propertie=true />
        </div>
        <TrustedUsers />
        <AgentTeam :agent=true :agentsgrid="'grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-4 gap-[30px]'"/>
        <div class="container relative lg:mt-24 mt-16">
            <Client />
        </div>
        <GetInTouch />
    </section>
</template>

<script setup>
import Properties from '@/frontend/components/featured-properties/properties.vue';
import TrustedUsers from '@/frontend/components/trusted-users.vue';
import AgentTeam from '@/frontend/components/agent-team.vue';
import Client from '@/frontend/components/clients/client-slider.vue';
import GetInTouch from '@/frontend/components/get-in-touch.vue';
</script>

<style lang="scss" scoped></style>