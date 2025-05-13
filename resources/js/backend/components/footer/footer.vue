<template>
    <!-- Footer Start -->
    <!-- <footer class="shadow dark:shadow-gray-700 bg-white dark:bg-slate-900 px-6 py-4"> -->
    <footer class="shadow dark:shadow-gray-700 bg-white dark:bg-slate-900 px-6 py-2">
        <div class="container-fluid">
            <div class="grid grid-cols-1">
                <div class="sm:text-start text-center mx-md-2">
                    <!-- <p class="mb-0 text-slate-400">©
                        {{date}} Hously. Design & Develop with <i
                            class="mdi mdi-heart text-red-600"></i> by <a href="https://shreethemes.in/" target="_blank"
                            class="text-reset">Shreethemes</a>.
                    </p> -->

                    <p class="mb-0 text-slate-400">©
                        {{date}} www.dreamestate.au
                    </p>

                </div><!--end col-->
            </div><!--end grid-->
        </div><!--end container-->
    </footer><!--end footer-->
    <!-- End -->
</template>

<script setup>

const date = new Date().getFullYear()

</script>

<style lang="scss" scoped></style>
