<template>
  <div class="relative">
    <label :for="id" class="block mb-2 text-sm font-medium text-gray-700">
      {{ label }}
    </label>
    <div class="flex items-center space-x-3">
      <span
        class="text-sm"
        :class="{ 'text-gray-700': modelValue, 'text-gray-500': !modelValue }"
      >
        {{ modelValue ? activeLabel : inactiveLabel }}
      </span>
      <label class="relative inline-flex items-center cursor-pointer">
        <input
          :id="id"
          :checked="modelValue"
          type="checkbox"
          class="sr-only"
          @change="toggleSwitch"
        />
        <div
          class="toggle-bg block w-10 h-5 rounded-full transition"
          :class="{
            'bg-green-600': modelValue,
            'bg-yellow-400': !modelValue,
          }"
        ></div>
        <div
          class="toggle-dot absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full transition"
          :class="{ 'translate-x-full': modelValue }"
        ></div>
      </label>
    </div>
  </div>
</template>

<script setup>
import { defineProps, defineEmits } from "vue";

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
  },
  label: {
    type: String,
    default: "Status",
  },
  id: {
    type: String,
    required: true,
  },
  activeLabel: {
    type: String,
    default: "Active",
  },
  inactiveLabel: {
    type: String,
    default: "Inactive",
  },
});

const emit = defineEmits(["update:modelValue"]);

const toggleSwitch = () => {
  emit("update:modelValue", !props.modelValue);
};
</script>
