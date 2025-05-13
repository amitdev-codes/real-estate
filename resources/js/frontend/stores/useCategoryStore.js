// stores/categoryStore.js
import { defineStore } from 'pinia';

export const useCategoryStore = defineStore('category', {
  state: () => ({
    selectedCategory: 'Buy',
  }),
  actions: {
    updateCategory(category) {
      this.selectedCategory = category;
    },
  },
});
