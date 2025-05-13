<template>
  <BreadcrumbAndPageTitle
    :pageTitle="
      (modelName || resourceName || '').charAt(0).toUpperCase() +
      (modelName || resourceName || '').slice(1)
    "
    :breadcrumbs="breadcrumbs"
    style="margin-bottom: 16px"
  />
  <DynamicDataTable
    ref="dataTableRef"
    :columns="columns"
    :resourceName="resourceName"
    :abilityName="abilityName"
    :modelName="modelName"
    :dataRoute="dataRoute"
    @create="openFormModal"
    @edit="openFormModal"
    @export="handleExport"
    @show-export-modal="handleShowExportModal"
  />
  <component
    :is="formModalComponent"
    :show="showFormModal"
    :selectedResource="selectedResource"
    @close="closeFormModal"
    @updated="refresh"
  />
  <!-- Export Modal -->
  <ExportModal
    :is-visible="showExportModal"
    :columns="columns"
    @close="showExportModal = false"
    @export="handleExport"
  />
</template>

<script setup>
import { ref, defineAsyncComponent, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import "vue3-toastify/dist/index.css";
import ExportModal from "@/backend/components/modals/ExportModal.vue";
import DynamicDataTable from "@/backend/components/dataTable/DataTable.vue";
import BreadcrumbAndPageTitle from "@backend-components/ui/breadcrumb-and-page-title.vue";
import useExport from "@/backend/composables/useExport";

const props = defineProps({
  resourceName: {
    type: String,
    required: true,
  },
  abilityName: {
    type: String,
    required: true,
  },
  modelName: {
    type: String,
    required: true,
  },
  dataRoute: {
    type: String,
    required: true,
  },
});

const { columns } = usePage().props;
const emit = defineEmits(["show-export-modal"]);

const dataTableRef = ref(null);
const showFormModal = ref(false);
const selectedResource = ref(null);
const showExportModal = ref(false);

console.log(props);

const { isExporting, handleExport } = useExport(props.resourceName);

const componentMap = {
  user: () => import("@/backend/pages/user/create-edit.vue"),
  permission: () => import("@/backend/pages/user-management/permissions/create-edit.vue"),
  country: () => import("@/backend/pages/locations/country/create-edit.vue"),
  state: () => import("@/backend/pages/locations/state/create-edit.vue"),
  city: () => import("@/backend/pages/locations/city/create-edit.vue"),
  activityLog: () => import("@/backend/pages/logs/activity-logs.vue"),
  propertyDeveloper: () =>
    import(
      "@Modules/Property/resources/js/components/property-developer/property-developer-form.vue"
    ),
};

const formModalComponent = computed(() => {
  const loadComponent = componentMap[props.modelName];
  if (loadComponent) {
    return defineAsyncComponent(loadComponent);
  } else {
    throw new Error(`Component for model ${props.modelName} not found`);
  }
});
const openFormModal = (resource = null) => {
  selectedResource.value = resource;
  showFormModal.value = true;
};

const closeFormModal = () => {
  showFormModal.value = false;
  selectedResource.value = null;
};

const handleShowExportModal = () => {
  showExportModal.value = true;
};
const refresh = () => {
  if (dataTableRef.value) {
    dataTableRef.value.refreshTable();
  }
  closeFormModal();
};
</script>

<script>
import BackendLayout from "@/layouts/backend-layout.vue";
export default {
  layout: BackendLayout,
};
</script>
