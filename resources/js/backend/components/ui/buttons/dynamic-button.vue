<!-- DynamicButton.vue -->
<template>
  <button
    :type="type"
    :disabled="processing"
    :class="buttonClasses"
    class="px-4 py-2 rounded-md transition-all duration-200 flex items-center justify-center space-x-2"
  >
    <span v-if="processing" class="animate-spin mr-2">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-5 w-5"
        viewBox="0 0 24 24"
        fill="none"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"
        />
      </svg>
    </span>
    {{ label }}
  </button>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  variant: {
    type: String,
    default: "primary",
    validator: (value) =>
      ["primary", "secondary", "success", "danger", "cancel"].includes(value),
  },
  type: {
    type: String,
    default: "button",
    validator: (value) => ["button", "submit", "reset"].includes(value),
  },
  processing: {
    type: Boolean,
    default: false,
  },
});

const buttonClasses = computed(() => {
  const baseClasses =
    "focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed";

  switch (props.variant) {
    case "primary":
      return `${baseClasses} bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md px-6 py-2`;
    case "secondary":
      return `${baseClasses} bg-gray-200 text-gray-800 hover:bg-gray-300 focus:ring-gray-500`;
    case "success":
      return `${baseClasses} bg-green-600 text-white hover:bg-green-700 focus:ring-green-500`;
    case "danger":
      return `${baseClasses} bg-red-600 text-white hover:bg-red-700 focus:ring-red-500`;
    case "cancel":
      return `${baseClasses} bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-gray-300`;
    default:
      return baseClasses;
  }
});
</script>
