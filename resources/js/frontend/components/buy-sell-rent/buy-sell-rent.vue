<template>
    <ul class="inline-block mx-auto sm:w-fit w-full flex-wrap justify-center text-center p-4 bg-white dark:bg-slate-900 backdrop-blur-sm rounded-t-xl border-b dark:border-gray-800 mt-10"
        id="myTab" data-tabs-toggle="#StarterContent" role="tablist">
        <li role="presentation" class="inline-block me-1">
            <button @click="toggle(1)"
                :class="isActive === 1 ? 'text-white bg-green-600' : 'dark:hover:bg-slate-800 hover:text-green-600  hover:bg-gray-50 dark:hover:text-white'"
                class="sm:px-8 px-6 py-2 text-base font-medium rounded-xl w-full transition-all duration-500 ease-in-out"
                id="buy-home-tab" data-tabs-target="#buy-home" type="button" role="tab" aria-controls="buy-home"
                aria-selected="true">Buy</button>
        </li>
        <li role="presentation" class="inline-block me-1">
            <button @click="toggle(2)"
                :class="isActive === 2 ? 'text-white bg-green-600' : 'dark:hover:bg-slate-800 hover:text-green-600  hover:bg-gray-50 dark:hover:text-white'"
                class="sm:px-8 px-6 py-2 text-base font-medium rounded-xl w-full transition-all duration-500 ease-in-out"
                id="sell-home-tab" data-tabs-target="#sell-home" type="button" role="tab" aria-controls="sell-home"
                aria-selected="false">Sell</button>
        </li>
        <li role="presentation" class="inline-block">
            <button @click="toggle(3)"
                :class="isActive === 3 ? 'text-white bg-green-600' : 'dark:hover:bg-slate-800 hover:text-green-600  hover:bg-gray-50 dark:hover:text-white'"
                class="sm:px-8 px-6 py-2 text-base font-medium rounded-xl w-full transition-all duration-500 ease-in-out"
                id="rent-home-tab" data-tabs-target="#rent-home" type="button" role="tab" aria-controls="rent-home"
                aria-selected="false">Rent</button>
        </li>
    </ul>

    <div id="StarterContent"
        class="p-6 bg-white dark:bg-slate-900 md:rounded-xl rounded-none shadow-md dark:shadow-gray-700">
        <div :class="isActive === 1 ? '' : 'hidden'" id="buy-home" role="tabpanel" aria-labelledby="buy-home-tab">
            <form action="#">
                <div class="registration-form text-dark text-start">
                    <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 lg:gap-0 gap-6">
                        <div>
                            <label class="form-label font-medium text-slate-900 dark:text-white">Search :
                                <span class="text-red-600">*</span></label>
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
                            <div class="filter-search-form relative filter-border mt-2 bg-gray-50 dark:bg-slate-800">
                                <i class="uil uil-estate icons"></i>
                                <v-select :options="options" v-model="selected" class="ms-10"></v-select>
                            </div>
                        </div>

                        <div>
                            <label for="buy-min-price" class="form-label font-medium text-slate-900 dark:text-white">Min
                                Price
                                :</label>
                            <div class="filter-search-form relative filter-border mt-2 bg-gray-50 dark:bg-slate-800">
                                <i class="uil uil-usd-circle icons"></i>
                                <v-select :options="options2" v-model="selected2" class="ms-10"></v-select>
                            </div>
                        </div>

                        <div>
                            <label for="buy-max-price" class="form-label font-medium text-slate-900 dark:text-white">Max
                                Price
                                :</label>
                            <div class="filter-search-form relative mt-2 bg-gray-50 dark:bg-slate-800">
                                <i class="uil uil-usd-circle icons"></i>
                                <v-select :options="options3" v-model="selected3" class="ms-10"></v-select>
                            </div>
                        </div>

                        <div class="lg:mt-6">
                            <input type="submit" id="search-buy" name="search"
                                class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white searchbtn submit-btn w-full !h-12 rounded"
                                value="Search">
                        </div>
                    </div><!--end grid-->
                </div><!--end container-->
            </form>
        </div>

        <div :class="isActive === 2 ? '' : 'hidden'" id="sell-home" role="tabpanel" aria-labelledby="sell-home-tab">
            <form action="#">
                <div class="registration-form text-dark text-start">
                    <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 lg:gap-0 gap-6">
                        <div>
                            <label class="form-label font-medium text-slate-900 dark:text-white">Search :
                                <span class="text-red-600">*</span></label>
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
                            <div class="filter-search-form relative filter-border mt-2 bg-gray-50 dark:bg-slate-800">
                                <i class="uil uil-estate icons"></i>
                                <v-select :options="options" v-model="selected" class="ms-10"></v-select>
                            </div>
                        </div>

                        <div>
                            <label for="buy-min-price" class="form-label font-medium text-slate-900 dark:text-white">Min
                                Price
                                :</label>
                            <div class="filter-search-form relative filter-border mt-2 bg-gray-50 dark:bg-slate-800">
                                <i class="uil uil-usd-circle icons"></i>
                                <v-select :options="options2" v-model="selected2" class="ms-10"></v-select>
                            </div>
                        </div>

                        <div>
                            <label for="buy-max-price" class="form-label font-medium text-slate-900 dark:text-white">Max
                                Price
                                :</label>
                            <div class="filter-search-form relative mt-2 bg-gray-50 dark:bg-slate-800">
                                <i class="uil uil-usd-circle icons"></i>
                                <v-select :options="options3" v-model="selected3" class="ms-10"></v-select>
                            </div>
                        </div>

                        <div class="lg:mt-6">
                            <input type="submit" id="search-sell" name="search"
                                class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white searchbtn submit-btn w-full !h-12 rounded"
                                value="Search">
                        </div>
                    </div><!--end grid-->
                </div><!--end container-->
            </form>
        </div>

        <div :class="isActive === 3 ? '' : 'hidden'" id="rent-home" role="tabpanel" aria-labelledby="rent-home-tab">
            <form action="#">
                <div class="registration-form text-dark text-start">
                    <div class="grid lg:grid-cols-4 md:grid-cols-2 grid-cols-1 lg:gap-0 gap-6">
                        <div>
                            <label class="form-label font-medium text-slate-900 dark:text-white">Search :
                                <span class="text-red-600">*</span></label>
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
                            <div class="filter-search-form relative filter-border mt-2 bg-gray-50 dark:bg-slate-800">
                                <i class="uil uil-estate icons"></i>
                                <v-select :options="options" v-model="selected" class="ms-10"></v-select>
                            </div>
                        </div>

                        <div>
                            <label for="buy-min-price" class="form-label font-medium text-slate-900 dark:text-white">Min
                                Price
                                :</label>
                            <div class="filter-search-form relative filter-border mt-2 bg-gray-50 dark:bg-slate-800">
                                <i class="uil uil-usd-circle icons"></i>
                                <v-select :options="options2" v-model="selected2" class="ms-10"></v-select>
                            </div>
                        </div>

                        <div>
                            <label for="buy-max-price" class="form-label font-medium text-slate-900 dark:text-white">Max
                                Price
                                :</label>
                            <div class="filter-search-form relative mt-2 bg-gray-50 dark:bg-slate-800">
                                <i class="uil uil-usd-circle icons"></i>
                                <v-select :options="options3" v-model="selected3" class="ms-10"></v-select>
                            </div>
                        </div>

                        <div class="lg:mt-6">
                            <input type="submit" id="search-rent" name="search"
                                class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white searchbtn submit-btn w-full !h-12 rounded"
                                value="Search">
                        </div>
                    </div><!--end grid-->
                </div><!--end container-->
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css'

const isActive = ref(1)
const options = ref(['Houses', 'Apartment', 'Offices', 'Townhome',])
const selected = ref('Houses')
const options2 = ref(['Min Price', '500', '1000', '2000', '3000', '4000', '5000', '6000'])
const selected2 = ref('Min Price')
const options3 = ref(['Max Price', '500', '1000', '2000', '3000', '4000', '5000', '6000'])
const selected3 = ref('Max Price')



function toggle(Number) {
    isActive.value = Number
}
</script>

<style lang="scss" scoped></style>