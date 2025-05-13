<template>
  <div class="registration-form text-dark text-start">
    <div
      class="grid lg:grid-cols-12 md:grid-cols-12 grid-cols-1 lg:gap-0 gap-2"
    >
      <!-- Search input spanning 8 columns on large screens -->
      <div class="lg:col-span-8 col-span-12">
        <div class="filter-search-form relative mt-2">
          <i class="uil uil-search icons"></i>
          <input
            name="name"
            type="text"
            id="job-keyword"
            class="form-input filter-input-box bg-gray-50 dark:bg-slate-800 border-0 w-full"
            placeholder="Search your keywords"
          />
        </div>
      </div>

      <!-- Buttons spanning 4 columns on large screens -->
      <div
        class="lg:col-span-4 col-span-12 lg:mt-4 mt-4 flex lg:justify-end justify-start"
      >
        <ButtonWithIcon
          name="search"
          id="filter"
          customClass="rounded-full mr-5"
          text="Filters"
          icon="mdi mdi-tune icons mr-1"
          @click="openModal('full')"
        />

        <input
          type="submit"
          id="search-buy"
          name="search"
          class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white searchbtn submit-btn !h-12 rounded-full"
          value="Search"
        />
      </div>
    </div>
    <!--end grid-->
    <!-- Modal component -->
    <AaModal
      :title="'Filter'"
      :isOpen="isModalOpen"
      :maxWidth="modalMaxWidth"
      :saveButtonText="'Confirm'"
      :cancelButtonText="'Dismiss'"
      :saveButtonClasses="'bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2'"
      :cancelButtonClasses="'bg-red-500 hover:bg-red-600 text-white rounded-md px-4 py-2 mr-2'"
      :component="FilterModal"
      :componentProps="{ categories: categories, selected : categoryStore.selectedCategory }"
      @close="closeModal"
    >
    </AaModal>
  </div>
  <!--end container :componentProps="{ filterOptions: optionsArray }"-->
</template>

<script setup>
import { useCategoryStore } from '@/frontend/stores/useCategoryStore';
import { ref, markRaw  } from "vue";
import { defineProps, defineEmits } from "vue";

// Define the prop passed from the controller
const props = defineProps({
  categories: {
    type: Object,
    required: true,
  },
});

import FilterModal from "@/frontend/components/partials/modals/filter-modal.vue";
import ButtonWithIcon from "@/Components/ButtonWithIcon.vue";
import AaModal from "@/Components/AaModal.vue";

const isModalOpen = ref(false);
const modalMaxWidth = ref('lg');
const categoryStore = useCategoryStore();

const emit = defineEmits(['close']);

// Define options array to pass as a prop
const optionsArray = ref([
  { id: 1, name: 'Option 1' },
  { id: 2, name: 'Option 2' },
  { id: 3, name: 'Option 3' },
]);

const categories = ref(props.categories);

const openModal = (width) => {
console.log('Width passed to openModal:', width); // Add this line for debugging

if (width) {
  modalMaxWidth.value = width;
  isModalOpen.value = true;
} else {
  console.warn('Width is undefined.');
}
};

const closeModal = () => {
  isModalOpen.value = false;
};

// Pass the FilterModal component and categories as props
const modalComponent = markRaw(FilterModal);

</script>

<style scoped></style>
