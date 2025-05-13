<template>
    <div :class="containerClass">
      <img
        :src="profileImage"
        :class="imageClass"
        :alt="altText"
      />
      <label v-if="showLabel" class="absolute inset-0 cursor-pointer" for="pro-img"></label>
    </div>
  </template>
  
  <script setup>
  import { computed } from 'vue';
  import { usePage } from '@inertiajs/vue3';
  
  // Access the shared props using usePage
  const { auth } = usePage().props;
  
  // Create a computed property for the profile image
  const profileImage = computed(() => {
    return auth.user ? auth.user.profile_image : null; // Return the profile image URL
  });
  
  // Props
  const props = defineProps({
    containerClass: {
      type: String,
      default: 'relative h-8 w-8 mx-auto', // Default class for the container
    },
    imageClass: {
      type: String,
      default: 'rounded-md', // Default class for the image
    },
    altText: {
      type: String,
      default: 'Profile Image',
    },
    showLabel: {
      type: Boolean,
      default: false,
    },
  });
  </script>
  
  <style scoped>
  /* Add any additional styles here */
  </style>