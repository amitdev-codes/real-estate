<template>
    <div class="relative">
      <div @click="open = !open">
        <slot name="trigger" />
      </div>

      <div
        v-show="open"
        @click="open = false"
        class="fixed inset-0 z-40 bg-black opacity-25"
      ></div>

      <div
        v-show="open"
        class="absolute z-50 mt-2 rounded-md shadow-lg"
        :class="{
          'w-48 right-0': width === '48',
          'origin-top-right': align === 'right'
        }"
      >
        <div
          class="rounded-md ring-1 ring-black ring-opacity-5 py-1 bg-white"
        >
          <slot name="content" />
        </div>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue'

  defineProps({
    align: {
      type: String,
      default: 'right'
    },
    width: {
      type: String,
      default: '48'
    }
  })

  const open = ref(false)
  </script>
