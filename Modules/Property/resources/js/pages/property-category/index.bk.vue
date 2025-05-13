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
                  />
                </template>
                <tr v-else>
                  <td colspan="4" class="text-center text-gray-500 py-4">
                    No categories available
                  </td>
                </tr>
                <!-- <template v-for="category in categories" :key="category.id">
                  <tr
                    :class="
                      selectedCategory && selectedCategory.id === category.id
                        ? 'bg-gray-100 dark:bg-gray-800'
                        : ''
                    "
                  >
                    <td
                      class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3"
                    >
                      <span class="text-slate-400"
                        ><i
                          :class="
                            'mdi mdi-' + category.icon == null
                              ? ''
                              : category.icon
                          "
                        ></i
                      ></span>
                    </td>

                    <td
                      class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3"
                    >
                      <span
                        class="text-slate-400 hover:text-green-600 cursor-pointer"
                        v-on:click="editCategory(category)"
                        :class="
                          selectedCategory && selectedCategory.id === category.id
                            ? 'text-red-600'
                            : ''
                        "
                      >
                        {{ category.name }}
                      </span>
                    </td>

                    <td
                      class="text-end border-t border-gray-100 dark:border-gray-800 px-4 py-3"
                    >
                      <SuccessBadge
                        v-if="category.is_active == true"
                        :label="'Active'"
                      />
                      <DangerBadge
                        v-if="category.is_active == false"
                        :label="'Inactive'"
                      />
                    </td>

                    <td
                      class="text-center border-t border-gray-100 dark:border-gray-800 px-4 py-3 justify-between"
                    >
                      <Link
                        v-if="
                          selectedCategory && selectedCategory.id === category.id
                        "
                        :href="
                          route('admin.property-categories.destroy', category.id)
                        "
                        method="delete"
                        as="button"
                        class="text-red-500"
                      >
                        <i class="mdi mdi-delete font-normal"></i>
                      </Link>
                    </td>
                  </tr>

                  <template v-if="category.children && category.children.length">
                    <tr
                      v-for="child in category.children"
                      :key="child.id"
                      class="bg-gray-50 dark:bg-gray-700"
                    >
                      <td
                        class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3 pl-8"
                      >
                        <span class="text-slate-400"
                          ><i :class="'mdi mdi-' + child.icon == null ? '': child.icon"></i
                        ></span>
                      </td>
                      <td
                        class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3 pl-8"
                      >
                        <span
                          class="text-slate-400 hover:text-green-600 cursor-pointer"
                          v-on:click="editCategory(child)"
                          :class="
                            selectedCategory && selectedCategory.id === child.id
                              ? 'text-red-600'
                              : ''
                          "
                        >
                          - {{ child.name }}
                        </span>
                      </td>
                      <td
                        class="text-end border-t border-gray-100 dark:border-gray-800 px-4 py-3"
                      >
                        <SuccessBadge v-if="child.is_active" :label="'Active'" />
                        <DangerBadge v-else :label="'Inactive'" />
                      </td>
                      <td
                        class="text-center border-t border-gray-100 dark:border-gray-800 px-4 py-3 justify-between"
                      >
                        <Link
                          v-if="
                            selectedCategory && selectedCategory.id === child.id
                          "
                          :href="
                            route('admin.property-categories.destroy', child.id)
                          "
                          method="delete"
                          as="button"
                          class="text-red-500"
                        >
                          <i class="mdi mdi-delete font-normal"></i>
                        </Link>
                      </td>
                    </tr>
                  </template>
                </template> -->
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
  const isLoading = ref(false);

  const editCategory = (category) => {

      selectedCategory.value = {
            ...category,
            children: category.children || [],
      };



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
  </script>

  <script>
  export default {
    layout: BackendLayout,
  };
  </script>

  <style lang="scss" scoped>
  </style>


