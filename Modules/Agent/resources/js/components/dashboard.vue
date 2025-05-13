<template>
  <!-- Start Content -->
  <div class="flex justify-between items-center">
    <div>
      <h5 class="text-xl font-semibold">Hello,{{ auth.user.name }}</h5>
      <h6 class="text-slate-400">Welcome back!</h6>
    </div>
  </div>

  <div class="grid xl:grid-cols-4 md:grid-cols-3 grid-cols-1 mt-6 gap-6">
    <!--end-->

    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Total Visitor</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium"
              ><count-up class="counter-value" :end-val="props.data.total_visits"
                >{{ props.data.total_visits }}
              </count-up></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-account-group-outline text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->

    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Total Properties</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium"
              ><count-up class="counter-value" :end-val="props.data.total_properties">{{
                props.data.total_properties
              }}</count-up></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-home-city-outline text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->

    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Approved Properties</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium"
              ><count-up
                class="counter-value"
                :end-val="props.data.approved_properties"
                >{{ props.data.approved_properties }}</count-up
              ></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-home-lightning-bolt-outline text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->

    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Pending Properties</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium"
              ><count-up class="counter-value" :end-val="props.data.pending_properties">{{
                props.data.pending_properties
              }}</count-up></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-home-clock-outline text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->
  </div>
</template>

<script setup>
import CountUp from "vue-countup-v3";
import { usePage } from "@inertiajs/vue3";

const auth = usePage().props.auth;
const props = defineProps({
  data: Array,
});



</script>

<style lang="scss" scoped></style>
