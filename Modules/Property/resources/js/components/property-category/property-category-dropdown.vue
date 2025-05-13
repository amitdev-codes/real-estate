
<template>
  <div>
    <InputLabel for="icon" value="Property Category" />

    <Multiselect
      v-model="selectedCategory"
      :options="categories"
      :name="name"
      :multiple="true"
      :close-on-select="false"
      :clear-on-select="false"
      :preserve-search="false"
      placeholder="Select a category"
      label="name"
      track-by="id"
      :preselect-first="false"
      class="mt-2"
    >
      <template #option="{ option }">
        <div class="multiselect__option">
          <span>{{ option.name }}</span>
        </div>
      </template>
    </Multiselect>
  </div>
</template>

    <script>
import Multiselect from "vue-multiselect";

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
    id: String,
    name: String,
  },
  data() {
    return {
      selectedCategory: this.category?.id || [],
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
        this.selectedCategory = newCategory?.id || [];
      },
    },
    selectedCategory(newCategory) {
      this.$emit("update:modelValue", newCategory);
    },
  },
  components: {
    InputLabel,
    Multiselect,
  },
};
</script>

      <style scoped>
/* Add additional styling if needed */
option.__select {
  font-size: 12px;
}
.multiselect__option {
  padding: 10px;
}
</style>

  <style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

