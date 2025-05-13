<template>
  <CreateEditVueFormModal
    :show="show"
    resourceName="states"
    modelName="state"
    :itemId="selectedResource?.id"
    :isEditMode="isEditMode"
    :formData="form"
    :validation-rules="rules"
    @close="emit('close')"
    @save="handleSubmit"
    @updated="handleSuccess"
    @formError="handleFormError"
  >
    <!-- Body Slot -->
    <template #form-body>
      <!-- Countries Field -->
      <SelectElement
        label="Country"
        name="country_id"
        :native="false"
        :items="countries"
        size="sm"
        :default="defaultCountryId"
      />
      <TextElement
        name="name"
        label="State Name"
        rules="required"
        size="sm"
        :default="props.selectedResource.name"
        :columns="6"
      />
      <TextElement
        name="code"
        label="Code"
        rules="required"
        size="sm"
        :default="props.selectedResource.code"
        :columns="6"
      />
    </template>
  </CreateEditVueFormModal>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import CreateEditVueFormModal from "@/backend/components/modals/CreateEditVueFormModal.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
  show: { type: Boolean, default: false },
  selectedResource: { type: Object, default: null },
});

const emit = defineEmits(["close", "save", "updated"]);
const errors = ref({});
const isEditMode = computed(() => !!props.selectedResource?.id);

const countries = usePage().props.dropdownData.countries.map((country) => ({
  value: country.id,
  label: country.name,
}));

const defaultCountryId = computed(() => {
  const selectedCountry = countries.find(
    (country) => country.label === props.selectedResource?.name
  );
  return selectedCountry ? selectedCountry.value : "13"; // Default to ID 13 if not found
});

// console.log("datatas are", props.selectedResource.country_id);

const handleSuccess = () => {
  emit("updated");
  emit("close");
};

const handleFormError = (serverErrors) => {
  errors.value = serverErrors;
};
</script>
