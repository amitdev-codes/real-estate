
<template>
  <tr
    :class="{ 'bg-gray-100 dark:bg-gray-800': isSelected }"
    :style="{ background: level == 1 ? '#f3f4f6' : '' }"
  >
    <td
      class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3"
    >
      <span class="text-slate-400">
        <i :class="'mdi mdi-' + category.icon" v-if="category.icon"></i>
      </span>
    </td>

    <td
      :class="'text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3'"
      :style="{ paddingLeft: paddingLeft * 5 + 'px !important' }"
    >
      <span
        :data-parent-id="category.id"
        :data-level="level"
        class="text-slate-400 hover:text-green-600 cursor-pointer"
        v-on:click="editCategory(category)"
        :class="{ 'text-red-600': isSelected }"
      >
        <!-- Add prefix before category name -->
        {{ prefix }} {{ category.name }} {{ suffix }} <br />
      </span>
      <template v-if="category.children && category.children.length">
        <span
          v-for="(child, index) in category.children"
          :key="child.id"
          class="text-green-600 cursor-default"
        >
          {{ child.name }}
          <span v-if="index !== category.children.length - 1">, </span>
        </span>
      </template>

      <!-- <template v-if="category.children && category.children.length">
        <div>
          <div class="children-categories" style="padding-left: 20px">
            <div
              v-for="child in category.children"
              :key="child.id"
              class="child-category"
            >
              - {{ child.name }}
            </div>
          </div>
        </div>
      </template> -->

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
      <!-- <Link
        v-if="isSelected"
        href="#"
        as="button"
        class="text-red-500"
        @click.prevent="handleDelete(category.id)"
      >
        <i class="mdi mdi-delete font-normal"></i>
      </Link> -->
      <button v-if="isSelected"
            @click.prevent="handleDelete(category.id)" class="text-red-500" >
            <i class="mdi mdi-delete font-normal"></i>
      </button>
    </td>
  </tr>

  <!-- Recursive rendering of child categories with indentation -->
  <!-- <template v-if="category && category.children.length">
    <CategoryTree
        :categories="category.children"
        :key="category.children.id"
        :prefix="prefix + '-'"
        :level="level"
        :selectedCategory="selectedCategory"
        @selectCategory="selectCategory"
        @editCategory="editCategory"
      />
  </template> -->
  <template v-if="category && category.length">
    <CategoryTree
      v-for="category in categories"
      :key="category.id"
      :category="category"
      :suffix="suffix"
      :level="level"
      :selected-category="selectedCategory"
      @selectCategory="setSelectedCategory"
    />
  </template>
</template>

  <script setup>
import { ref, computed } from "vue";
import SuccessBadge from "@backend-components/ui/badges/success-badge.vue";
import DangerBadge from "@backend-components/ui/badges/danger-badge.vue";
import CategoryTree from "./property-category-tree.vue";
import { useDelete } from "@/utils/delete";

const props = defineProps({
  categories:Array,
  category: Object,
  selectedCategory: Object,
  prefix: String, // Add prefix as a prop
  level: Number, // Add level as a prop
});

const selectedCategory = ref(null);

const emit = defineEmits(["selectCategory", "editCategory","updateCategories"]);

console.log("Current level:", props.level);
// console.log('Current level:', props.category.children);

const isSelected = computed(() => {
  return (
    props.selectedCategory && props.selectedCategory.id === props.category.id
  );
});

const level = computed(() => {
  return props.category.children.length ? 1 : 0;
});

const suffix = computed(() => {
  return props.category.children.length ? ">>" : "";
});

const paddingLeft = computed(() => {
  switch (props.level) {
    case 1:
      return "0";
    case 2:
      return "4";
    case 3:
      return "8";
    default:
      return "0";
  }
});

const selectCategory = (category) => {
  console.log("Selected category:", category);
  emit("selectCategory", category);
};

const editCategory = (category) => {
  console.log("Edit category:", category);
  emit("editCategory", category);
};

const { deleteRow } = useDelete();

const handleDelete = (id) => {
    deleteRow("admin.property-categories.destroy", id, (response) => {
        emit("updateCategories",response.props.categories);
    });

    if (props.selectedCategory && props.selectedCategory.id === props.category.id) {
        selectedCategory.value = null;
    }
};

</script>

  <style lang="scss" scoped>
</style>
