<template>
  <FileElement
    name="image"
    label="Profile Image"
    :drop="true"
    accept=".jpg,.png,.gif"
    view="image"
    :default="mediaUrl"
    :url="false"
    :params="{ agent_id: props.data.id }"
    @upload-success="fetchUpdatedData"
  />

  <TextElement
    name="short_description"
    :default="props.data.short_description"
    label="Professional Description"
  />
  <TagsElement
    :native="false"
    label="Specializations "
    name="specializations"
    :create="true"
    :items="normalizeSpecializations(props.data.specializations)"
    :default="normalizeSpecializations(props.data.specializations)"
    size="sm"
  />
</template>

<script setup>
import { defineProps, ref, computed } from "vue";
import axios from "axios";

const props = defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
});

const currentMedia = ref(props.data.media_url);

const mediaUrl = computed(() => {
  return currentMedia.value ? `${currentMedia.value}?t=${Date.now()}` : props.data.media_url;
});

const fetchUpdatedData = async () => {
  try {
    const response = await axios.get(`/agent/${props.data.id}/media`); // Adjust endpoint as needed
    currentMedia.value = response.data.media_url;
  } catch (error) {
    console.error('Error fetching updated media:', error);
  }
};

const normalizeSpecializations = (specializations) => {
  return Array.isArray(specializations) 
    ? specializations 
    : specializations ? JSON.parse(specializations) : [];
};
</script>