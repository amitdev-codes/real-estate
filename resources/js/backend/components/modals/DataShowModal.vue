<template>
    <div
      v-if="show"
      class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
    >
      <div class="w-full max-w-2xl mx-4 lg:mx-auto">
        <div
          class="bg-white shadow-xl rounded-2xl overflow-hidden text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
        >
          <!-- Header with title and close button -->
          <div class="flex justify-between items-center bg-gray-100 px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold">User Information</h2>
            <button
              @click="$emit('close')"
              class="text-gray-600 hover:text-gray-800 transition-colors"
            >
              &times; <!-- Close icon -->
            </button>
          </div>

          <div v-if="user" class="p-6 space-y-4">
            <div class="grid grid-cols-2 gap-4">

              <div
                v-for="(value, key) in displayColumns"
                :key="key"
                class="bg-white overflow-hidden flex items-center justify-between"
              >
                <strong class="text-gray-600 capitalize">
                  {{ formatLabel(key) }}:
                </strong>
                <div v-if="isHtmlContent(key)" v-html="value"></div>
                <span
                  v-else
                  class="px-3 py-1 rounded-full text-xs font-semibold"
                  :class="getValueBadgeClass(key, value)"
                >
                  {{ formatValue(value) }}
                </span>
              </div>

            </div>
          </div>

          <div v-else class="text-center text-gray-500 py-10">No user data available</div>

          <div
            class="bg-gray-50 px-6 py-4 flex justify-end items-center border-t border-gray-200 text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
          >
            <button
              @click="$emit('close')"
              class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>



<script setup>
import { computed } from "vue";

const props = defineProps({
  show: {
    type: Boolean,
    default: false,
  },
  user: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(["close"]);

const displayColumns = computed(() => {
  if (!props.user) return {};
  return Object.fromEntries(
    Object.entries(props.user).filter(([key]) => key !== "checkbox")
  );
});

// Helper function to determine if content is HTML
const isHtmlContent = (key) => {
  return ["status", "roles"].includes(key);
};

const formatLabel = (key) => {
  return key
    .split("_")
    .map((word) => word.charAt(0).toUpperCase() + word.slice(1))
    .join(" ");
};

const formatValue = (value) => {
  if (value === null || value === undefined) return "N/A";
  if (typeof value === "boolean") {
    return value ? "Active" : "Inactive";
  }
  if (
    value instanceof Date ||
    (typeof value === "string" && /^\d{4}-\d{2}-\d{2}/.test(value))
  ) {
    try {
      return new Date(value).toLocaleString();
    } catch {
      return value;
    }
  }
  return value.toString();
};

const getValueBadgeClass = (key, value) => {
  if (key === "status" || typeof value === "boolean") {
    return value ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800";
  }
  if (key === "role") {
    const roleColors = {
      admin: "bg-blue-100 text-blue-800",
      editor: "bg-yellow-100 text-yellow-800",
      user: "bg-gray-100 text-gray-800",
    };
    return roleColors[value.toLowerCase()] || "bg-gray-100 text-gray-800";
  }
  return "bg-gray-100 text-gray-800";
};
</script>
