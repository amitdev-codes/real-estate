<template>
  <CreateEditVueFormModal
    :show="show"
    resourceName="cities"
    modelName="city"
    :itemId="selectedResource?.id"
    :isEditMode="isEditMode"
    :formData="form"
    @close="emit('close')"
    @save="handleSubmit"
    @updated="handleSuccess"
    @formError="handleFormError"
  >
    <!-- Body Slot -->
    <template #form-body>
      <SelectElement
        label="State"
        name="state_id"
        :native="false"
        :items="states"
        size="sm"
        :default="defaultStateId"
      />
      <TextElement
        name="name"
        label="City Name"
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

const states = usePage().props.dropdownData.states.map((state) => ({
  value: state.id,
  label: state.name,
}));

const defaultStateId = computed(() => {
  const selectedState = states.find(
    (state) => state.label === props.selectedResource?.name
  );
  return selectedState ? selectedState.value : "2"; // Default to ID 13 if not found
});

const errors = ref({});
const isEditMode = computed(() => !!props.selectedResource?.id);
</script>
