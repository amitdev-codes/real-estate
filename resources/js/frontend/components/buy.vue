<template>
    <div class="container relative lg:mt-24 mt-16">
        <div class="grid md:grid-cols-12 grid-cols-1 gap-[30px]">
            <div class="lg:col-span-4 md:col-span-5">
                <div class="sticky top-20">
                    <ul class="flex-column text-center p-6 bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 rounded-md"
                        id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                        <li v-for="item in datas" :key="item" role="presentation" class="mt-4 first:mt-0">
                            <button @click="handleclick(item.id)"
                                :class="item.id === active ? 'text-white bg-green-600 ' : 'dark:hover:bg-slate-800 dark:hover:text-white hover:text-green-600 hover:bg-gray-50'"
                                class="px-4 py-2 text-base font-medium rounded-md w-full transition-all duration-500 ease-in-out"
                                id="letter-tab" data-tabs-target="#letter" type="button" role="tab"
                                aria-controls="letter" aria-selected="true">{{ item.name }}</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="lg:col-span-8 md:col-span-7">
                <div id="myTabContent">
                    <div :class="active === 1 ? '' : 'hidden'" id="letter" role="tabpanel" aria-labelledby="letter-tab">
                        <img src="@frontend-assets/images/svg/Agent_Monochromatic.svg" alt="">
                        <div class="mt-6">
                            <h5 class="font-medium text-xl">Pre Approval Letter</h5>
                            <p class="text-slate-400 mt-3">Most buyers think the first step is finding their dream
                                house, but the truth is finding the funding is the first step. Hously streamlines the
                                Loan Pre-Approval process with our ecosystem of Premier Partners or simply upload your
                                own Pre-Approval letter.</p>
                        </div>
                    </div>
                    <div :class="active === 2 ? '' : 'hidden'" id="schedule" role="tabpanel"
                        aria-labelledby="schedule-tab">
                        <img src="@frontend-assets/images/svg/presentation_Flatline.svg" alt="">
                        <div class="mt-6">
                            <h5 class="font-medium text-xl">Schedule a Showing</h5>
                            <p class="text-slate-400 mt-3">Hously allows a buyer to schedule an instant showing and gain
                                a private viewing without the need for multiple parties to be involved. You pick the
                                time that works for you!</p>
                        </div>
                    </div>
                    <div :class="active === 3 ? '' : 'hidden'" id="offer" role="tabpanel" aria-labelledby="offer-tab">
                        <img src="@frontend-assets/images/svg/session_Flatline.svg" alt="">
                        <div class="mt-6">
                            <h5 class="font-medium text-xl">Submit an Offer</h5>
                            <p class="text-slate-400 mt-3">Hously walks a buyer through the purchase agreement process
                                making the paperwork appear effortless. With our custom workflows and progress
                                analytics, you will always know where your purchase stands. No more phone tag and
                                unreturned emails!</p>
                        </div>
                    </div>
                    <div :class="active === 4 ? '' : 'hidden'" id="inspection" role="tabpanel"
                        aria-labelledby="inspection-tab">
                        <img src="@frontend-assets/images/svg/Startup_Flatline.svg" alt="">
                        <div class="mt-6">
                            <h5 class="font-medium text-xl">Property Inspection</h5>
                            <p class="text-slate-400 mt-3">No one wants to buy a lemon. Book an inspection with a
                                licensed inspector, then submit the repair requests all via the Hously platform.</p>
                        </div>
                    </div>
                    <div :class="active === 5 ? '' : 'hidden'" id="appraisal" role="tabpanel"
                        aria-labelledby="appraisal-tab">
                        <img src="@frontend-assets/images/svg/team_Flatline.svg" alt="">
                        <div class="mt-6">
                            <h5 class="font-medium text-xl">Appraisal</h5>
                            <p class="text-slate-400 mt-3">Hously monitors the appraisal process ensuring the home you
                                are purchasing meets or exceeds the price you are paying.</p>
                        </div>
                    </div>
                    <div :class="active === 6 ? '' : 'hidden'" id="closing" role="tabpanel"
                        aria-labelledby="closing-tab">
                        <img src="@frontend-assets/images/svg/Team_meeting_Two.svg" alt="">
                        <div class="mt-6">
                            <h5 class="font-medium text-xl">Closing Deal</h5>
                            <p class="text-slate-400 mt-3">Finally the closing packet is sent to the Title office, and
                                the day has come… You have Hously the home of your dreams!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end grid-->
    </div><!--end container-->
</template>

<script setup>
import { ref } from 'vue';

const active = ref(1)

const datas = ref([
    {
        id: 1,
        name: 'Pre Approval Letter'
    },
    {
        id: 2,
        name: 'Schedule a Showing'
    },
    {
        id: 3,
        name: 'Submit an Offer'
    },
    {
        id: 4,
        name: 'Property Inspection'
    },
    {
        id: 5,
        name: 'Appraisal'
    },
    {
        id: 6,
        name: 'Closing Deal'
    },
])


function handleclick(id) {
    active.value = id;
}

</script>

<style lang="scss" scoped></style>