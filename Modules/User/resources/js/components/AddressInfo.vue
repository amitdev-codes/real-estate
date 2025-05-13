<template>
    <!-- Building Number -->
    <TextElement
        name="building_number"
        label="Building Number"
        rules="required"
        size="sm"
        :columns="6"
        :default="props.data.address?.building_number || ''"
    />

    <!-- State Dropdown -->
    <SelectElement
        label="State"
        name="states"
        :native="false"
        :items="states"
        size="sm"
        :columns="6"
        :default="defaultStateId"
    />

    <!-- City Dropdown -->
    <SelectElement
        label="City"
        name="cities"
        :native="false"
        :items="cities"
        size="sm"
        :columns="6"
        :default="defaultCityId"
    />

    <!-- Postal Code -->
    <TextElement
        name="postal_code"
        label="Postal Code"
        rules="required"
        size="sm"
        :columns="6"
        :default="props.data.address?.postal_code || ''"
    />
</template>

<script setup>
import { ref, computed, watch } from "vue";

// Props
const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    states: {
        type: Array,
        default: () => [],
    },
    cities: {
        type: Array,
        default: () => [],
    },
});

// console.log(props.data.address);

const states = props.states.map((state) => ({
    value: state.id,
    label: state.name,
}));
const cities = props.cities.map((city) => ({
    value: city.id,
    label: city.name,
}));
const defaultStateId = computed(() => {
    return (
        props.states.find((state) => state.id == props.data.address?.state)
            ?.id || "5"
    );
});
const defaultCityId = computed(() => {
    return (
        props.cities.find((city) => city.id == props.data.address?.city)?.id ||
        "5"
    );
});
</script>
