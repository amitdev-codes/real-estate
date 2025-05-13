<template>
  <div class="relative" ref="selectContainer">
    <label v-if="label" :for="id" class="block mb-2 text-sm font-medium text-gray-700">
      {{ label }}
    </label>

    <div
      @click="toggleDropdown"
      class="w-full px-4 py-2 text-sm border rounded-lg cursor-pointer flex justify-between items-center text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
      :class="{ 'border-green-500': isOpen }"
    >
      <!-- Select display content with support for all/reset option -->
      <span
        v-if="!multiple && !modelValue"
        class="text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
      >
        {{ placeholder }}
      </span>
      <span v-else-if="!multiple && modelValue === null" class="text-gray-500 italic">
        All
      </span>
      <span
        v-else-if="!multiple && modelValue"
        class="text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
      >
        {{ getOptionLabel(modelValue) }}
      </span>

      <span
        v-if="multiple && (!modelValue || modelValue.length === 0)"
        class="text-gray-500"
      >
        {{ placeholder }}
      </span>
      <span v-else-if="multiple" class="flex flex-wrap gap-1">
        <span
          v-for="value in modelValue"
          :key="value"
          class="bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded"
        >
          {{ getOptionLabel(value) }}
        </span>
      </span>

      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-4 w-4 text-gray-500"
        :class="{ 'transform rotate-180': isOpen }"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M19 9l-7 7-7-7"
        />
      </svg>
    </div>

    <!-- Modified Dropdown Content -->
    <!-- <div
      v-show="isOpen"
      class="relative z-50 w-full bg-white border rounded-lg shadow-lg p-2 min-h-[120px] max-h-60 overflow-y-auto text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
      :style="dropdownStyle"
    > -->
    <div
      v-show="isOpen"
      class="absolute z-50 w-full bg-white border rounded-lg shadow-lg p-2 min-h-[120px] max-h-60 overflow-y-auto text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
      :style="dropdownStyle"
    >
      <div class="sticky top-0 bg-white dark:bg-gray-700 pb-2">
        <input
          v-if="searchable"
          type="text"
          v-model="searchQuery"
          placeholder="Search..."
          class="w-full px-2 py-1 border rounded text-sm focus:outline-none focus:ring-2 focus:ring-green-600"
          @input="filterOptions"
        />
      </div>

      <div
        class="flex flex-col"
        :class="{
          'h-[80px] flex items-center justify-center': filteredOptions.length === 0,
        }"
      >
        <!-- All/Reset Option -->
        <!-- <div
          class="flex items-center p-2 hover:bg-gray-100 rounded cursor-pointer text-gray-600 text-sm font-light dark:hover:bg-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600 italic"
          @click.stop="selectOption(null)"
        >
          <template v-if="multiple">
            <input
              type="checkbox"
              :checked="isSelected(null)"
              class="mr-2 rounded text-green-600 focus:ring-600-600"
              @click.stop
            />
          </template>
          <span>All</span>
        </div> -->

        <div v-if="filteredOptions.length === 0" class="text-center text-gray-500">
          No results found
        </div>

        <div
          v-for="option in filteredOptions"
          :key="option[valueKey]"
          class="flex items-center p-2 hover:bg-gray-100 rounded cursor-pointer text-gray-600 text-sm font-light dark:hover:bg-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
          @click.stop="selectOption(option[valueKey])"
        >
          <template v-if="multiple">
            <input
              type="checkbox"
              :checked="isSelected(option[valueKey])"
              class="mr-2 rounded text-green-600 focus:ring-600-600"
              @click.stop
            />
          </template>
          <span
            class="text-gray-600 text-sm font-light dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600"
            >{{ option[labelKey] }}</span
          >
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";

const props = defineProps({
  modelValue: {
    type: [String, Number, Array, null],
    default: null,
  },
  options: {
    type: Array,
    required: true,
  },
  multiple: {
    type: Boolean,
    default: false,
  },
  label: {
    type: String,
    default: "",
  },
  placeholder: {
    type: String,
    default: "Select option",
  },
  id: {
    type: String,
    default: "",
  },
  valueKey: {
    type: String,
    default: "id",
  },
  labelKey: {
    type: String,
    default: "name",
  },
  searchable: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["update:modelValue"]);

const selectContainer = ref(null);
const isOpen = ref(false);
const searchQuery = ref("");
const filteredOptions = ref(props.options);
const dropdownStyle = ref({});

const updateDropdownPosition = () => {
  if (!selectContainer.value) return;

  const containerRect = selectContainer.value.getBoundingClientRect();
  const windowHeight = window.innerHeight;
  const spaceBelow = windowHeight - containerRect.bottom;
  const spaceAbove = containerRect.top;
  const dropdownHeight = 240; // max-h-60 = 15rem = 240px

  if (spaceBelow < dropdownHeight && spaceAbove > spaceBelow) {
    dropdownStyle.value = {
      bottom: "100%",
      marginBottom: "4px",
      top: "auto",
    };
  } else {
    dropdownStyle.value = {
      top: "100%",
      marginTop: "4px",
      bottom: "auto",
    };
  }
};

const closeDropdown = (e) => {
  if (selectContainer.value && !selectContainer.value.contains(e.target)) {
    isOpen.value = false;
  }
};

const toggleDropdown = () => {
  isOpen.value = !isOpen.value;
  if (isOpen.value) {
    searchQuery.value = "";
    filteredOptions.value = props.options;
    updateDropdownPosition();
  }
};

const getOptionLabel = (value) => {
  if (value === null) return "All";
  const option = props.options.find((opt) => opt[props.valueKey] === value);
  return option ? option[props.labelKey] : "";
};

const isSelected = (value) => {
  if (value === null) {
    return props.multiple ? props.modelValue.length === 0 : props.modelValue === null;
  }

  if (props.multiple) {
    return Array.isArray(props.modelValue) && props.modelValue.includes(value);
  }
  return props.modelValue === value;
};

const selectOption = (value) => {
  if (props.multiple) {
    const currentValue = Array.isArray(props.modelValue) ? props.modelValue : [];

    if (value === null) {
      // If "All" is selected, reset to empty array
      emit("update:modelValue", []);
    } else {
      const newValue = [...currentValue];
      const index = newValue.indexOf(value);

      if (index === -1) {
        newValue.push(value);
      } else {
        newValue.splice(index, 1);
      }

      emit("update:modelValue", newValue);
    }
  } else {
    emit("update:modelValue", value);
    isOpen.value = false;
  }
};

const filterOptions = () => {
  if (!props.searchable) return;

  filteredOptions.value = props.options.filter((option) =>
    option[props.labelKey]
      .toString()
      .toLowerCase()
      .includes(searchQuery.value.toLowerCase())
  );
};

onMounted(() => {
  document.addEventListener("click", closeDropdown);
  window.addEventListener("resize", updateDropdownPosition);
});

onUnmounted(() => {
  document.removeEventListener("click", closeDropdown);
  window.removeEventListener("resize", updateDropdownPosition);
});
</script>
