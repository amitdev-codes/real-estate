<template>
  <div class="grid grid-cols-1 pb-8 text-center">
    <h3
      class="mb-4 md:text-3xl md:leading-normal text-2xl leading-normal font-semibold"
    >
      How It Works
    </h3>

    <p class="text-slate-400 max-w-xl mx-auto">
      A great plateform to buy, sell and rent your properties without any agent
      or commisions.
    </p>
  </div>
  <!--end grid-->

  <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-[30px]">
    <!-- Content -->
    <div
      v-for="item in datas"
      :key="item"
      class="group relative lg:px-10 transition-all duration-500 ease-in-out rounded-xl bg-transparent overflow-hidden text-center"
    >
      <div class="relative overflow-hidden text-transparent -m-3">
        <!-- <i data-feather="hexagon" class="size-32 fill-green-600/5 mx-auto"></i> -->
        <svg
          xmlns="http://www.w3.org/2000/svg"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
          class="feather feather-hexagon w-32 h-32 mx-auto fill-primary/5"
        >
          <path
            d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"
          ></path>
        </svg>
        <div
          class="absolute top-2/4 -translate-y-2/4 start-0 end-0 mx-auto text-green-600 rounded-xl transition-all duration-500 ease-in-out text-4xl flex align-middle justify-center items-center"
        >
          <i :class="item.icon"></i>
        </div>
      </div>

      <div class="mt-6">
        <h5 class="text-xl font-medium">{{ item.name }}</h5>
        <p class="text-slate-400 mt-3">{{ item.title }}</p>
      </div>
    </div>
    <!-- Content -->
  </div>
  <!--end grid-->
</template>

<script setup>
import { ref } from "vue";

const datas = ref([
  {
    icon: "uil uil-estate",
    name: "Evaluate Property",
    title:
      "If the distribution of letters and 'words' is random, the reader will not be distracted from making.",
  },
  {
    icon: "uil uil-bag",
    name: "Meeting with Agent",
    title:
      "If the distribution of letters and 'words' is random, the reader will not be distracted from making.",
  },
  {
    icon: "uil uil-key-skeleton",
    name: "Close the Deal",
    title:
      "If the distribution of letters and 'words' is random, the reader will not be distracted from making.",
  },
]);
</script>

<style lang="scss" scoped></style>


