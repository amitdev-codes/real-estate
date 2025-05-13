<template>
  <CreateEditVueFormModal
    :show="show"
    resourceName="countries"
    modelName="country"
    :itemId="selectedResource?.id"
    :isEditMode="isEditMode"
    :formData="form"
    :validation-rules="rules"
    @close="emit('close')"
    @save="handleSubmit"
    @formSubmitted="handleSuccess"
    @formError="handleFormError"
  >
    <!-- Body Slot -->
    <template #form-body>
      <TextElement
        name="name"
        label="Country Name"
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
import CreateEditVueFormModal from "@/backend/components/modals/CreateEditVueFormModal.vue";
import { ref, computed } from "vue";
const props = defineProps({
  show: { type: Boolean, default: false },
  selectedResource: { type: Object, default: null },
});

const emit = defineEmits(["close", "save", "updated"]);
const errors = ref({});
const isEditMode = computed(() => !!props.selectedResource?.id);
const handleFormError = (serverErrors) => {
  errors.value = serverErrors;
};
const handleSuccess = () => {
  emit("updated");
  emit("close");
};
</script>
