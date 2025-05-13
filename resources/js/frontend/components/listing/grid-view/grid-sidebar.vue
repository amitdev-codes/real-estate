<template>
   <div class="lg:col-span-4 md:col-span-6">
                        <div class="shadow dark:shadow-gray-700 p-6 rounded-xl bg-white dark:bg-slate-900 sticky top-20">
                            <form>
                                <div class="grid grid-cols-1 gap-3">
                                    <div>
                                        <label for="searchname" class="font-medium">Search Properties</label>
                                        <div class="relative mt-2">
                                            <i class="uil uil-search text-lg absolute top-[8px] start-3"></i>
                                            <input name="search" id="searchname" type="text" class="form-input border border-slate-100 dark:border-slate-800 ps-10" placeholder="Search">
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <label class="font-medium">Categories</label>
                                        <select class="form-select form-input border border-slate-100 dark:border-slate-800 block w-full mt-1">
                                            <option value="re">Residential</option>
                                            <option value="la">Land</option>
                                            <option value="co">Commercial</option>
                                            <option value="ind">Industrial</option>
                                            <option value="inv">Investment</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="font-medium">Location</label>
                                        <select class="form-select form-input border border-slate-100 dark:border-slate-800 block w-full mt-1">
                                            <option value="NY">New York</option>
                                            <option value="MC">North Carolina</option>
                                            <option value="SC">South Carolina</option>
                                        </select>
                                    </div>

                                    <div>
                                        <input type="submit" class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md w-full" value="Apply Filter">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!--end col-->
</template>

<script setup>

</script>

<style lang="scss" scoped>

</style>