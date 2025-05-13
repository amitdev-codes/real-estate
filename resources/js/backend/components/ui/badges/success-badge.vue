<template>
    <span class="bg-emerald-600/10 dark:bg-emerald-600/20 border border-emerald-600/10 dark:border-emerald-600/20 text-emerald-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1">
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