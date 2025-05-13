<template>
  <div
    v-if="show"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
  >
    <div
      class="relative w-full max-w-5xl p-6 bg-white rounded-lg shadow-lg dark:bg-gray-700"
    >
      <!-- Modal Header -->
      <div class="flex items-center justify-between pb-4 border-b dark:border-gray-600">
        <slot name="header">
          <h3 class="text-xl font-semibold text-gray-600 dark:text-gray-200">
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

      <!-- Vueform -->
      <Vueform
        v-bind="vueform"
        :model-value="data"
        :endpoint="handleSubmit"
        @success="handleSuccess"
        @error="handleError"
        class="p-4 space-y-4 text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
      >
        <!-- Form Body - Will contain Vueform elements -->
        <slot name="form-body" :values="values" :errors="errors">
          <p>Please add form elements here</p>
        </slot>
        <ButtonElement :button-label="saveButtonText" :submits="true" />
      </Vueform>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from "vue";
import { Link, useForm, usePage, router } from "@inertiajs/vue3";
import { toast } from "@/utils/toast.js";

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
  validationRules: {
    type: Object,
    default: () => ({}),
  },
  validationMessages: {
    type: Object,
    default: () => ({}),
  },
});
const form$ = ref(null);
const emit = defineEmits(["close", "save", "formSubmitted", "formError", "resetForm"]);

const isSubmitting = ref(false);

const headerTitle = computed(() => {
  const resourceLabel =
    props.resourceName.charAt(0).toUpperCase() + props.resourceName.slice(1);
  return props.isEditMode ? `Edit ${resourceLabel}` : `Create ${resourceLabel}`;
});

const saveButtonText = computed(() => {
  return props.isEditMode ? "Update Changes" : "Save Changes";
});

const handleSubmit = (vueformData, form$) => {
  const requestData = form$.requestData;

  console.log(props.modelName);

  try {
    const endpoint = props.isEditMode
      ? route(`admin.${props.resourceName}.update`, { [props.modelName]: props.itemId })
      : route(`admin.${props.resourceName}.store`);

    const method = props.isEditMode ? "put" : "post";

    router[method](endpoint, requestData, {
      preserveScroll: true,
      preserveState: true,
      onSuccess: () => {
        emit("formSubmitted");
        toast.success(
          props.isEditMode
            ? `${props.resourceName} updated successfully`
            : `${props.resourceName} created successfully`
        );

        const redirectRouteName = `admin.${props.resourceName}.index`;
        router.visit(route(redirectRouteName));
      },
      onError: (errors) => {
        emit("formError", errors);
        toast.error("Please fix the errors in the form");
      },
    });
  } catch (error) {
    toast.error("An unexpected error occurred");
    console.error(error);
  } finally {
    isSubmitting.value = false;
  }
};
</script>
