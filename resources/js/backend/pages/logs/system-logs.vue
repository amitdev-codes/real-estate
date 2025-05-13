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
          </ol>
        </nav>
      </div>
      <!-- Header Section with improved flexbox layout -->
      <div class="px-6 py-4 bg-gray-50 border-b dark:bg-gray-700 dark:border-gray-600">
        <div class="flex items-center">
          <!-- Left section with title -->
          <div class="min-w-[200px]">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">
              System Logs
            </h2>
          </div>

          <!-- Center section with date select and proper margin -->
          <div class="flex-1 flex justify-center">
            <select
              id="date-select"
              v-model="selectedDate"
              @change="fetchLogs"
              class="w-48 bg-white border border-gray-300 text-gray-700 py-1.5 px-3 rounded-md text-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200"
            >
              <option value="" disabled>Select date</option>
              <option v-for="file in logFiles" :key="file.date" :value="file.date">
                {{ file.date }}
              </option>
            </select>
          </div>

          <!-- Right section with back button -->
          <div class="min-w-[200px] flex justify-end">
            <button
              @click="handleGoBack"
              class="flex items-center px-3 py-1.5 text-sm text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-md transition-colors dark:text-gray-300 dark:hover:text-gray-100 dark:hover:bg-gray-600"
            >
              <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4 mr-1.5"
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
              </svg>
              Back
            </button>
          </div>
        </div>
      </div>

      <!-- Table Section with text wrapping -->
      <div class="px-6 py-4">
        <div class="rounded-lg overflow-x-auto">
          <table class="w-full table-fixed">
            <thead>
              <tr class="bg-gray-50 dark:bg-gray-700">
                <th
                  class="w-[180px] py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300"
                >
                  Timestamp
                </th>
                <th
                  class="w-[120px] py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300"
                >
                  Level
                </th>
                <th
                  class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300"
                >
                  Message
                </th>
                <th
                  class="w-[100px] py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300"
                >
                  Action
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
              <tr
                v-for="(log, index) in logs"
                :key="index"
                class="hover:bg-gray-50 dark:hover:bg-gray-700"
              >
                <td
                  class="py-2 px-4 text-sm text-gray-600 dark:text-gray-300 whitespace-nowrap"
                >
                  {{ log.timestamp || selectedDate }}
                </td>
                <td class="py-2 px-4">
                  <span
                    :class="getLevelClass(log.level)"
                    class="px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap"
                  >
                    {{ log.level || "normal" }}
                  </span>
                </td>
                <td class="py-2 px-4 text-sm text-gray-600 dark:text-gray-300">
                  <div class="break-words line-clamp-2">
                    {{ log.message }}
                  </div>
                </td>
                <td class="py-2 px-4">
                  <button
                    @click="viewLog(log)"
                    class="inline-flex items-center px-2 py-1 text-sm text-blue-600 hover:text-yellow-700 dark:text-green-400 dark:hover:text-yellow-300"
                  >
                    <svg
                      xmlns="http://www.w3.org/2000/svg"
                      class="h-4 w-4 mr-1"
                      fill="none"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                      />
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                      />
                    </svg>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Pagination Section -->
      <div class="px-6 py-3 border-t border-gray-200 dark:border-gray-700">
        <div class="flex items-center justify-between">
          <button
            @click="prevPage"
            :disabled="pagination.current_page === 1"
            class="px-3 py-1.5 text-sm border rounded-md disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700"
            :class="
              pagination.current_page === 1
                ? 'text-gray-400'
                : 'text-gray-600 dark:text-gray-300'
            "
          >
            Previous
          </button>

          <div class="hidden sm:flex items-center gap-2">
            <button
              v-for="page in Math.min(pagination.last_page, 10)"
              :key="page"
              @click="gotoPage(page)"
              class="px-3 py-1.5 text-sm rounded-md"
              :class="
                page === pagination.current_page
                  ? 'bg-green-600 hover:bg-yellow-600 text-white'
                  : 'text-gray-600 hover:bg-yellow-600 dark:text-gray-300 dark:hover:bg-gray-700'
              "
            >
              {{ page }}
            </button>
          </div>

          <button
            @click="nextPage"
            :disabled="pagination.current_page === pagination.last_page"
            class="px-3 py-1.5 text-sm border rounded-md disabled:opacity-50 disabled:cursor-not-allowed hover:bg-gray-50 dark:border-gray-600 dark:hover:bg-gray-700"
            :class="
              pagination.current_page === pagination.last_page
                ? 'text-gray-400'
                : 'text-gray-600 dark:text-gray-300'
            "
          >
            Next
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import BackendLayout from "@/layouts/backend-layout.vue";

const props = defineProps({
  logs: Array,
  logFiles: Array,
  selectedDate: String,
  pagination: Object,
});

const logs = ref(props.logs);
const logFiles = ref(props.logFiles);
const selectedDate = ref(props.selectedDate);
const pagination = ref(props.pagination);
const currentDate = ref(new Date().toISOString().split("T")[0]);

const fetchLogs = (page) => {
  const currentPage = pagination.value?.current_page || 1;
  router.get(
    route("admin.systemLogs.index"),
    {
      date: selectedDate.value,
      page: page || currentPage,
    },
    {
      preserveState: true,
      preserveScroll: true,
      onSuccess: (page) => {
        logs.value = page.props.logs;
        pagination.value = page.props.pagination;
      },
    }
  );
};

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

const viewLog = (log) => {
  router.get(route("admin.systemLogs.show"), {
    data: {
      date: selectedDate.value,
      timestamp: log.timestamp,
      message: log.message,
    },
  });
};

const prevPage = () => {
  if (pagination.value.current_page > 1) {
    gotoPage(pagination.value.current_page - 1);
  }
};

const nextPage = () => {
  if (pagination.value.current_page < pagination.value.last_page) {
    gotoPage(pagination.value.current_page + 1);
  }
};

const gotoPage = (page) => {
  fetchLogs(page);
};

const handleGoBack = () => {
  router.visit(route(props.redirectRoute || "admin.systemLogs.index"));
};
</script>

<script>
export default {
  layout: BackendLayout,
};
</script>
