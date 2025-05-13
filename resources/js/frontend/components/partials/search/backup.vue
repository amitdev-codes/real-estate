<template>
    <div class="registration-form text-dark text-start">
        <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 lg:gap-0 gap-6">
            <div>
                <label class="form-label font-medium text-slate-900 dark:text-white">Search
                    : <span class="text-red-600">*</span></label>
                <div class="filter-search-form relative filter-border mt-2">
                    <i class="uil uil-search icons"></i>
                    <input name="name" type="text" id="job-keyword"
                        class="form-input filter-input-box bg-gray-50 dark:bg-slate-800 border-0"
                        placeholder="Search your keaywords">
                </div>
            </div>


            <div>
                <label for="buy-properties"
                    class="form-label font-medium text-slate-900 dark:text-white">Select
                    Categories:</label>
                <div
                    class="filter-search-form relative filter-border mt-2 bg-gray-50 dark:bg-slate-800">
                    <i class="uil uil-estate icons"></i>

                    <v-select :options="options" :value="selected" @input="updateSelected"
                        class="ms-10"></v-select>

                </div>
            </div>

            <div>
                <label for="buy-min-price"
                    class="form-label font-medium text-slate-900 dark:text-white">Min Price
                    :</label>
                <div
                    class="filter-search-form relative filter-border mt-2 bg-gray-50 dark:bg-slate-800">
                    <i class="uil uil-usd-circle icons"></i>
                    <v-select :options="options2" :value="selected2" @input="updateSelected2"
                        class="ms-10"></v-select>

                </div>
            </div>

            <div>
                <label for="buy-max-price"
                    class="form-label font-medium text-slate-900 dark:text-white">Max Price
                    :</label>
                <div class="filter-search-form relative mt-2 bg-gray-50 dark:bg-slate-800">
                    <i class="uil uil-usd-circle icons"></i>
                    <v-select :options="options3" :value="selected3" @input="updateSelected3"
                        class="ms-10"></v-select>

                </div>
            </div>

            <div class="lg:mt-6">
                <input type="submit" id="search-buy" name="search"
                    class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white searchbtn submit-btn w-full !h-12 rounded"
                    value="Search">
            </div>
        </div><!--end grid-->
    </div><!--end container-->
    </template>

    <script setup>

    import { defineProps, defineEmits } from 'vue'
    import vSelect from 'vue-select'
    import 'vue-select/dist/vue-select.css'

    // Accept the props
    const props = defineProps({
      selected: String,
      options: Array,
      selected2: String,
      options2: Array,
      selected3: String,
      options3: Array,
    })

    // Set up the emit event
    const emit = defineEmits(['update:selected', 'update:selected2', 'update:selected3'])

    // Emit the events when the value changes
    function updateSelected(value) {
      emit('update:selected', value)
    }

    function updateSelected2(value) {
      emit('update:selected2', value)
    }

    function updateSelected3(value) {
      emit('update:selected3', value)
    }
    </script>

    <style scoped></style>
