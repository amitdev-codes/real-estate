<template>
  <div>
    <InputLabel for="icon" value="Property Category" />
    <select
      :id="id"
      :name="name"
      v-model="selectedCategory"
      class="form-input mt-2 border-gray-200 text-gray-400 text-sm focus:ring-black-500 focus:border-black-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-black-500 dark:focus:border-black-500"
    >
      <option value="">Select a category</option>
      <template v-for="category in categories" :key="category.id">
        <!-- Parent Category -->
        <option :value="category.id" style="background: rgb(243, 244, 246);" class="__parent">{{ category.name }}</option>

        <!-- Child Categories -->
        <!-- <option
          v-for="child in category.children"
          :key="child.id"
          :value="child.id"
          class="__child"
        >
          -- {{ child.name }}
        </option> -->

        <!-- Child Categories -->
        <template v-if="category.children && category.children.length">
          <template v-for="child in category.children" :key="child.id">
            <option :value="child.id" class="__child">&nbsp;-- {{ child.name }}</option>

            <!-- Sub-Child Categories -->
            <template v-if="child.children && child.children.length">
              <template v-for="subChild in child.children" :key="subChild.id">
                <option :value="subChild.id" class="__sub-child">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--- {{ subChild.name }}</option>
              </template>
            </template>
          </template>
        </template>

      </template>
    </select>
  </div>
</template>

<script>

import { defineEmits } from "vue";
import InputLabel from "@backend-components/ui/input-label.vue";

const emit = defineEmits(["update:category"]);

export default {
  props: {
    categories: {
      type: Array,
      required: true,
    },
    category: {
      type: Object,
      required: false,
    },
    id:String,
    name:String,
  },
  data() {
    return {
      selectedCategory: this.category?.id || "",
    };
  },
  methods: {
    handleCategoryChange(event) {
      const selectedCategoryId = event.target.value;
      console.log("Selected category:", selectedCategoryId);
      this.$emit("update:category", selectedCategoryId);
    },
  },
  watch: {
    category: {
      immediate: true,
      handler(newCategory) {
        console.log("New category:", newCategory);
        this.selectedCategory = newCategory?.id || "";
      },
    },
    selectedCategory(newCategory) {
      this.$emit("update:modelValue", newCategory);
    },
  },
  components: {
    InputLabel,
  },
};
</script>

  <style scoped>
/* Add additional styling if needed */
option.__select {
    font-size: 12px;
}
</style>
