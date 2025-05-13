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
    @create="openForm"
    @edit="openForm"
    :redirectRoute="redirectRoute"
    @export="handleExport"
    @show-export-modal="handleShowExportModal"
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
import { ref } from "vue";
import { router, usePage } from "@inertiajs/vue3";
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

const pageProps = usePage().props;

const { columns } = usePage().props;
const emit = defineEmits(["show-export-modal"]);

const dataTableRef = ref(null);
const showExportModal = ref(false);

const { isExporting, handleExport } = useExport(props.resourceName);
const role = pageProps.auth.user.role.toLowerCase();
const resolveRoutePrefix = (role) => {
  return role === "superadmin" ? "admin" : role.toLowerCase();
};
const prefix = resolveRoutePrefix(role);

const openForm = (modelName = null) => {
  router.get(
    modelName && modelName.id
      ? route(`${prefix}.${props.resourceName}.edit`, { id: modelName.id })
      : route(`${prefix}.${props.resourceName}.create`)
  );
};

const handleShowExportModal = () => {
  showExportModal.value = true;
};
</script>

<script>
import BackendLayout from "@/layouts/backend-layout.vue";

export default {
  layout: BackendLayout,
};
</script>
