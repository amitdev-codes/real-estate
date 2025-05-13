<template>
    <span class="bg-yellow-600/10 dark:bg-yellow-600/20 border border-yellow-600/10 dark:border-yellow-600/20 text-yellow-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1">    
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