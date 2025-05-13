<template>
    <span class="bg-blue-600/10 dark:bg-blue-600/20 border border-blue-600/10 dark:border-blue-600/20 text-blue-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1">
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