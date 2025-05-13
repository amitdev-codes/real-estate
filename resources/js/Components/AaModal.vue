<script setup>
/**
 * @@
 * [Dyanmic Modal]
 *:maxWidth="modalMaxWidth" // set dynamically
 *:initButton="initModalButton" // initialize default modal buttons or use custom button on your modal content/body
 *:isOpen="isModalOpen"
 *:title="'Custom Modal Title'" // can use slot or props
 *:body="'This is the body of the modal.'" // can use slot or props
 *:saveButtonText="'Confirm'"
 *:cancelButtonText="'Dismiss'"
 *:saveButtonClasses="'bg-blue-600 hover:bg-blue-700 text-white rounded-md px-4 py-2'"
 *:cancelButtonClasses="'bg-red-500 hover:bg-red-600 text-white rounded-md px-4 py-2 mr-2'"
 *@close="closeModal"
 *@save="onSave"
 *@cancel="onCancel"
 */

/**
  * can handle rendering based on the presence of the title/body prop or slot content
  *  <!-- <template #title>Filters</template> -->
      <!-- <template #body>
        <FilterModal />
      </template> -->
  */

import {
  computed,
  onMounted,
  onUnmounted,
  watch,
  defineProps,
  defineEmits,
  Teleport,
  Transition,
} from "vue";

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },
  initButton: {
    type: Boolean,
    default: false,
  },
  title: {
    type: String,
    default: "",
  },
  // body: {
  //   type: String,
  //   default: false,
  // },
  body: [Object, String],
  maxWidth: {
    type: String,
    default: "2xl",
  },
  closeable: {
    type: Boolean,
    default: true,
  },
  saveButtonText: {
    type: String,
    default: "Save",
  },
  cancelButtonText: {
    type: String,
    default: "Cancel",
  },
  saveButtonClasses: {
    type: String,
    default: "bg-green-600 hover:bg-green-700 text-white rounded-md px-4 py-2",
  },
  cancelButtonClasses: {
    type: String,
    default:
      "bg-gray-500 hover:bg-gray-600 text-white rounded-md px-4 py-2 mr-2",
  },
  saveButtonIcon: {
    type: String,
    default: null,
  },
  cancelButtonIcon: {
    type: String,
    default: null,
  },
  component: {
    type: [Object, Function, String],
    required: false,
    validator(value) {
      return (
        value &&
        (typeof value === "string" ||
          typeof value === "function" ||
          typeof value === "object")
      );
    },
  },
  componentProps: {
    type: Object,
    default: () => ({}),
  },
});

const emit = defineEmits(["close", "save", "cancel"]);

watch(
  () => props.isOpen,
  () => {
    if (props.isOpen) {
      document.body.style.overflow = "hidden";
    } else {
      document.body.style.overflow = null;
    }
  }
);

const close = () => {
  if (props.closeable) {
    emit("close");
  }
};

const closeOnEscape = (e) => {
  if (e.key === "Escape" && props.isOpen) {
    close();
  }
};

onMounted(() => document.addEventListener("keydown", closeOnEscape));

onUnmounted(() => {
  document.removeEventListener("keydown", closeOnEscape);
  document.body.style.overflow = null;
});

const maxWidthClass = computed(() => {
  return {
    xs: "sm:max-w-xs", // Extra Small
    sm: "sm:max-w-sm", // Small
    md: "sm:max-w-md", // Medium
    lg: "sm:max-w-lg", // Large
    xl: "sm:max-w-xl", // Extra Large
    "2xl": "sm:max-w-2xl", // 2 Extra Large
    "3xl": "sm:max-w-3xl", // 3 Extra Large
    "4xl": "sm:max-w-4xl", // 4 Extra Large
    "5xl": "sm:max-w-5xl", // 5 Extra Large
    full: "sm:max-w-full", // Full width
  }[props.maxWidth];
});

const closeModal = () => {
  isModalOpen.value = false;
};

const handleSave = () => {
  emit("save");
};

const handleCancel = () => {
  emit("cancel");
};

// Helper function to check if the value is a component
function isComponent(value) {
    console.log("Checking component:", value);

  return (
    value &&
    (typeof value === "object" || typeof value === "function") &&
    "render" in value
  );
}
</script>

<template>
  <Teleport to="body">
    <Transition leave-active-class="duration-200">
      <div
        v-if="isOpen"
        class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
        scroll-region
      >
        <Transition
          enter-active-class="ease-out duration-300"
          enter-from-class="opacity-0"
          enter-to-class="opacity-100"
          leave-active-class="ease-in duration-200"
          leave-from-class="opacity-100"
          leave-to-class="opacity-0"
        >
          <div
            v-if="isOpen"
            class="fixed inset-0 transform transition-all"
            @click="close"
          >
            <div class="absolute inset-0 bg-gray-500 opacity-75" />
          </div>
        </Transition>

        <Transition
          enter-active-class="ease-out duration-300"
          enter-from-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
          enter-to-class="opacity-100 translate-y-0 sm:scale-100"
          leave-active-class="ease-in duration-200"
          leave-from-class="opacity-100 translate-y-0 sm:scale-100"
          leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
          <div
            v-if="isOpen"
            class="bg-white overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto px-25rem py-10"
            :class="maxWidthClass"
          >
            <!-- Modal Header -->
            <div class="px-6 py-4 border-b border-gray-200 flex items-center">
              <!-- Conditionally rendered title and close button -->
              <div
                :class="{ 'flex-grow': title }"
                class="flex justify-between items-center w-auto"
              >
                <!-- Title -->
                <h3 class="text-lg font-medium text-gray-900">
                  <slot name="title">{{ title }}</slot>
                </h3>
              </div>
              <button
                class="text-gray-500 hover:text-gray-700 ml-auto"
                @click="close"
              >
                Close ✕
              </button>
            </div>

            <!-- Modal Body -->
            <div class="px-6 py-4">
              <p v-if="!component">
                Component not found or not passed correctly.
              </p>
              <!-- Render a component if it's valid -->
              <component
                v-if="component || 'div'"
                :is="component"
                v-bind="componentProps"
                :categories="componentProps.categories || {}"
                @close="close"
              />
              <!-- Render the string if `component` is a string -->
              <p v-else-if="typeof component === 'string'">{{ component }}</p>
              <!-- Render slot content if provided -->
              <slot v-else name="body" />
            </div>

            <!-- Modal Footer -->
            <div class="px-6 py-4 bg-gray-50 text-right" v-if="initButton">
              <button @click="handleCancel" :class="cancelButtonClasses">
                {{ cancelButtonText }}
              </button>
              <button @click="handleSave" :class="saveButtonClasses">
                <i v-if="saveButtonIcon" :class="saveButtonIcon"></i>
                {{ saveButtonText }}
              </button>
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<style scope>
/* previous px-80[20rem] */
.px-25rem {
  padding-left: 25rem !important;
  padding-right: 25rem !important;
}
</style>
