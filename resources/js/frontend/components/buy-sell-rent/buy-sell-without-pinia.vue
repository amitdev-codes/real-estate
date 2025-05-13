<template>
  <div class="container relative">
    <div class="grid grid-cols-1 justify-center">
      <div class="relative -mt-32">
        <div class="grid grid-cols-1">
          <ul
            class="inline-block sm:w-fit w-full flex-wrap justify-center text-center p-4 bg-white dark:bg-slate-900 rounded-t-xl border-b dark:border-gray-800"
            id="myTab"
            data-tabs-toggle="#StarterContent"
            role="tablist"
          >
            <!-- <li role="presentation" class="inline-block me-1">
              <button
                @click="toggle(1)"
                :class="
                  isActive === 1
                    ? 'text-white bg-green-600'
                    : 'dark:hover:bg-slate-800 hover:text-green-600 hover:bg-gray-50 dark:hover:text-white'
                "
                class="px-6 py-2 text-base font-medium rounded-md w-full transition-all duration-500 ease-in-out"
                id="buy-home-tab"
                type="button"
                role="tab"
                aria-selected="true"
              >
                Buy
              </button>
            </li>
            <li role="presentation" class="inline-block me-1">
              <button
                @click="toggle(2)"
                :class="
                  isActive === 2
                    ? 'text-white bg-green-600'
                    : 'dark:hover:bg-slate-800 hover:text-green-600 hover:bg-gray-50 dark:hover:text-white'
                "
                class="px-6 py-2 text-base font-medium rounded-md w-full transition-all duration-500 ease-in-out"
                id="sold-home-tab"
                type="button"
                role="tab"
                aria-selected="false"
              >
                Sold
              </button>
            </li>
            <li role="presentation" class="inline-block">
              <button
                @click="toggle(3)"
                :class="
                  isActive === 3
                    ? 'text-white bg-green-600'
                    : 'dark:hover:bg-slate-800 hover:text-green-600 hover:bg-gray-50 dark:hover:text-white'
                "
                class="px-6 py-2 text-base font-medium rounded-md w-full transition-all duration-500 ease-in-out"
                id="rent-home-tab"
                type="button"
                role="tab"
                aria-selected="false"
              >
                Rent
              </button>
            </li>
            <li role="presentation" class="inline-block">
              <button
                @click="toggle(4)"
                :class="
                  isActive === 4
                    ? 'text-white bg-green-600'
                    : 'dark:hover:bg-slate-800 hover:text-green-600 hover:bg-gray-50 dark:hover:text-white'
                "
                class="px-6 py-2 text-base font-medium rounded-md w-full transition-all duration-500 ease-in-out"
                id="home-and-land-tab"
                type="button"
                role="tab"
                aria-selected="false"
              >
                Home & Land
              </button>
            </li> -->

            <li
              v-for="(category, index) in Object.keys(categories)"
              :key="index"
              role="presentation"
              class="inline-block me-1"
            >
              <button
                @click="toggleCategory(category, index + 1)"
                :class="
                  isActive === index + 1
                    ? 'text-white bg-green-600'
                    : 'dark:hover:bg-slate-800 hover:text-green-600 hover:bg-gray-50 dark:hover:text-white'
                "
                class="px-6 py-2 text-base font-medium rounded-md w-full transition-all duration-500 ease-in-out"
                :id="`${category.toLowerCase()}-tab`"
                type="button"
                role="tab"
                :aria-selected="isActive === index + 1"
              >
                {{ category }}
              </button>
            </li>

          </ul>

          <div
            id="StarterContent"
            class="p-6 bg-white dark:bg-slate-900 rounded-ss-none rounded-se-none md:rounded-se-xl rounded-xl shadow-md dark:shadow-gray-700"
          >
            <div
              v-if="
                isActive === 1 ||
                isActive === 2 ||
                isActive === 3 ||
                isActive === 4
              "
            >
              <form action="#">
                <Search
                  :categories="props.categories"
                  v-model:selected="selectedCategory"
                />
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

  <script setup>
import { ref } from "vue";
import "vue-select/dist/vue-select.css";
// import search form
import Search from "@/frontend/components/partials/search/search.vue";

const props = defineProps({
  categories: {
    type: Object,
    required: true,
  },
});

const selectedCategory = ref(null);
const isActive = ref(1);


function toggleCategory(category, index) {
  selectedCategory.value = category;
  isActive.value = index;
}
</script>

  <style lang="scss" scoped></style>
