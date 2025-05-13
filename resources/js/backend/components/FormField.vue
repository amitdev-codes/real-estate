<template>
  <div>
    <label :for="id" class="form-label font-medium">
      {{ label }} <span v-if="required" class="text-red-600">*</span>
    </label>
    <div class="form-icon relative mt-2">
      <i :data-feather="icon" class="w-4 h-4 absolute top-3 start-4"></i>
      <input
        v-model="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :type="type || 'text'"
        :id="id"
        class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
        :placeholder="placeholder"
        :required="required"
      />
    </div>
    <InputError :message="error" class="mt-2" />
  </div>
</template>

<script setup>
import { defineProps, toRefs } from "vue";

const props = defineProps({
  modelValue: String,
  label: String,
  required: Boolean,
  error: String,
  id: String,
  placeholder: String,
  type: String,
  icon: String,
});

const { modelValue } = toRefs(props);
</script>
