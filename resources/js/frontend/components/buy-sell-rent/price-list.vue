<template>

    <form class="p-6 bg-white dark:bg-slate-900 rounded-xl shadow dark:shadow-gray-700">
        <div class="registration-form text-dark text-start">
            <div class="" :class="grids">
                <div>
                    <label class="form-label font-medium text-slate-900 dark:text-white">Search : <span
                            class="text-red-600">*</span></label>
                    <div class="filter-search-form relative filter-border mt-2">
                        <i class="uil uil-search icons"></i>
                        <input name="name" type="text" id="job-keyword"
                            class="form-input filter-input-box bg-gray-50 dark:bg-slate-800 border-0"
                            placeholder="Search your keaywords">
                    </div>
                </div>

                <div>
                    <label for="buy-properties" class="form-label font-medium text-slate-900 dark:text-white">Select
                        Categories:</label>
                    <div class="filter-search-form relative filter-border mt-2 bg-gray-50 dark:bg-slate-800">
                        <i class="uil uil-estate icons"></i>
                        <v-select :options="options" v-model="selected" class="ms-10"></v-select>
                    </div>
                </div>

                <div>
                    <label for="buy-min-price" class="form-label font-medium text-slate-900 dark:text-white">Min
                        Price :</label>
                    <div class="filter-search-form relative filter-border mt-2 bg-gray-50 dark:bg-slate-800">
                        <i class="uil uil-usd-circle icons"></i>
                        <v-select :options="options2" v-model="selected2" class="ms-10"></v-select>
                    </div>
                </div>

                <div>
                    <label for="buy-max-price" class="form-label font-medium text-slate-900 dark:text-white">Max
                        Price :</label>
                    <div class="filter-search-form relative mt-2 bg-gray-50 dark:bg-slate-800">
                        <i class="uil uil-usd-circle icons"></i>
                        <v-select :options="options3" v-model="selected3" class="ms-10"></v-select>
                    </div>
                </div>

                <div class="lg:mt-6">
                    <input type="submit" id="search-buy" name="search"
                        class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white searchbtn submit-btn w-full !h-[60px] lg:rounded-none rounded mt-2"
                        value="Search">
                </div>
            </div><!--end grid-->
        </div><!--end container-->
    </form><!--end form-->

    <!-- End Hero -->
</template>

<script setup>
import { ref } from 'vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

const props = defineProps({
    grids: {
        type: String,
        required: true
    }
})

const options = ref(['Houses', 'Apartment', 'Offices', 'Townhome',])
const selected = ref('Houses')
const options2 = ref(['Min Price', '500', '1000', '2000', '3000', '4000', '5000', '6000'])
const selected2 = ref('Min Price')
const options3 = ref(['Max Price', '500', '1000', '2000', '3000', '4000', '5000', '6000'])
const selected3 = ref('Max Price')
</script>

<style lang="scss" scoped></style>
