<template>
  <div class="container mx-auto px-4 py-6 max-w-7xl">
    <div class="bg-white shadow-sm rounded-lg overflow-hidden dark:bg-gray-800">
      <!-- Breadcrumb -->
      <div class="px-6 py-3 bg-gray-50 border-b dark:bg-gray-700 dark:border-gray-600">
        <nav class="flex" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
              <Link
                :href="route('admin.dashboard')"
                class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
              >
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                  <path
                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                  />
                </svg>
                Dashboard
              </Link>
            </li>
            <li>
              <div class="flex items-center">
                <svg
                  class="w-6 h-6 text-gray-400"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd"
                  />
                </svg>
                <Link
                  :href="route('admin.systemLogs.index')"
                  class="ml-1 text-sm text-gray-500 hover:text-gray-700 md:ml-2 dark:text-gray-400 dark:hover:text-gray-300"
                >
                  System Logs
                </Link>
              </div>
            </li>
            <li aria-current="page">
              <div class="flex items-center">
                <svg
                  class="w-6 h-6 text-gray-400"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    fill-rule="evenodd"
                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                    clip-rule="evenodd"
                  />
                </svg>
                <span class="ml-1 text-sm text-gray-500 md:ml-2 dark:text-gray-400">
                  Log Details
                </span>
              </div>
            </li>
          </ol>
        </nav>
      </div>

      <!-- Header with Title and Back Button -->
      <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center">
          <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200">
            Log Details
          </h2>
          <Link
            :href="route('admin.systemLogs.index')"
            class="flex items-center px-3 py-2 text-sm text-gray-600 bg-gray-100 rounded-md hover:bg-gray-200 dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors"
          >
            <svg
              class="w-4 h-4 mr-2"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M10 19l-7-7m0 0l7-7m-7 7h18"
              />
            </svg>
            Back to Logs
          </Link>
        </div>
      </div>

      <!-- Log Content -->
      <div class="px-6 py-4">
        <div class="mb-6">
          <!-- Metadata Section -->
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <!-- Timestamp Card -->
            <div
              class="bg-gray-50 p-4 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600"
            >
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                Timestamp
              </h3>
              <p class="text-gray-900 dark:text-gray-300">{{ log.timestamp }}</p>
            </div>

            <!-- Level Card -->
            <div
              class="bg-gray-50 p-4 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600"
            >
              <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
                Level
              </h3>
              <span
                :class="getLevelClass(log.level)"
                class="px-3 py-1 text-sm font-medium rounded-full"
              >
                {{ log.level }}
              </span>
            </div>
          </div>

          <!-- Message Section -->
          <div
            class="bg-gray-50 p-4 rounded-lg border border-gray-200 dark:bg-gray-700 dark:border-gray-600"
          >
            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">
              Message
            </h3>
            <div class="bg-white rounded-lg p-4 dark:bg-gray-800">
              <pre
                class="whitespace-pre-wrap text-sm text-gray-900 dark:text-gray-300 font-mono"
                >{{ log.message }}</pre
              >
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
import { Link } from "@inertiajs/vue3";
import BackendLayout from "@/layouts/backend-layout.vue";

// Define props
const props = defineProps({
  log: {
    type: Object,
    required: true,
  },
});

// Define the log level styling function
const getLevelClass = (level) => {
  const classes = {
    ERROR: "bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200",
    WARNING: "bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200",
    INFO: "bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200",
    DEBUG: "bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200",
  };
  return (
    classes[level] || "bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200"
  );
};

// Create reactive reference to log data
const log = ref(props.log);
</script>

<script>
// Define the layout
export default {
  layout: BackendLayout,
};
</script>
