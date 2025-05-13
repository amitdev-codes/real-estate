<template>
    <FileElement
        name="image"
        label="Profile Image"
        :drop="true"
        accept=".jpg,.png,.gif"
        view="image"
        :default="props.data.media_url"
        :url="false"
        :params="{ agent_id: props.data.id }"
    />
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
});

const mediaUrl = computed(() => {
  return props.data.related_data.profile_image 
    ? `/storage/${props.data.related_data.profile_image}`  // Adjust path based on your storage setup
    : null;
});
</script>