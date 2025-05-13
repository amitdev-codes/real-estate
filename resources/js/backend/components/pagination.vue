<template>
    <div class="grid md:grid-cols-12 grid-cols-1 mt-6">
      <div class="md:col-span-12 text-center">
        <nav v-if="pagination.last_page > 1">
          <ul class="inline-flex items-center -space-x-px">
            <!-- Previous Button -->
            <li>
              <Link
                :href="pagination.current_page > 1 ? route(routeName, { page: pagination.current_page - 1 }) : '#'"
                :class="[
                  'w-10 h-10 inline-flex justify-center items-center mx-1 rounded-full',
                  'text-slate-400 bg-white dark:bg-slate-900 hover:text-white shadow-sm dark:shadow-gray-700',
                  'hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600',
                  { 'cursor-not-allowed': pagination.current_page === 1 }
                ]"
                :disabled="pagination.current_page === 1"
              >
                <i class="mdi mdi-chevron-left text-[20px]"></i>
              </Link>
            </li>
  
            <!-- Page Numbers -->
            <li v-for="page in pages" :key="page">
              <Link
                :href="route(routeName, { page })"
                :class="[
                  'w-10 h-10 inline-flex justify-center items-center mx-1 rounded-full',
                  'shadow-sm dark:shadow-gray-700',
                  pagination.current_page === page
                    ? 'z-10 text-white bg-green-600'
                    : 'text-slate-400 bg-white dark:bg-slate-900 hover:text-white hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600'
                ]"
              >
                {{ page }}
              </Link>
            </li>
  
            <!-- Next Button -->
            <li>
              <Link
                :href="pagination.current_page < pagination.last_page ? route(routeName, { page: pagination.current_page + 1 }) : '#'"
                :class="[
                  'w-10 h-10 inline-flex justify-center items-center mx-1 rounded-full',
                  'text-slate-400 bg-white dark:bg-slate-900 hover:text-white shadow-sm dark:shadow-gray-700',
                  'hover:border-green-600 dark:hover:border-green-600 hover:bg-green-600 dark:hover:bg-green-600',
                  { 'cursor-not-allowed': pagination.current_page === pagination.last_page }
                ]"
                :disabled="pagination.current_page === pagination.last_page"
              >
                <i class="mdi mdi-chevron-right text-[20px]"></i>
              </Link>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </template>
  
  <script setup>
  import { computed } from 'vue';
  import { Link } from '@inertiajs/vue3';
  
  const props=defineProps({
    pagination: {
      type: Object,
      required: true,
      default: () => ({
        current_page: 1,
        last_page: 1,
        per_page: 10,
      }),
    },
    routeName: {
      type: String,
      required: true, // Ensure the parent component provides a route name
    },
  });
  
  // Compute dynamic page numbers (e.g., show a range around the current page)
  const pages = computed(() => {
    const { current_page, last_page } = props.pagination;
    const range = 2; // Number of pages to show before and after the current page
    const pagesArray = [];
  
    const start = Math.max(1, current_page - range);
    const end = Math.min(last_page, current_page + range);
  
    for (let i = start; i <= end; i++) {
      pagesArray.push(i);
    }
  
    return pagesArray;
  });
  </script>
  
  <style lang="scss" scoped>
  /* Add any additional styles if needed */
  </style>