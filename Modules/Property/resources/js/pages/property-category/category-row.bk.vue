<!--
<template>
  <tr :class="{ 'bg-gray-100 dark:bg-gray-800': isSelected }">
    <td
      class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3"
    >
      <span class="text-slate-400">
        <i :class="'mdi mdi-' + category.icon" v-if="category.icon"></i>
      </span>
    </td>

    <td
      class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3"
    >
      <span
        class="text-slate-400 hover:text-green-600 cursor-pointer"
        v-on:click="selectCategory(category)"
        :class="{ 'text-red-600': isSelected }"
      >
        {{ category.name }}
      </span>
    </td>

    <td
      class="text-end border-t border-gray-100 dark:border-gray-800 px-4 py-3"
    >
      <SuccessBadge v-if="category.is_active" :label="'Active'" />
      <DangerBadge v-else :label="'Inactive'" />
    </td>

    <td
      class="text-center border-t border-gray-100 dark:border-gray-800 px-4 py-3 justify-between"
    >
      <Link
        v-if="isSelected"
        :href="route('admin.property-categories.destroy', category.id)"
        method="delete"
        as="button"
        class="text-red-500"
      >
        <i class="mdi mdi-delete font-normal"></i>
      </Link>
    </td>
  </tr>

  <tr v-if="category.children && category.children.length">
    <td colspan="4">
      <CategoryTree
        :categories="category.children"
        :selectedCategory="selectedCategory"
        @selectCategory="selectCategory"
        :style="{ paddingLeft: category.level * 20 + 'px' }"
      />
    </td>
  </tr>
</template>

  <script setup>
import { ref, computed } from "vue";
import SuccessBadge from "@backend-components/ui/badges/success-badge.vue";
import DangerBadge from "@backend-components/ui/badges/danger-badge.vue";
import CategoryTree from "./property-category-tree.vue"; // Recursive child

const props = defineProps({
  category: Object,
  selectedCategory: Object,
});

const emit = defineEmits(["selectCategory"]);

// This will check if the category is selected
const isSelected = computed(() => {
  return (
    props.selectedCategory && props.selectedCategory.id === props.category.id
  );
});

// Emit event to select the category
const selectCategory = (category) => {
  emit("selectCategory", category);
};
</script>

  <style lang="scss" scoped>
</style>
-->

<template>
    <tr :class="{ 'bg-gray-100 dark:bg-gray-800': isSelected }" :style="{ background: level == 1 ? '#f3f4f6' : '' }">
      <td
        class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3"
      >
        <span class="text-slate-400">
          <i :class="'mdi mdi-' + category.icon" v-if="category.icon"></i>
        </span>
      </td>

      <td
      :class="'text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3'"
      :style="{ paddingLeft: (paddingLeft * 5) + 'px !important' }"
      >
        <span
          :data-parent-id="category.id"
          :data-has-children="isSelected"
          class="text-slate-400 hover:text-green-600 cursor-pointer"
          v-on:click="editCategory(category)"
          :class="{ 'text-red-600': isSelected }"
        >
          <!-- Add prefix before category name -->
         {{ prefix }} {{ category.name }}
        </span>
      </td>

      <td
        :class="'text-end border-t border-gray-100 dark:border-gray-800 px-4 py-3 pl-'"
      >
        <SuccessBadge v-if="category.is_active" :label="'Active'" />
        <DangerBadge v-else :label="'Inactive'" />
      </td>

      <td
        class="text-center border-t border-gray-100 dark:border-gray-800 px-4 py-3 justify-between"
      >
        <Link
          v-if="isSelected"
          :href="route('admin.property-categories.destroy', category.id)"
          method="delete"
          as="button"
          class="text-red-500"
        >
          <i class="mdi mdi-delete font-normal"></i>
        </Link>
      </td>
    </tr>

    <!-- Recursive rendering of child categories with indentation -->
    <template v-if="category.children && category.children.length">
      <CategoryTree
          :categories="category.children"
          :key="category.children.id"
          :prefix="prefix + '-'"
          :level="level"
          :selectedCategory="selectedCategory"
          @selectCategory="selectCategory"
          @editCategory="editCategory"
        />
    </template>

  </template>

    <script setup>
  import { ref, computed } from "vue";
  import SuccessBadge from "@backend-components/ui/badges/success-badge.vue";
  import DangerBadge from "@backend-components/ui/badges/danger-badge.vue";
  import CategoryTree from "./property-category-tree.vue"; // Recursive child

  const props = defineProps({
    category: Object,
    selectedCategory: Object,
    prefix: String, // Add prefix as a prop
    level: Number, // Add level as a prop
  });

  const emit = defineEmits(["selectCategory", "editCategory"]);

  console.log('Current level:', props.level);

  const isSelected = computed(() => {
    return (
      props.selectedCategory && props.selectedCategory.id === props.category.id
    );
  });

  const paddingLeft = computed(() => {
    switch (props.level) {
      case 1:
        return '0';
      case 2:
        return '4';
      case 3:
        return '8';
      default:
        return '0';
    }
  });

  const selectCategory = (category) => {
      console.log('Selected category:', category);
    emit("selectCategory", category);
  };

  const editCategory = (category) => {
      console.log('Edit category:', category);
    emit("editCategory", category);
  };

  </script>

    <style lang="scss" scoped>
  </style>
