<!-- SwitchComponent.vue -->
<template>
  <button
    type="button"
    role="switch"
    :aria-checked="computedAriaChecked"
    @click="handleToggle"
    class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
    :class="[isIndeterminate ? 'bg-indigo-300' : value ? 'bg-indigo-600' : 'bg-gray-200']"
  >
    <span
      aria-hidden="true"
      class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
      :class="[
        isIndeterminate ? 'translate-x-5' : value ? 'translate-x-5' : 'translate-x-0',
      ]"
    ></span>
  </button>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  value: {
    type: Boolean,
    default: false,
  },
  indeterminate: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["change"]);

const isIndeterminate = computed(() => props.indeterminate);

const computedAriaChecked = computed(() => {
  if (isIndeterminate.value) return "mixed";
  return props.value;
});

const handleToggle = () => {
  emit("change");
};
</script>

