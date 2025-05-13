<template>
  <div>
    <label for="roles" class="form-label font-medium">Role :</label>
    <div class="form-icon relative mt-2">
      <select
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
        id="roles"
        class="form-select ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
      >
        <option value="">Select a role</option>
        <option v-for="role in roles" :key="role.id" :value="role.id">
          {{ role.name }}
        </option>
      </select>
      <InputError :message="error" class="mt-2" />
    </div>
  </div>
</template>

<script setup>
import { defineProps, toRefs } from "vue";

const props = defineProps({
  modelValue: String,
  roles: Array,
  error: String,
});

const { modelValue } = toRefs(props);
</script>

