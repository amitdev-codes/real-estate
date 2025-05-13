<!--
<template>
        <CategoryRow
          v-for="category in categories"
          :key="category.id"
          :category="category"
          :selectedCategory="selectedCategory"
          @selectCategory="selectCategory"
        />
</template>

  <script setup>
import { ref } from "vue";
import CategoryRow from "./category-row.vue";

const props = defineProps({
  categories: Array,
  selectedCategory: Object,
});

const emit = defineEmits(["selectCategory"]);

const selectCategory = (category) => {
  emit("selectCategory", category);
};
</script>

  <style lang="scss" scoped>
</style>
-->

<template>
  <CategoryRow
    v-for="category in categories"
    :key="category.id"
    :category="category"
    :selectedCategory="selectedCategory"
    :prefix="prefix"
    :level="level + 1"
    @selectCategory="selectCategory"
    @editCategory="editCategory"
    @updateCategories="updateCategory"
  />
</template>

  <script setup>
import CategoryRow from "./category-row.vue"; // Import the updated category-row component

const props = defineProps({
  categories: Array,
  prefix: String,
  selectedCategory: Object,
  level:Number,
});

const emit = defineEmits(["selectCategory", "editCategory","updateCategory"]);

const selectCategory = (category) => {
    console.log('Selected category:', category);
  emit("selectCategory", category);
};

const editCategory = (category) => {
    console.log('Edit category:', category);
  emit("editCategory", category);
};

const updateCategory = (category) => {
    console.log('Edit category:', category);
  emit("updateCategory", category);
};

</script>

