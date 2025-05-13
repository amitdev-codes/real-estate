<template>
  <div>
    <label :for="id" class="block mb-2 text-sm font-medium text-gray-700">
      {{ label }}
    </label>
    <div class="flex items-center space-x-2">
      <!-- Country Code Suffix -->
      <span
        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 border rounded-lg text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
      >
        {{ countryCode }}
      </span>
      <input
        :id="id"
        :value="modelValue"
        type="tel"
        :placeholder="placeholder"
        :maxlength="maxLength"
        :class="[
          'w-full px-4 py-2 text-sm border rounded-lg focus:ring focus:ring-green-300 focus:outline-none  text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600',
          { 'border-red-500': error },
        ]"
        @input="handleInput"
        @blur="validateMobile"
      />
    </div>
    <p v-if="error" class="mt-1 text-xs text-red-500">
      {{ error }}
    </p>
  </div>
</template>

<script setup>
import { ref } from "vue";

const props = defineProps({
  modelValue: {
    type: [String, Number],
    default: "",
  },
  label: {
    type: String,
    default: "Mobile Number",
  },
  id: {
    type: String,
    required: true,
  },
  placeholder: {
    type: String,
    default: "9825369987",
  },
  countryCode: {
    type: String,
    default: "+977",
  },
  maxLength: {
    type: Number,
    default: 10,
  },
  required: {
    type: Boolean,
    default: true,
  },
});

const emit = defineEmits(["update:modelValue"]);

const error = ref("");

const validateMobile = () => {
  error.value = "";

  // Check if required
  if (props.required && !props.modelValue) {
    error.value = "Mobile number is required";
    return false;
  }

  // Nepali mobile number validation
  const mobileRegex = /^[9][6-8]\d{8}$/;
  if (props.modelValue && !mobileRegex.test(props.modelValue)) {
    error.value = "Invalid mobile number";
    return false;
  }

  return true;
};

const handleInput = (event) => {
  const newValue = event.target.value;
  emit("update:modelValue", newValue);
  validateMobile();
};
</script>
