

<template>
    <!-- <button class="btn-view text-green-600 hover:text-green-700 text-lg" data-id="1">
               <span class="mdi mdi-magnify text-lg top-[6px] start-3"></span>
    </button> -->
  <div v-if="isSearchVisible"
    class="w-full p-4 text-center mb-2 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-8 dark:bg-gray-800 dark:border-gray-700"
  >
    <h5 class="mb-2 text-2xl font-bold text-gray-400 dark:text-white">
      Search
    </h5>
    <div
      class="items-center justify-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4 rtl:space-x-reverse"
    >
      <div v-for="column in columns" :key="column.data">
        <div v-if="column.searchable" class="s">
            <Select2
            v-if="column.type === 'select'"
            v-model="column.searchValue"
            class="w-full custom-select2 full-width-select"
            :placeholder="`Search ${column.title}...`"
            :options="[
              { id: '', text: 'All' }, // 'All' option for resetting
              ...column.options.map((option) => ({
                id: option.id,
                text: option.name,
              })),
            ]"
            @update:model-value="handleSelectColumnSearch(column, $event)"
          />
          <input
            v-else-if="column.type === 'text'"
            type="text"
            @input="handleColumnSearch(column, $event.target.value)"
            class="dt-input"
            :placeholder="`Search ${column.title}`"
          />
        </div>
      </div>
    </div>
  </div>

  <div
    class="bg-white rounded-lg shadow-md p-4 md:p-6 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
  >
    <table
      ref="dataTableRef"
      class="min-w-full divide-y divide-gray-200 border-collapse rounded-lg overflow-hidden dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
    >
      <thead class="bg-gray-50">
        <tr
          class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal dark:bg-gray-700 dark:text-gray-200"
        >
          <th
            class="py-3 px-6 text-center w-12 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
          >
            <input
              type="checkbox"
              class="dt-select-checkbox form-checkbox text-green-500 rounded focus:ring-green-500"
              id="select-all-checkbox"
            />
          </th>
          <th
            v-for="column in columns"
            :key="column.data"
            class="px-6 py-3 text-center w-12 text-gray-500 uppercase tracking-wider dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
          >
            {{ column.title }}
          </th>
        </tr>
      </thead>
      <tbody
        class="bg-white divide-y divide-gray-200 text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
      >
        <!-- Rows will be populated by DataTables -->
      </tbody>

      <!-- <tfoot
                class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal dark:bg-gray-700 dark:text-gray-200"
            >
                <tr>
                    <th
                        class="py-3 px-6 text-center w-12 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
                    ></th>
                    <th
                        v-for="column in columns"
                        :key="column.data"
                        class="py-2 px-4 text-left dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 relative"
                    >
                        <div v-if="column.searchable" class="s">
                            <Select2
                                v-if="column.type === 'select'"
                                v-model="column.searchValue"
                                class="w-full custom-select2 full-width-select"
                                :placeholder="`Search ${column.title}...`"
                                :options="[
                                    { id: '', text: 'All' }, // 'All' option for resetting
                                    ...column.options.map((option) => ({
                                        id: option.id,
                                        text: option.name,
                                    })),
                                ]"
                                @update:model-value="
                                    handleSelectColumnSearch(column, $event)
                                "
                            />
                            <input
                                v-else-if="column.type === 'text'"
                                type="text"
                                @input="
                                    handleColumnSearch(
                                        column,
                                        $event.target.value
                                    )
                                "
                                class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-green-300 focus:outline-none text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600'"
                                :placeholder="`Search ${column.title}`"
                            />
                        </div>
                    </th>
                    <th></th>
                </tr>
            </tfoot> -->
    </table>

    <UserViewModal
      :show="showViewModal"
      :user="selectedUser"
      @close="closeViewModal"
      @updated="refreshTable"
    />
  </div>
</template>

<script setup>
import {
  ref,
  defineProps,
  defineEmits,
  onMounted,
  onUnmounted,
  watch,
} from "vue";
import UserViewModal from "@/backend/components/modals/DataShowModal.vue";
import { useDelete } from "@/utils/delete";
import { initializeDataTable } from "./datatable-config";
import { createActionHandlers } from "./datatable-utils";
import "./datatable-styles.css";
import Select2 from "vue3-select2-component";
import axios from "axios";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const props = defineProps({
  columns: { type: Array, required: true },
  dataRoute: { type: String, required: true },
  resourceName: { type: String, required: true },
  modelName: { type: String, required: true },
  permissions: { type: Object, required: true },
  abilityName: { type: String, required: true },
});

const emit = defineEmits(["create", "edit", "export", "show-export-modal"]);

const dataTableRef = ref(null);
const tableInstance = ref(null);
const showViewModal = ref(false);
const selectedUser = ref(null);
const isExporting = ref(false);
const isSearchVisible = ref(false);

// Toggle function
const toggleSearch = () => {
    isSearchVisible.value = !isSearchVisible.value;
};

// Action Handlers
const { deleteRow, bulkDelete } = useDelete();
const handleView = (data) => {
  selectedUser.value = data;
  showViewModal.value = true;
};

const handleBulkDelete = (selectedRows) => {
  bulkDelete(
    `admin.bulkDelete`,
    props.modelName,
    selectedRows,
    () => refreshTable(),
    () => refreshTable()
  );
};

