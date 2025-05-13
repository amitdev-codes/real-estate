<template>
  <div>
    <div class="flex justify-between items-center mb-4">
      <h5 class="text-lg font-semibold">Properties</h5>
      <div>
        <label class="switch">
          <input type="checkbox" v-model="isFeatured" />
          <span class="slider round"></span>
        </label>
        <span class="ml-2">{{ isFeatured ? 'Featured' : 'Grid' }}</span>
      </div>
    </div>

    <!-- Featured Properties -->
    <div v-if="isFeatured">
      <h5 class="text-lg font-semibold">Featured Properties</h5>
      <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 gap-6 mt-6">
        <div
          v-for="item in featuredProperties"
          :key="item.id"
          class="group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500"
        >
          <div class="relative">
            <img
              :src="item.hero_image_path || '/assets/backend/images/error.png'"
              alt="Featured Property"
              class="w-full h-48 object-cover"
            />
            <div class="absolute top-4 end-4">
              <a
                href="javascript:void(0)"
                class="btn btn-icon bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 rounded-full text-slate-100 dark:text-slate-700 focus:text-red-600 dark:focus:text-red-600 hover:text-red-600 dark:hover:text-red-600"
              >
                <i class="mdi mdi-heart text-[20px]"></i>
              </a>
            </div>
          </div>
          <div class="p-6">
            <Link
              :href="route('admin.property-details', item.id)"
              class="text-lg hover:text-green-600 font-medium ease-in-out duration-500"
            >
              {{ item.title }}
            </Link>
            <ul
              class="py-6 border-y border-slate-100 dark:border-gray-800 flex items-center list-none"
            >
              <li class="flex items-center me-4">
                <i class="mdi mdi-arrow-expand-all text-2xl me-2 text-green-600"></i>
                <span>{{ item.area }}</span>
              </li>
              <li class="flex items-center me-4">
                <i class="mdi mdi-bed text-2xl me-2 text-green-600"></i>
                <span>{{ item.beds }}</span>
              </li>
              <li class="flex items-center">
                <i class="mdi mdi-shower text-2xl me-2 text-green-600"></i>
                <span>{{ item.baths }}</span>
              </li>
            </ul>
            <ul class="pt-6 flex justify-between items-center list-none">
              <li>
                <span class="text-slate-400">Price</span>
                <p class="text-lg font-medium">{{ item.base_price }}</p>
              </li>
              <li>
                <span class="text-slate-400">Rating</span>
                <ul class="text-lg font-medium text-amber-400 list-none">
                  <li v-for="star in item.star" :key="star" class="inline me-1">
                    <i :class="star"></i>
                  </li>
                  <li class="inline text-black dark:text-white">{{ item.rating }}</li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Grid Properties -->
    <div v-else>
      <h5 class="text-lg font-semibold">All Properties</h5>
      <div class="grid lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 grid-cols-1 gap-6 mt-6">
        <div
          v-for="item in filteredProperties"
          :key="item.id"
          class="group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500"
        >
          <div class="relative">
            <img
              :src="item.thumb_url || '/assets/backend/images/error.png'"
              alt="Property Thumbnail"
              class="w-full h-32 object-cover"
            />
            <div class="absolute top-4 end-4">
              <a
                href="javascript:void(0)"
                class="btn btn-icon bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 rounded-full text-slate-100 dark:text-slate-700 focus:text-red-600 dark:focus:text-red-600 hover:text-red-600 dark:hover:text-red-600"
              >
                <i class="mdi mdi-heart text-[20px]"></i>
              </a>
            </div>
          </div>
          <div class="p-4">
            <Link
              :href="route('admin.property-details', item.id)"
              class="text-lg hover:text-green-600 font-medium ease-in-out duration-500"
            >
              {{ item.title }}
            </Link>
            <ul
              class="py-4 border-y border-slate-100 dark:border-gray-800 flex items-center list-none"
            >
              <li class="flex items-center me-4">
                <i class="mdi mdi-arrow-expand-all text-xl me-2 text-green-600"></i>
                <span>{{ item.area }}</span>
              </li>
              <li class="flex items-center me-4">
                <i class="mdi mdi-bed text-xl me-2 text-green-600"></i>
                <span>{{ item.beds }}</span>
              </li>
              <li class="flex items-center">
                <i class="mdi mdi-shower text-xl me-2 text-green-600"></i>
                <span>{{ item.baths }}</span>
              </li>
            </ul>
            <ul class="pt-4 flex justify-between items-center list-none">
              <li>
                <span class="text-slate-400">Price</span>
                <p class="text-lg font-medium">{{ item.base_price }}</p>
              </li>
              <li>
                <span class="text-slate-400">Rating</span>
                <ul class="text-lg font-medium text-amber-400 list-none">
                  <li v-for="star in item.star" :key="star" class="inline me-1">
                    <i :class="star"></i>
                  </li>
                  <li class="inline text-black dark:text-white">{{ item.rating }}</li>
                </ul>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <Pagination :pagination="pageProps.pagination" route-name="admin.user.profile" />
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import Pagination from "@/backend/components/pagination.vue";
import { usePage, Link } from '@inertiajs/vue3';

const { props: pageProps } = usePage();
const isFeatured = ref(false);

// Ensure properties is an array
const properties = computed(() => {
  return Array.isArray(pageProps.properties) ? pageProps.properties : [];
});

// Filter properties based on user role
// const filteredProperties = computed(() => {
//   const userRole = pageProps.auth.user.role;

//   console.log(properties.value);
//   // console.log(properties.value);

//   if (userRole === 'admin' || userRole === 'SuperAdmin') {
//     return properties.value; // Admin sees all properties
//   } else {
//    return properties.value; 
//     // return properties.value.filter(property => property.agent_id === pageProps.auth.user.id); // Agents see their properties
//   }
// });

const filteredProperties = computed(() => {
  // Assuming roles is an array from Spatie Permissions
  const userRoles = pageProps.userdata.roles.map(role => role.name);
  console.log('User Roles:', userRoles);
  console.log('Properties:', properties.value);

  if (userRoles.includes('SuperAdmin')) {
    return properties.value; // SuperAdmin sees all properties
  } else if (userRoles.includes('Agent')) {
    // Filter properties by agent's ID
    const agentId = pageProps.userdata.agent?.id;
    return properties.value.filter(property => property.agent_id === agentId);
  }
  return properties.value; // Default case
});

// Filter featured properties
const featuredProperties = computed(() => {
  return filteredProperties.value.filter(property => property.is_featured);
});
</script>

<style lang="scss" scoped>
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: 0.4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: '';
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  transition: 0.4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #2196f3;
}

input:checked + .slider:before {
  transform: translateX(26px);
}
</style>