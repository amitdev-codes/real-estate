<template>
    <span class="bg-primary-300/10  border-primary-600/10  text-primary-500 
         dark:bg-primary-400/20 border dark:border-primary-400/20 dark:text-primary-400
         text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1">
        {{ label }}
    </span>
</template>

<script setup>
defineProps({
    label: {
        type: String,
    },
});
</script>

<style lang="scss" scoped>

</style>