<template>
    <component
      :is="componentType"
      :href="href"
      :method="method"
      :as="as"
      class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
    >
      <slot />
    </component>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3'

  const props = defineProps({
    href: String,
    method: {
      type: String,
      default: 'get'
    },
    as: {
      type: String,
      default: 'a'
    }
  })

  const componentType = computed(() => props.as === 'button' ? 'Link' : Link)
  </script>
