<template>
    <label class="font-medium text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>

<script setup>
defineProps({
    value: {
        type: String,
    },
});
</script>