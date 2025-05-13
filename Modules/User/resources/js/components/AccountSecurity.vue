<!-- BasicInfo.vue -->
<template>
    <TextElement
        label="Password"
        name="password"
        input-type="password"
        :rules="['required', 'min:8', 'same:password_confirmation']"
        field-name="Password"
        size="sm"
    />
    <TextElement
        name="password_confirmation"
        input-type="password"
        :rules="['required']"
        field-name="Password confirmation"
        label="Confirm Password"
        size="sm"
    />
</template>

<script setup>
const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(["update"]);
</script>
