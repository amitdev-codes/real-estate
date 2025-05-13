<template>
    <TextElement
        name="website"
        label="website"
        size="sm"
        :columns="6"
        :default="props.data.related_data.agency.website"
    />
    <TextElement
        name="registered_agency_number"
        label="Registered Agency Number"
        type="number"
        size="sm"
        :columns="6"
        :default="props.data.related_data.agency.registered_agency_number"
    />

    <TextareaElement
        name="description"
        label="Description"
        :default="props.data.related_data.agency.description"
    />
    <TextareaElement
        name="short_description"
        label="Short Description"
        :default="props.data.related_data.agency.short_description"
        class="dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
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
