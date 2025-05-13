<template>
  <div class="container mx-auto px-4 py-6">
    <BreadcrumbAndPageTitle
      :pageTitle="
        (isEditMode ? 'Edit' : 'Create') +
        ' ' +
        ((modelName || resourceName || '').charAt(0).toUpperCase() +
          (modelName || resourceName || '').slice(1))
      "
      :breadcrumbs="breadcrumbs"
      style="margin-bottom: 16px"
    />

    <div
      class="bg-white shadow-md rounded-lg overflow-hidden text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
    >
      <!-- Header Section (remains the same) -->
      <div
        class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
      >
        <h2
          class="text-2xl font-bold text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
        >
          {{ headerTitle }}
        </h2>
        <button
          @click="handleGoBack"
          class="text-gray-500 hover:text-gray-700 transition-colors duration-200 flex items-center"
        >
          <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6 mr-2"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M11 17l-5-5m0 0l5-5m-5 5h12"
            />
            <title>Go Back</title>
          </svg>
          Back
        </button>
      </div>

      <!-- Form Container -->
      <form @submit.prevent="handleSubmit" class="p-6 space-y-6">
        <!-- Dynamic Slot for Form Body -->
        <slot name="formBody">
          <div
            class="text-center text-gray-500 text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
          >
            No form content provided
          </div>
        </slot>

        <!-- Footer Actions -->
        <div
          class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-end space-x-3 border-t border-gray-200 text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
        >
          <DynamicButton
            label="Cancel"
            variant="secondary"
            @click="handleGoBack"
            type="button"
          />

          <DynamicButton
            :label="isEditMode ? 'Update Changes' : 'Create New'"
            variant="primary"
            type="submit"
            :processing="isSubmitting"
          />
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { computed, ref } from "vue";
import DynamicButton from "@/backend/components/ui/buttons/dynamic-button.vue";
import { router } from "@inertiajs/vue3";
import { toast } from "@/utils/toast.js"; // Updated import
import BreadcrumbAndPageTitle from "@backend-components/ui/breadcrumb-and-page-title.vue";

const props = defineProps({
  modelName: {
    type: String,
    default: "Item",
  },
  resourceName: {
    type: String,
    default: "Item",
  },
  resourceNamePlural: {
    type: String,
    default: "",
  },
  redirectRoute: {
    type: String,
    default: null, // Allow custom route override
  },
  isEditMode: {
    type: Boolean,
    default: false,
  },
  breadcrumbHome: {
    type: String,
    default: "Dashboard",
  },
  isSubmitting: {
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

const emit = defineEmits(["goBack", "formSubmitted", "formError", "resetForm"]);

// Dynamic header title generation
const headerTitle = computed(() => {
  const resourceLabel =
    props.resourceName.charAt(0).toUpperCase() + props.resourceName.slice(1);
  return props.isEditMode ? `Edit ${resourceLabel}` : `Create New ${resourceLabel}`;
});

// Enhanced submit handler
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

const handleGoBack = () => {
  const routeName =
    props.redirectRoute ||
    `admin.${props.resourceNamePlural || props.resourceName}.index`;
  router.visit(route(routeName));
};
</script>
