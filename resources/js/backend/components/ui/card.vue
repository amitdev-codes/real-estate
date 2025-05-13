<template>
    <div class="rounded-md shadow dark:shadow-gray-700 p-4 bg-white dark:bg-slate-900 h-fit mt-4">

        <div v-if="$slots.header" class="text-gray-700 dark:text-gray-300 font-medium">
            <slot name="header" />
            <hr class="my-4" />
        </div>

        <slot/>

    </div>
</template>

