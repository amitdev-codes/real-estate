<template>
    <TextElement
        name="city"
        label="city"
        size="sm"
        :columns="4"
        :default="props.data.related_data.address.city"
    />
    <TextElement
        name="state"
        label="state"
        size="sm"
        :columns="4"
        :default="props.data.related_data.address.state"
    />
    <TextElement
        name="building_number"
        label="building_number"
        size="sm"
        :columns="4"
        :default="props.data.related_data.address.building_number"
    />
    <TextElement
        name="street"
        label="street"
        size="sm"
        :columns="4"
        :default="props.data.related_data.address.street"
    />
    <TextElement
        name="postal_code"
        label="postal_code"
        size="sm"
        :columns="4"
        :default="props.data.related_data.address.postal_code"
    />
    <TextElement
        name="latitude"
        label="latitude"
        size="sm"
        :columns="4"
        :default="props.data.related_data.address.latitude"
    />
    <TextElement
        name="longitude"
        label="longitude"
        size="sm"
        :columns="4"
        :default="props.data.related_data.address.longitude"
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
