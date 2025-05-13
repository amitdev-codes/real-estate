<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
  >
    <div
      class="relative w-full max-w-5xl p-6 bg-white rounded-lg shadow-lg text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
    >
      <!-- Form Header -->
      <div
        class="flex items-center justify-between pb-4 border-b text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
      >
        <slot name="header">
          <h3
            class="text-xl font-semibold text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
          >
            {{ headerTitle }}
          </h3>
        </slot>
        <button @click="$emit('close')" class="text-gray-400 hover:text-gray-600">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="2"
            stroke="currentColor"
            class="w-6 h-6"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              d="M6 18L18 6M6 6l12 12"
            />
          </svg>
        </button>
      </div>

      <!-- Form Body -->
      <form
        @submit.prevent="handleSubmit"
        class="p-4 space-y-4 text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
      >
        <slot name="formBody">
          <p>This is the default body content.</p>
        </slot>

        <!-- Form Footer -->
        <div
          class="flex justify-end space-x-2 text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
        >
          <!-- Cancel Button -->
          <DynamicButton label="Cancel" variant="cancel" @click="$emit('close')" />
          <!-- Save/Update Button -->
          <DynamicButton
            :label="isEditMode ? 'Update Changes' : 'Save Changes'"
            variant="success"
            :processing="isSubmitting"
            @click="$emit('save')"
          />
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue";
import DynamicButton from "@/backend/components/ui/buttons/SuccessButton.vue";
import { toast } from "@/utils/toast.js";
import { router } from "@inertiajs/vue3";

const props = defineProps({
  modelName: {
    type: String,
    default: "Item",
  },
  show: {
    type: Boolean,
    default: false,
  },
  resourceName: {
    type: String,
    default: "Item",
  },
  isEditMode: {
    type: Boolean,
    default: false,
  },
  formData: {
    type: Object,
    required: true,
  },
  itemId: {
    type: [Number, String],
    default: null,
  },
});

const emit = defineEmits(["close", "save"]);

// Dynamic header title based on resource and mode
const headerTitle = computed(() => {
  const resourceLabel =
    props.resourceName.charAt(0).toUpperCase() + props.resourceName.slice(1);
  return props.isEditMode ? `Edit ${resourceLabel}` : `Create ${resourceLabel}`;
});

// Dynamic save button text
const saveButtonText = computed(() => {
  return props.isEditMode ? "Update Changes" : "Save Changes";
});

const handleSubmit = async () => {
  try {
    const endpoint = props.isEditMode
      ? route(`admin.${props.resourceName}.update`, {
          [props.modelName]: props.itemId,
        })
      : route(`admin.${props.resourceName}.store`);

    const method = props.isEditMode ? "put" : "post";

    router[method](endpoint, props.formData, {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => {
        emit("formSubmitted");

        // Dynamic success message
        toast.success(
          props.isEditMode
            ? `${props.resourceName} updated successfully`
            : `${props.resourceName} created successfully`
        );

        // Redirect handling
        const redirectRouteName =
          props.redirectRoute ||
          `admin.${props.resourceNamePlural || props.resourceName}.index`;

        router.visit(route(redirectRouteName));

        emit("resetForm");
      },
      onError: (serverErrors) => {
        emit("formError", serverErrors);
        toast.error("Please fix the errors in the form");
      },
    });
  } catch (error) {
    toast.error("An unexpected error occurred");
    console.error(error);
  }
};
</script>
