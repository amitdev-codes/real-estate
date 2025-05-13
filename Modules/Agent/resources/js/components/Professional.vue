<template>
  <TextElement
    name="license_number"
    label="License Number"
    rules="required"
    size="sm"
    :columns="6"
    :default="props.data.license_number"
  />
  <TextElement
    name="experience"
    label="Years of Experience"
    rules="required"
    size="sm"
    :columns="6"
    :default="props.data.experience"
  />
  <SelectElement
    label="Agency"
    name="agency_id"
    :native="false"
    :items="agencies"
    size="sm"
    :default="defaultAgencyId"
    :columns="6"
  />
</template>

<script setup>
import { ref, computed, watch } from "vue";
const props = defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
  agencies: {
    type: Array,
    default: () => [],
  },
});

const agencies = props.agencies.map((agency) => ({
  value: agency.id,
  label: agency.name,
}));

const defaultAgencyId = computed(() => {
  const selectedAgency = agencies.find((agency) => agency.label === props.data?.name);
  return selectedAgency ? selectedAgency.value : "5";
});

const emit = defineEmits(["update"]);
</script>
