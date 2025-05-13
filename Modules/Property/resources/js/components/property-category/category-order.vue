<template>
  <Card>
      <template #header>
          Property Category
      </template>
      <div class="" data-simplebar>
          <table class="w-full text-start">
              <thead class="text-base">
                  <tr>
                      <th class="text-start font-semibold text-[15px] px-4 py-3 min-w-[140px]">Name</th>
                      <th class="text-end font-semibold text-[15px] px-4 py-3 min-w-[70px]"> Status </th>
                  </tr>
              </thead>
              <tbody>

                  <!-- <draggable v-model="sortableCategories" :options="dragOptions" tag="transition-group" item-key="id">
                      <template #item="{element}"> -->
                        <tr v-for="category in categories" :key="category.id">
                            <td class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3">
                                <span class="text-slate-400">{{ category.name }}</span>
                            </td>
                            <td class="text-end border-t border-gray-100 dark:border-gray-800 px-4 py-3">
                                <span v-if="category.is_active == true"
                                    class="bg-emerald-600/10 dark:bg-emerald-600/20 border border-emerald-600/10 dark:border-emerald-600/20 text-emerald-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1">Active</span>
                                <span v-if="category.is_active == false"
                                    class="bg-red-600/10 dark:bg-red-600/20 border border-red-600/10 dark:border-red-600/20 text-red-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1">Inactive</span>
                            </td>
                        </tr>
                      <!-- </template>
                  </draggable> -->
              </tbody>
          </table>
      </div>
  </Card>
</template>


<script setup>
// import draggable from 'vuedraggable';

import Card from '@backend-components/ui/card.vue';


const props = defineProps({ categories: Array });

// const sortableCategories = ref([...props.categories]);

// const dragOptions = {
//     animation: 200,
//     handle: '.drag-handle',
// };

</script>

<style lang="scss" scoped>

</style>

