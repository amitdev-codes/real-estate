<!-- RoleForm.vue -->
<template>
  <CreateEditForm
    :show="show"
    resourceName="roles"
    modelName="role"
    :isEditMode="isEditMode"
    :formData="form"
    :itemId="role?.id"
    @goBack="emit('close')"
    @formSubmitted="handleFormSuccess"
    @formError="handleFormError"
    @resetForm="resetForm"
  >
    <!-- Body Slot -->
    <template #formBody>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <TextInput
          v-model="form.name"
          type="text"
          label="Role Name"
          id="name"
          placeholder="Enter Name"
          :required="true"
          :error="errors.name"
        />
        <div class="col-span-full">
          <PermissionGroup
            :group="group"
            :permissions="permissions"
            v-model="form.permissions"
          />
        </div>
      </div>
    </template>
  </CreateEditForm>
</template>

<script setup>
import { ref, computed, watch } from "vue";
import CreateEditForm from "@/backend/components/modals/CreateEditForm.vue";
import TextInput from "@/backend/components/ui/inputs/TextInput.vue";
import PermissionGroup from "@/backend/components/ui/inputs/PermissionGroup.vue";
import BackendLayout from "@/layouts/backend-layout.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
  role: {
    type: Object,
    default: null,
  },
  permissions: {
    type: Object,
    required: true,
  },
  show: {
    type: Boolean,
    default: false,
  },
});

const { props: pageProps } = usePage();

const emit = defineEmits(["close", "updated"]);
const form = ref({
  name: computed({
    get: () => props.role?.name || "",
    set: (value) => {
      form.value.name = value;
    },
  }),
  permissions: computed({
    get: () => props.role?.permissions?.map((p) => p.name) || [],
    set: (value) => {
      form.value.permissions = value;
    },
  }),
});

const errors = ref({});
const isEditMode = computed(() => !!props.role?.id);

const resetForm = () => {
  form.value = {
    name: "",
    permissions: [],
  };
  errors.value = {};
};

watch(
  () => props.role,
  (newRole) => {
    if (newRole) {
      form.value = {
        name: newRole.name || "",
        permissions: newRole.permissions?.map((p) => p.name) || [],
      };
    } else {
      resetForm();
    }
  },
  { immediate: true }
);

const handleFormSuccess = () => {
  emit("updated");
  emit("close");
};

const handleFormError = (serverErrors) => {
  errors.value = serverErrors;
};
</script>

<script>
export default {
  layout: BackendLayout,
};
</script>
