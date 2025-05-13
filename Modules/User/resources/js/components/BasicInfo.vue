<!-- BasicInfo.vue -->
<template>
    <TextElement
        name="name"
        label="Full Name"
        rules="required"
        size="sm"
        :columns="6"
        :default="props.data.name"
    />
    <TextElement
        name="email"
        label="Email"
        rules="required"
        size="sm"
        type="email"
        :columns="6"
        :default="props.data.email"
    />
    <PhoneElement
        name="mobile_no"
        label="Mobile Number"
        :allow-incomplete="true"
        :unmask="true"
        :include="['Au', 'us', 'gb', 'de', 'np']"
        rules="required"
        size="sm"
        :columns="6"
        :default="props.data.mobile_no"
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
