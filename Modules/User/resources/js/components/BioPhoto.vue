<template>
    <FileElement
        name="image"
        label="Profile Image"
        :drop="true"
        accept=".jpg,.png,.gif"
        view="image"
        :default="props.data.media_url"
        :url="false"
        :params="{ user_id: props.data.id }"
    />

    <TextElement
        name="short_description"
        :default="props.data.short_description"
        label="Professional Description"
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

console.log(props.data);
</script>
