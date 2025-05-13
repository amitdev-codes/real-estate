<template>
    <div class="bg-gray-50 px-4 py-3 shadow-sm relative">
      <div class="items-center">
        <!-- Navigation links -->
        <div class="space-x-6">
          <button
            v-for="(link, index) in navLinks"
            :key="index"
            @click="setActive(index)"
            :class="link.isActive ? 'bg-green-600 text-white px-4 py-2 rounded' : 'text-gray-700 hover:text-green-600'"
            class="pb-2"
          >
            {{ link.name }}
          </button>
        </div>

        <!-- Search bar -->
        <div class="relative w-full min-w-lg mt-5 mb-5">
          <input
            v-model="searchQuery"
            type="text"
            placeholder="Try a location or a school or project name"
            class="border border-gray-300 rounded-full px-4 py-2 w-full text-gray-600 focus:ring-2 focus:ring-green-400"
          />
          <button class="absolute right-0 top-0 mt-1 mr-2 p-2 bg-gray-200 rounded-full text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 19L16.35 16.35M9 11a6 6 0 1112 0 6 6 0 01-12 0z" />
            </svg>
          </button>
        </div>
      </div>

      <!-- Search nearby suburbs checkbox -->
      <div class="flex items-center mt-3">
        <input type="checkbox" id="nearbySuburbs" class="h-4 w-4 text-green-600 border-gray-300 rounded focus:ring-2 focus:ring-green-600">
        <label for="nearbySuburbs" class="ml-2 block text-sm text-gray-600">Search nearby suburbs</label>
      </div>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        searchQuery: '',
        navLinks: [
          { name: 'Buy', isActive: false },
          { name: 'Rent', isActive: false },
          { name: 'House & Land', isActive: true },
          { name: 'New Homes', isActive: false },
          { name: 'Sold', isActive: false },
          { name: 'Retirement', isActive: false },
          { name: 'Rural', isActive: false },
        ],
      };
    },
    methods: {
      setActive(index) {
        this.navLinks.forEach((link, i) => {
          link.isActive = i === index;
        });
      },
    },
  };
  </script>

  <style scoped>
  input:focus {
    outline: none;
  }
  </style>
