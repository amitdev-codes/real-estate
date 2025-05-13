<template>
  <div>
    <label :for="id" class="block mb-2 text-sm font-medium text-gray-700">
      {{ label }}
    </label>
    <div :class="{ relative: type === 'password' }">
      <input
        :id="id"
        :value="modelValue"
        :type="inputType"
        :placeholder="placeholder"
        :maxlength="maxLength"
        :class="[
          'w-full px-4 py-2 text-sm border rounded-lg focus:ring focus:ring-green-300 focus:outline-none  text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600',
          { 'border-red-500': error },
        ]"
        @input="handleInput"
        @blur="validateInput"
      />

      <!-- Password Toggle -->
      <button
        v-if="type === 'password'"
        type="button"
        @click="togglePasswordVisibility"
        class="absolute inset-y-0 right-3 text-gray-500 focus:outline-none"
      >
        <svg
          v-if="showPassword"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          class="w-5 h-5"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M13.875 18.825a10.05 10.05 0 01-3.75 0m3.75-13.65a10.05 10.05 0 013.75 13.65M6.375 5.175a10.05 10.05 0 00-3.75 13.65m15-3.75A10.05 10.05 0 006.375 5.175m6 6a3 3 0 110 6 3 3 0 010-6z"
          />
        </svg>
        <svg
          v-else
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          class="w-5 h-5"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M3.98 8.036A10.05 10.05 0 0121.02 15.964M21.02 8.036A10.05 10.05 0 013.98 15.964M14.121 9.879a3 3 0 11-4.243 4.242M12 12a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
          />
        </svg>
      </button>
    </div>

    <!-- Error Message -->
    <p v-if="error" class="mt-1 text-xs text-red-500">
      {{ error }}
    </p>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";

const props = defineProps({
  modelValue: {
    type: [String, Number],
    default: "",
  },
  type: {
    type: String,
    default: "text",
    validator: (value) => ["text", "email", "number", "password", "tel"].includes(value),
  },
  label: {
    type: String,
    required: true,
  },
  placeholder: {
    type: String,
    default: "",
  },
  id: {
    type: String,
    required: true,
  },
  maxLength: {
    type: Number,
    default: null,
  },
  required: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["update:modelValue"]);

const error = ref("");
const showPassword = ref(false);

// Computed input type for password visibility toggle
const inputType = computed(() => {
  if (props.type === "password") {
    return showPassword.value ? "text" : "password";
  }
  return props.type;
});

// Password visibility toggle
const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value;
};

// Input validation methods
const validateInput = () => {
  // Reset error
  error.value = "";

  // Check if required
  if (props.required && !props.modelValue) {
    error.value = `${props.label} is required`;
    return false;
  }

  // Email validation
  if (props.type === "email") {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (props.modelValue && !emailRegex.test(props.modelValue)) {
      error.value = "Invalid email format";
      return false;
    }
  }

  // Number validation
  if (props.type === "number") {
    const numValue = Number(props.modelValue);
    if (isNaN(numValue)) {
      error.value = "Please enter a valid number";
      return false;
    }
  }

  // Password validation
  if (props.type === "password") {
    if (props.modelValue.length < 8) {
      error.value = "Password must be at least 8 characters";
      return false;
    }
  }

  return true;
};

// Handle input and emit updates
const handleInput = (event) => {
  const newValue = event.target.value;
  emit("update:modelValue", newValue);
  validateInput();
};
</script>
