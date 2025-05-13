<template>
  <div
    v-if="isVisible"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
  >
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-6 w-1/2">
      <h2 class="text-xl font-semibold mb-4 dark:text-gray-200">Export Options</h2>
      <div class="mb-4">
        <Select
          v-model="selectedExportType"
          :options="exportTypes"
          label="Select Export Types"
          placeholder="Choose an Export type"
          valueKey="id"
          labelKey="name"
        />
      </div>
      <div class="mb-4">
        <Select
          v-model="customRange"
          :options="predefinedRanges"
          label="Rows to Export"
          placeholder="Choose Rows to Export"
          valueKey="id"
          labelKey="name"
        />
      </div>
      <!-- Conditional Custom Range Input -->
      <div v-if="customRange === 'custom'" class="mb-4">
        <label class="block text-md font-medium text-gray-700 dark:text-gray-300 mb-2">
          Enter Custom Range
        </label>
        <div class="flex space-x-6">
          <TextInput
            v-model="customStartRange"
            type="number"
            label="Start"
            id="start-range"
            placeholder="Start"
          />
          <TextInput
            v-model="customEndRange"
            type="number"
            label="End"
            id="end-range"
            placeholder="End"
          />
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-md font-medium text-gray-700 dark:text-gray-300 mb-2">
          Select Columns to Export
        </label>

        <div class="flex items-center space-x-3 mb-4">
          <span
            class="text-sm font-medium text-gray-600 dark:bg-gray-700 dark:text-gray-200"
            >Select All</span
          >
          <label class="inline-flex relative items-center cursor-pointer">
            <input
              type="checkbox"
              class="sr-only peer"
              v-model="selectAll"
              @change="toggleSelectAll"
            />
            <div
              class="w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"
            ></div>
          </label>
        </div>

        <div
          class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 max-h-40 overflow-y-auto"
        >
          <div
            v-for="(column, index) in exportableColumns"
            :key="index"
            class="flex items-center"
          >
            <input
              type="checkbox"
              :id="`column-${index}`"
              :value="column.data"
              v-model="selectedColumns"
              class="mr-2 dark:bg-gray-700 dark:border-gray-600"
            />
            <label :for="`column-${index}`" class="dark:text-gray-200">
              {{ column.title }}
            </label>
          </div>
        </div>
      </div>

      <div class="flex justify-end space-x-2">
        <DynamicButton label="Cancel" variant="cancel" @click="closeModal" />
        <DynamicButton
          label="Export"
          variant="success"
          :processing="isSubmitting"
          @click="performExport"
        />
      </div>
    </div>
  </div>
  <div>
    <!-- Loading Overlay -->
    <Transition name="fade">
      <div
        v-if="isExporting"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
      >
        <div class="bg-white p-6 rounded-lg shadow-lg flex items-center gap-3">
          <div
            class="animate-spin rounded-full h-6 w-6 border-4 border-gray-300 border-t-green-500"
          ></div>
          <span class="text-gray-700">Exporting...</span>
        </div>
      </div>
    </Transition>
  </div>
</template>
<script setup>
import { ref, defineProps, defineEmits, computed, watch } from "vue";
import Select from "@/backend/components/ui/inputs/Select.vue";
import TextInput from "@/backend/components/ui/inputs/TextInput.vue";
import DynamicButton from "@/backend/components/ui/buttons/SuccessButton.vue";

const props = defineProps({
  isVisible: Boolean,
  columns: {
    type: Array,
    required: true,
  },
});

const emit = defineEmits(["close", "export"]);

const selectedExportType = ref("excel");
const customRange = ref(null);
const customStartRange = ref(null);
const customEndRange = ref(null);
const selectedColumns = ref([]);
const selectAll = ref(false);

// Define available export types
const exportTypes = [
  { id: "copy", name: "Copy" },
  { id: "csv", name: "CSV" },
  { id: "excel", name: "Excel" },
  { id: "pdf", name: "PDF" },
  { id: "print", name: "Print" },
];
const predefinedRanges = [
  { id: "current", name: "Current" },
  { id: "all", name: "All" },
  { id: "custom", name: "Custom Records" },
];

// Filter out non-exportable columns (like checkbox or action columns)
const exportableColumns = computed(() =>
  props.columns.filter(
    (column) =>
      column.data !== "" && column.data !== "checkbox" && column.data !== "actions"
  )
);

// Watch for changes in selectedColumns to update selectAll
watch(selectedColumns, () => {
  selectAll.value = selectedColumns.value.length === exportableColumns.value.length;
});

// Function to toggle select all
const toggleSelectAll = () => {
  if (selectAll.value) {
    selectedColumns.value = exportableColumns.value.map((column) => column.data);
  } else {
    selectedColumns.value = [];
  }
};

const closeModal = () => {
  selectedExportType.value = "excel";
  customRange.value = "current";
  customStartRange.value = null;
  customEndRange.value = null;
  selectedColumns.value = [];
  selectAll.value = false;

  emit("close");
};

const performExport = () => {
  let rangeConfig = {};
  if (customRange.value === "custom") {
    // Ensure both start and end ranges are provided
    if (customStartRange.value === null || customEndRange.value === null) {
      alert("Please enter a valid start and end range.");
      return;
    }

    rangeConfig = {
      range: customRange.value,
      start: customStartRange.value,
      end: customEndRange.value,
    };
  } else {
    rangeConfig = {
      range: customRange.value,
    };
  }

  const exportConfig = {
    type: selectedExportType.value,
    ...rangeConfig,
    columns:
      selectedColumns.value.length > 0
        ? selectedColumns.value
        : exportableColumns.value.map((col) => col.data),
  };

  emit("export", exportConfig);
  closeModal();
};
</script>

<style scoped>
input[type="checkbox"] {
  visibility: visible !important;
  appearance: auto !important;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
