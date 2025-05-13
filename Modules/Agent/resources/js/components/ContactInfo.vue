<!-- ContactInfo.vue -->
<template>
  <div class="grid grid-cols-1 gap-3 sm:grid-cols-4">
    <Select
      v-model="formData.country"
      :options="props.country"
      label="Select Country"
      placeholder="Choose a Country"
      valueKey="id"
      labelKey="name"
      :selected="selectedCountry"
    />
    <Select
      v-model="formData.state"
      :options="props.state"
      label="Select State"
      placeholder="Choose a State"
      valueKey="id"
      labelKey="name"
      :selected="selectedState"
    />
    <Select
      v-model="formData.city"
      :options="props.city"
      label="Select City"
      placeholder="Choose a City"
      valueKey="id"
      labelKey="name"
      :selected="selectedCity"
    />

    <TextInput
      v-model="formData.street"
      type="text"
      label="Street"
      id="street"
      placeholder="Street"
      :required="true"
    />
    <TextInput
      v-model="formData.postal_code"
      type="text"
      label="Postal Code"
      id="postal_code"
      :required="true"
    />
    <TextInput
      v-model="formData.latitude"
      type="text"
      label="Latitude"
      id="latitude"
      placeholder="Latitude"
      :required="true"
    />
    <TextInput
      v-model="formData.longitude"
      type="text"
      label="Longitude"
      id="longitude"
      placeholder="Longitude"
      :required="true"
    />
  </div>
</template>

<script setup>
import { ref, watch, onMounted } from "vue";
import TextInput from "@/backend/components/ui/inputs/TextInput.vue";
import Select from "@/backend/components/ui/inputs/Select.vue";

const props = defineProps({
  data: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(["update"]);
// Create a local copy of the form data
const formData = ref({
  country: "",
  state: "",
  city: "",
  street: "",
  postal_code: "",
  latitude: "",
  longitude: "",
  building_number: "",
});
// Initialize form with passed data
onMounted(() => {
  if (props.data) {
    formData.value = {
      country: props.data.country ?? "",
      state: props.data.state ?? "",
      city: props.data.city ?? "",
      street: props.data.street ?? "",

      postal_code: props.data.postal_code ?? "",
      latitude: props.data.latitude ?? "",
      longitude: props.data.longitude ?? "",
      building_number: props.data.building_number ?? "",
    };
  }
});

// Watch for changes and emit updates
watch(
  formData,
  (newValue) => {
    const cleanData = {
      country: newValue.country?.trim() || "",
      state: newValue.state?.trim() || "",
      city: newValue.city?.trim() || "",
      street: newValue.street?.trim() || "",

      postal_code: newValue.postal_code?.trim() || "",
      latitude: newValue.latitude?.trim() || "",
      longitude: newValue.longitude?.trim() || "",
      building_number: newValue.building_number?.trim() || "",
    };

    emit("update", cleanData);
  },
  { deep: true }
);
</script>
