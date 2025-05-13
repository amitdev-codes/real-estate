<!-- Primary/Success Button -->
<template>
  <button
    :disabled="processing"
    :class="[
      'btn flex items-center justify-center rounded-md px-6 py-2 text-white transition-all duration-300',
      variantClasses[variant],
      {
        'opacity-50 cursor-not-allowed': processing,
        'hover:opacity-90': !processing,
      },
    ]"
    @click="$emit('click')"
  >
    {{ label }}

    <!-- Loading Spinner -->
    <span v-if="processing" class="animate-spin ml-2">
      <svg
        class="w-5 h-5 text-white"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M12 4v1m0 14v1m8.486-9h-1M4.514 12H3.5M16.949 7.05l-.707.707M7.757 16.243l-.707.707M16.949 16.95l-.707-.707M7.757 7.757l-.707-.707"
        />
      </svg>
    </span>
  </button>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

const emit = defineEmits(["click"]);

const props = defineProps({
  label: {
    type: String,
    default: "Button",
  },
  processing: {
    type: Boolean,
    default: false,
  },
  variant: {
    type: String,
    default: "success",
    validator: (value) =>
      ["primary", "success", "danger", "info", "warning", "cancel"].includes(value),
  },
});

const variantClasses = {
  primary: "bg-blue-600 hover:bg-blue-700 border-blue-600 hover:border-blue-700",
  success: "bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700",
  danger: "bg-red-600 hover:bg-red-700 border-red-600 hover:border-red-700",
  info: "bg-blue-500 hover:bg-blue-600 border-blue-500 hover:border-blue-600",
  warning: "bg-yellow-600 hover:bg-yellow-700 border-yellow-600 hover:border-yellow-700",
  cancel: "bg-gray-500 hover:bg-gray-600 border-gray-500 hover:border-gray-600",
};
</script>
