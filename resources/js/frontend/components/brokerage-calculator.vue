<template>
    <div class="container relative lg:mt-24 mt-16">
      <div class="grid grid-cols-1 pb-8 text-center">
        <h3 class="mb-4 md:text-3xl md:leading-normal text-2xl leading-normal font-semibold">Brokerage Calculator</h3>
  
        <p class="text-slate-400 max-w-xl mx-auto">A great plateform to buy, sell and rent your properties without any agent or commisions.</p>
      </div><!--end grid-->
  
      <div class="md:flex justify-center mt-8">
        <div class="lg:w-3/5 md:w-4/5">
          <div class="p-6 shadow dark:shadow-gray-700 rounded-md" role="form">
            <ul class="list-none flex justify-between">
              <li class="h6">Min $ 10000</li>
              <li class="h6">Max $ 200000</li>
            </ul>
  
            <div class="row">
              <div class="col-sm-12 mb-4">
                <label for="slider" class="form-label"></label>
                <input id="slider" type="range" v-model="sliderValue" min="10000" max="200000" class="w-full h-2 bg-gray-100 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
              </div><!--end col-->
            </div><!--end row-->
  
            <ul class="list-none text-center md:flex justify-between">
              <li>
                <ul class="text-md-start brokerage-form list-none">
                  <li class="font-medium"><label class="control-label">Total Value ($)</label></li>
                  <li><span class="text-green-600">$</span> <p class="inline-block h5 text-green-600" id="amount-label">{{ sliderValue }}</p></li>
                </ul>
              </li>
  
              <li class="mt-2 mt-sm-0">
                <ul class="text-md-end brokerage-form list-none">
                  <li class="font-medium"><label class="control-label">Brokerage Fee ($)</label></li>
                  <li><span class="text-green-600">$</span> <p class="inline-block h5 text-green-600" id="saving-label">{{ brokerageFee }}</p></li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div><!--end grid-->
    </div><!--end container-->
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  
  const sliderValue = ref(10000);
  const brokerageFee = computed(() => parseFloat(sliderValue.value * 0.01).toFixed(2));
  
 
  </script>
  
  <style lang="scss" scoped>
  // Your styles here
  </style>