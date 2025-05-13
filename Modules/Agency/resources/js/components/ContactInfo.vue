<template>
    <SelectElement
        name="state"
        label="State"
        rules="required"
        size="sm"
        :columns="4"
        :items="states"
        :default="props.data?.address?.state"  
        @update:modelValue="updateForm"
    />
    <SelectElement
        name="city"
        label="City"
        rules="required"
        size="sm"
        :columns="4"
        :items="cities"
        :default="props.data?.address?.city"   
        @update:modelValue="updateForm"
    />
    <TextElement
        name="street"
        label="Street Address"
        size="sm"
        :columns="4"
        :default="props.data?.address?.street"
        @update:modelValue="updateForm"
    />
    <TextElement
        name="building_number"
        label="Building Number"
        input-type="number"
        size="sm"
        :columns="4"
        :default="props.data?.address?.building_number"
        @update:modelValue="updateForm"
    />
    <TextElement
        name="postal_code"
        label="Postal code (optional)"
        input-type="number"
        size="sm"
        :columns="4"
        :default="props.data?.address?.postal_code"
        @update:modelValue="updateForm"
    />
    <TextElement
        name="latitude"
        label="Latitude"
        input-type="number"
        size="sm"
        :columns="4"
        :default="props.data?.address?.latitude"
        @update:modelValue="updateForm"
    />
    <TextElement
        name="longitude"
        label="Longitude"
        input-type="number"
        size="sm"
        :columns="4"
        :default="props.data?.address?.longitude"
        @update:modelValue="updateForm"
    />
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});

const emit = defineEmits(['update']);

// Access shared Inertia data
const { states, cities } = usePage().props;

const updateForm = (value) => {
    emit('update', value);
};
</script>