<template>
  <div class="flex items-center justify-between border-b pb-4">
    <h3
      class="text-xl font-semibold text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
    >
      Permissions Management
    </h3>

    <!-- Replace checkbox with Toggle Switch -->
    <div class="flex items-center space-x-3">
      <span
        class="text-sm font-medium text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
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
  </div>

  <!-- Permissions Table -->
  <div class="overflow-x-auto rounded-lg border border-gray-200">
    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
      <thead
        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
      >
        <tr>
          <th scope="col" class="px-6 py-3">Resource Name</th>
          <th scope="col" class="px-6 py-3 text-center">
            <span class="text-blue-500">View</span>
          </th>
          <th scope="col" class="px-6 py-3 text-center">
            <span class="text-green-500">Create</span>
          </th>
          <th scope="col" class="px-6 py-3 text-center">
            <span class="text-yellow-500">Edit</span>
          </th>
          <th scope="col" class="px-6 py-3 text-center">
            <span class="text-red-500">Delete</span>
          </th>
        </tr>
      </thead>
      <tbody>
        <!-- Vertical Select Row -->
        <tr
          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50"
        >
          <td></td>
          <td class="px-6 py-4 text-center">
            <input
              type="checkbox"
              @change="toggleVerticalSelect('view')"
              :checked="areAllInColumnSelected('view')"
              class="h-4 w-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
            />
          </td>
          <td class="px-6 py-4 text-center">
            <input
              type="checkbox"
              @change="toggleVerticalSelect('create')"
              :checked="areAllInColumnSelected('create')"
              class="h-4 w-4 text-green-600 bg-gray-100 rounded border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
            />
          </td>
          <td class="px-6 py-4 text-center">
            <input
              type="checkbox"
              @change="toggleVerticalSelect('edit')"
              :checked="areAllInColumnSelected('edit')"
              class="h-4 w-4 text-yellow-600 bg-gray-100 rounded border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
            />
          </td>
          <td class="px-6 py-4 text-center">
            <input
              type="checkbox"
              @change="toggleVerticalSelect('delete')"
              :checked="areAllInColumnSelected('delete')"
              class="h-4 w-4 text-red-600 bg-gray-100 rounded border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
            />
          </td>
        </tr>

        <!-- Resource Rows -->
        <tr
          v-for="resource in resources"
          :key="resource"
          class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50"
        >
          <td class="px-6 py-4 font-medium text-gray-900 dark:text-white capitalize">
            {{ resource }}
          </td>
          <td class="px-6 py-4 text-center">
            <input
              type="checkbox"
              :value="'view ' + resource"
              v-model="selectedPermissions"
              class="h-4 w-4 text-blue-600 bg-gray-100 rounded border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
            />
          </td>
          <td class="px-6 py-4 text-center">
            <input
              type="checkbox"
              :value="'create ' + resource"
              v-model="selectedPermissions"
              class="h-4 w-4 text-green-600 bg-gray-100 rounded border-gray-300 focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
            />
          </td>
          <td class="px-6 py-4 text-center">
            <input
              type="checkbox"
              :value="'edit ' + resource"
              v-model="selectedPermissions"
              class="h-4 w-4 text-yellow-600 bg-gray-100 rounded border-gray-300 focus:ring-yellow-500 dark:focus:ring-yellow-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
            />
          </td>
          <td class="px-6 py-4 text-center">
            <input
              type="checkbox"
              :value="'delete ' + resource"
              v-model="selectedPermissions"
              class="h-4 w-4 text-red-600 bg-gray-100 rounded border-gray-300 focus:ring-red-500 dark:focus:ring-red-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
            />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, computed, watch } from "vue";

// Props
const props = defineProps({
  permissions: {
    type: Array,
    required: true,
  },
  modelValue: {
    type: Array,
    default: () => [],
  },
});
const emit = defineEmits(["update:modelValue"]);

// Extract resources from permissions
const allPermissions = ref(props.permissions);
const resources = computed(() => {
  const resourceSet = new Set();
  allPermissions.value.forEach((permission) => {
    const parts = permission.name.split(" ");
    if (parts.length > 1) {
      resourceSet.add(parts.slice(1).join(" "));
    }
  });
  return Array.from(resourceSet);
});

// Reactive state
const selectedPermissions = ref([...props.modelValue]);
const selectAll = ref(false);

// Watch changes to selectedPermissions and emit updates to parent
watch(selectedPermissions, (newValue) => {
  const allPossiblePermissions = resources.value.flatMap((resource) => [
    `view ${resource}`,
    `create ${resource}`,
    `edit ${resource}`,
    `delete ${resource}`,
  ]);
  selectAll.value = newValue.length === allPossiblePermissions.length;
  emit("update:modelValue", newValue);
});

// Toggle all permissions
const toggleSelectAll = () => {
  if (selectAll.value) {
    selectedPermissions.value = resources.value.flatMap((resource) => [
      `view ${resource}`,
      `create ${resource}`,
      `edit ${resource}`,
      `delete ${resource}`,
    ]);
  } else {
    selectedPermissions.value = [];
  }
};

// Toggle vertical selection
const toggleVerticalSelect = (action) => {
  const actionPermissions = resources.value.map((resource) => `${action} ${resource}`);
  if (areAllInColumnSelected(action)) {
    selectedPermissions.value = selectedPermissions.value.filter(
      (permission) => !actionPermissions.includes(permission)
    );
  } else {
    selectedPermissions.value = [
      ...new Set([...selectedPermissions.value, ...actionPermissions]),
    ];
  }
};

// Check if all permissions in a column are selected
const areAllInColumnSelected = (action) => {
  const actionPermissions = resources.value.map((resource) => `${action} ${resource}`);
  return actionPermissions.every((permission) =>
    selectedPermissions.value.includes(permission)
  );
};
</script>

<style scoped>
.table-auto {
  min-width: 600px;
}
.permissions-box {
  max-height: 200px;
  overflow-y: auto;
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
  gap: 10px;
}

.permission-item {
  display: flex;
  align-items: center;
}
input[type="checkbox"] {
  visibility: visible !important;
  appearance: auto !important;
}
</style>
