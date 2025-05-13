<template>
    <FileElement
        name="image"
        label="Profile Image"
        :drop="true"
        accept=".jpg,.png,.gif"
        view="image"
        :default="props.data.media_url"
        :url="false"
        :params="{ agency_id: props.data.id }"
    />
    <TextElement
        name="description"
        :default="props.data.description"
        label="Professional Description"
    />
    <TextElement
        name="short_description"
        :default="props.data.short_description"
        label="Short Description"
    />
</template>

<script setup>
import { defineProps } from "vue";
const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
});

</script>
