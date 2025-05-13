<template>
  <BreadcrumbAndPageTitle :pageTitle="'All Property Categories'" />

  <!-- Content Grid -->
  <div class="grid lg:grid-cols-12 grid-cols-1 gap-6">
    <div class="lg:col-span-5">
      <!-- Propery Facilities Order Section -->
      <Card>
        <template #header> Property Category </template>
        <div class="" data-simplebar>
          <table class="w-full text-start table-auto">
            <thead class="text-base">
              <tr>
                <th
                  class="text-start font-semibold text-[15px] px-4 py-3 min-w-[30px]"
                >
                  Icon
                </th>
                <th
                  class="text-start font-semibold text-[15px] px-4 py-3 min-w-[140px]"
                >
                  Name
                </th>
                <th
                  class="text-end font-semibold text-[15px] px-4 py-3 min-w-[70px]"
                >
                  Status
                </th>
                <th
                  class="text-end font-semibold text-[15px] px-4 py-3 min-w-[70px]"
                >
                  Actions
                </th>
              </tr>
            </thead>
            <tbody>
              <template v-if="categories && categories.length">
                <PropertyCategoryTree
                  :categories="categories"
                  :prefix="''"
                  :level="0"
                  :selectedCategory="selectedCategory"
                  @editCategory="editCategory"
                  @updateCategory="handleCategoryUpdate"
                />
              </template>
              <tr v-else>
                <td colspan="4" class="text-center text-gray-500 py-4">
                  No categories available
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </Card>
    </div>

    <div class="lg:col-span-7">
      <PropertyCategoryForm
        :categories="categories"
        :category="selectedCategory"
        :icons="icons"
        @updateCategories="handleCategoryUpdate"
      />
    </div>
  </div>
</template>


<script setup>
// import { toast } from "vue3-toastify";
import { ref } from "vue";
import BackendLayout from "@/layouts/backend-layout.vue";
import PropertyCategoryForm from "../../components/property-category/property-category-form.vue";
import BreadcrumbAndPageTitle from "@backend-components/ui/breadcrumb-and-page-title.vue";

import Card from "@backend-components/ui/card.vue";
// import SuccessBadge from "@backend-components/ui/badges/success-badge.vue";
// import DangerBadge from "@backend-components/ui/badges/danger-badge.vue";

import PropertyCategoryTree from "./property-category-tree.vue";

const breadcrumbs = ref([
  { name: "Property Category", route: "admin.property-categories.index" },
]);

const props = defineProps({
  selectedCategory: Object, // Currently selected category
  categories: Array,
  icons: Array,
});

const selectedCategory = ref(null);
const categories = ref(props.categories || []);

const editCategory = (category) => {

    selectedCategory.value = {
          ...category,
          children: category.children || [],
    };
    
// Route::get('property-categories/get-categories/{id}',[ PropertyCategoryController::class,'show'])->name('property-categories.getCategories');
// fetch category data from the server
//   isLoading.value = true;
//   try {
//     axios
//       .get(
//         route("admin.property-categories.getCategories", { id: category.id })
//       )
//       .then((response) => {
//         const data = response.data.category;
//         selectedCategory.value = {
//           ...data,
//           children: data.children || [], // Ensure children are populated
//         };
//         toast.success("Property category fetched successfully");
//       })
//       .catch((error) => {
//         console.error(error);
//         toast.error("Failed to fetch property category");
//       });
//   } catch (error) {
//     console.error("Error fetching mineral log data:", error);
//   } finally {
//     isLoading.value = false;
//   }
};

// const handleCategoryUpdate = (updatedCategory) => {
//     const index = categories.value.findIndex(c => c.id === updatedCategory.id);
//     if (index !== -1) {
//         categories.value[index] = updatedCategory; // Update category
//     } else {
//         categories.value.push(updatedCategory); // Add new category
//     }
// };

// Fetch all categories (if needed)
// const fetchCategories = async () => {
//     isLoading.value = true;
//     try {
//         const response = await axios.get(route("admin.property-categories.index"));
//         categories.value = response.data.categories;
//     } catch (error) {
//         console.error("Failed to fetch categories:", error);
//         toast.error("Failed to load categories");
//     } finally {
//         isLoading.value = false;
//     }
// };

const handleCategoryUpdate = (updatedCategories) => {
  categories.value = updatedCategories;
};
</script>

<script>
export default {
  layout: BackendLayout,
};
</script>

<style lang="scss" scoped>
</style>