const handleDelete = (id) => {
  deleteRow(
    `admin.${props.resourceName}.destroy`,
    id,
    () => refreshTable(),
    () => refreshTable()
  );
};

const closeViewModal = () => {
  if (showViewModal && selectedUser) {
    showViewModal.value = false;
    selectedUser.value = null;
  } else {
    console.error(
      "closeViewModal: showViewModal or selectedUser is not defined"
    );
  }
};

const refreshTable = () => {
  tableInstance.value.ajax.reload();
};

// Column Search Handler
const handleColumnSearch = (column, value) => {
  if (tableInstance.value) {
    const columnIndex = props.columns.findIndex(
      (col) => col.data === column.data
    );
    if (columnIndex !== -1) {
      tableInstance.value
        .column(columnIndex + 1)
        .search(value)
        .draw();
    }
  }
};
const handleSelectColumnSearch = (column, value) => {
  if (tableInstance.value) {
    const columnIndex = props.columns.findIndex(
      (col) => col.data === column.data
    );

    if (columnIndex !== -1) {
      // If value is empty string (All), clear the search
      if (value === "") {
        tableInstance.value
          .column(columnIndex + 1)
          .search("")
          .draw();
      } else {
        tableInstance.value
          .column(columnIndex + 1)
          .search(value, { exact: true })
          .draw();
      }
    }
  }
};

const initTable = () => {
  tableInstance.value = initializeDataTable(
    dataTableRef.value,
    props,
    emit,
    handleBulkDelete
  );

  const { unbindActionHandlers } = createActionHandlers(
    tableInstance.value,
    props,
    emit,
    handleView,
    handleDelete,
    dataTableRef
  );

  return {
    unbindActionHandlers, // Return unbind function for cleanup
  };
};

const handleExport = async (exportConfig) => {
  isExporting.value = true;

  try {
    const response = await axios.post(
      props.resourceName + "/export",
      {
        type: {
          type: exportConfig.type,
          range: exportConfig.range,
          columns: exportConfig.columns,
          start: exportConfig.start,
          end: exportConfig.end,
        },
      },
      {
        responseType:
          exportConfig.type === "copy" || exportConfig.type === "print"
            ? "json"
            : "blob",
      }
    );

    // Handle copy and print differently
    if (exportConfig.type === "copy" || exportConfig.type === "print") {
      if (exportConfig.type === "copy") {
        await navigator.clipboard.writeText(
          JSON.stringify(response.data.data, null, 2)
        );
        toast.success("Data copied to clipboard!");
      } else {
        // Handle print
        const printWindow = window.open("", "_blank");
        printWindow.document.write(`
          <html>
            <head>
              <title>Print Data</title>
              <style>
                table {
                  border-collapse: collapse;
                  width: 100%;
                  margin-bottom: 20px;
                }
                th, td {
                  border: 1px solid #ddd;
                  padding: 12px 8px;
                  text-align: left;
                }
                th {
                  background-color: #f2f2f2;
                  font-weight: bold;
                }
                tr:nth-child(even) {
                  background-color: #f9f9f9;
                }
              </style>
            </head>
            <body>
              <table>
                <thead>
                  <tr>
                    ${Object.keys(response.data.data[0])
                      .map((header) => `<th>${header}</th>`)
                      .join("")}
                  </tr>
                </thead>
                <tbody>
                  ${response.data.data
                    .map(
                      (row) => `
                    <tr>
                      ${Object.values(row)
                        .map((cell) => `<td>${cell || ""}</td>`)
                        .join("")}
                    </tr>
                  `
                    )
                    .join("")}
                </tbody>
              </table>
            </body>
          </html>
        `);
        printWindow.document.close();
        printWindow.print();
      }
    } else {
      // Handle file downloads (Excel, CSV, PDF)
      const contentTypes = {
        excel:
          "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        csv: "text/csv",
        pdf: "application/pdf",
      };

      const blob = new Blob([response.data], {
        type: contentTypes[exportConfig.type],
      });

      const url = window.URL.createObjectURL(blob);
      const link = document.createElement("a");
      link.href = url;
      link.setAttribute(
        "download",
        `export-${Date.now()}.${
          exportConfig.type === "excel" ? "xlsx" : exportConfig.type
        }`
      );
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
      window.URL.revokeObjectURL(url);

      toast.success(
        `${exportConfig.type.toUpperCase()} exported successfully!`
      );
    }
  } catch (error) {
    console.error("Export failed:", error);
    toast.error(
      error.response?.data?.message || "Export failed. Please try again."
    );
  } finally {
    isExporting.value = false;
  }
};

let unbindActions;

onMounted(() => {
  const { unbindActionHandlers } = initTable();
  window.unbindActions = unbindActionHandlers;

  const button = document.getElementById('toggleSearchBtn');
      if (button) {
        button.addEventListener('click', toggleSearch);
      }
});

onUnmounted(() => {
  if (window.unbindActions) {
    window.unbindActions(); // Call the unbind function
  }
});

watch(
  () => props.dataRoute,
  () => {
    // Reinitialize table if data route changes
    if (unbindActions) {
      unbindActions();
    }
    unbindActions = initTable();
  }
);

defineExpose({ refreshTable });
</script>

<style>
</style>
