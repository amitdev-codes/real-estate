<!-- BasicInfo.vue -->
<template>
    <TextElement
        name="name"
        label="Name"
        rules="required"
        size="sm"
        :columns="4"
        :default="props.data.name"
    />
    <TextElement
        name="email"
        label="Email"
        rules="required"
        size="sm"
        type="email"
        :columns="4"
        :default="props.data.email"
    />
    <PhoneElement
        name="phone"
        label="Mobile Number"
        :allow-incomplete="true"
        :unmask="true"
        :include="['Au', 'us', 'gb', 'de', 'np']"
        rules="required"
        size="sm"
        :columns="4"
        :default="props.data.phone"
    />
    <TextElement
        name="website"
        label="Webiste"
        size="sm"
        :columns="4"
        :default="props.data.website"
    />
    <TextElement
        name="registered_agency_number"
        label="Registered Agency Number"
        size="sm"
        :columns="4"
        :default="props.data.registered_agency_number"
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
