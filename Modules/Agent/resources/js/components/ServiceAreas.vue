<template>
  <TextElement
    name="primary_area"
    label="Primary Area"
    rules="required"
    size="sm"
    :columns="6"
    :default="props.data.primary_area"
  />

  <TagsElement
    :native="false"
    label="Additional areas"
    name="additional_areas"
    :create="true"
    :items="normalizeSpecializations(props.data.additional_areas)"
    :default="normalizeSpecializations(props.data.additional_areas)"
    size="sm"
    :columns="6"
  />
</template>

<script setup>
const props = defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
});
const normalizeSpecializations = (additional_areas) => {
  return Array.isArray(additional_areas)
    ? additional_areas
    : JSON.parse(additional_areas);
};
</script>

<style></style>
