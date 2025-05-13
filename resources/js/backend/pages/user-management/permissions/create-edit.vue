<template>
  <CreateEditModal
    :show="show"
    resourceName="permissions"
    modelName="permission"
    :itemId="selectedResource?.id"
    :isEditMode="isEditMode"
    :formData="form"
    :validation-rules="rules"
    @close="emit('close')"
    @formSubmitted="handleSuccess"
    @formError="handleFormError"
  >
    <!-- Body Slot -->
    <template #form-body>
      <TextElement
        name="name"
        label="Resource Name"
        rules="required"
        size="sm"
        :default="props.selectedResource.name"
      />
    </template>
  </CreateEditModal>
</template>

<script setup>
import { ref, computed, watch, onMounted } from "vue";
import CreateEditModal from "@/backend/components/modals/CreateEditVueFormModal.vue";
import TextInput from "@/backend/components/ui/inputs/TextInput.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
  show: { type: Boolean, default: false },
  selectedResource: { type: Object, default: null },
});

const emit = defineEmits(["close", "save", "updated"]);

const errors = ref({});
const isEditMode = computed(() => !!props.selectedResource?.id);

const handleFormSuccess = () => {
  emit("updated");
  emit("close");
};

const handleFormError = (serverErrors) => {
  errors.value = serverErrors;
};
</script>
