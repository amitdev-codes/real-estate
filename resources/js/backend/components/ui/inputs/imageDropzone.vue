<template>
  <div>
    <div
      :class="dropzoneClasses"
      @dragenter="handleDragEnter"
      @dragleave="handleDragLeave"
      @dragover.prevent
      @drop="handleDrop"
    >
      <div class="space-y-4">
        <!-- Preview Images -->
        <div class="flex flex-wrap justify-center">
          <div
            v-for="(image, index) in previewImages"
            :key="index"
            class="relative mx-2 mb-2"
            :class="{ 'w-24 h-24': props.rounded, 'w-20 h-20': !props.rounded }"
          >
            <img
              :src="image"
              :class="{
                'rounded-full w-24 h-24': props.rounded,
                'rounded-lg w-20 h-20': !props.rounded,
              }"
              class="object-cover"
              alt="Preview"
            />
            <button
              @click="removeImage(index)"
              class="absolute top-1 right-1 text-red-500 hover:text-red-700"
              aria-label="Remove image"
            >
              &times;
            </button>
          </div>
        </div>

        <!-- Upload Progress -->
        <div v-if="isUploading" class="w-full bg-gray-200 rounded-full h-2.5">
          <div
            class="bg-blue-600 h-2.5 rounded-full transition-all duration-300"
            :style="{ width: `${progress}%` }"
          ></div>
        </div>

        <!-- Error Message -->
        <div v-if="error" class="text-red-500 text-sm">
          {{ error }}
        </div>

        <!-- Upload Instructions -->
        <div class="flex items-center justify-center">
          <label class="cursor-pointer">
            <input
              type="file"
              class="hidden"
              :accept="props.acceptedFiles"
              @change="handleFileSelect"
              multiple
            />
            <span class="text-blue-600 hover:text-blue-700"> Click to upload </span>
            <span class="text-gray-500"> or drag and drop </span>
          </label>
        </div>

        <p class="text-sm text-gray-500">
          Supported formats: JPG, PNG, GIF (max. {{ props.maxSize / 1024 / 1024 }}MB)
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from "vue";
import axios from "axios";

interface Props {
  modelValue?: string | null | { preview_url?: string; thumb_url?: string };
  maxSize?: number;
  acceptedFiles?: string;
  collection: string;
  model: string;
  modelId: number | string;
  rounded?: boolean;
}

interface EmitEvents {
  (event: "update:modelValue", value: any): void;
  (event: "upload-success", value: any): void;
  (event: "upload-error", value: string): void;
}

const props = withDefaults(defineProps<Props>(), {
  modelValue: null,
  maxSize: 5242880, // 5MB
  acceptedFiles: "image/*",
  rounded: false,
});

const emit = defineEmits<EmitEvents>();

// Reactive state
const isDragging = ref(false);
const isUploading = ref(false);
const progress = ref(0);
const error = ref<string | null>(null);
const previewImages = ref<string[]>([]); // Array to hold preview images
const uploadedImages = ref([]);
// Computed properties
const dropzoneClasses = computed(() => ({
  "border-2 border-dashed p-4 text-center transition-all duration-200": true,
  "border-blue-400 bg-blue-50": isDragging.value,
  "border-gray-300 hover:border-blue-400": !isDragging.value,
  "rounded-full": props.rounded,
  "rounded-lg": !props.rounded,
}));

// Validate all files first
const uploadFiles = async (files: FileList) => {
  // Validate all files first
  for (let file of Array.from(files)) {
    if (!file.type.startsWith("image/")) {
      error.value = "Please upload image files only";
      return;
    }
    if (file.size > props.maxSize) {
      error.value = `File size should not exceed ${props.maxSize / 1024 / 1024}MB`;
      return;
    }
  }

  const formData = new FormData();

  // Append all files at once with the same key
  Array.from(files).forEach((file) => {
    formData.append("media[]", file);
  });

  formData.append("collection", props.collection);
  formData.append("model", props.model);
  formData.append("model_id", props.modelId.toString());

  try {
    isUploading.value = true;
    error.value = null;

    const response = await axios.post("../media/upload", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
      onUploadProgress: (progressEvent) => {
        if (progressEvent.total) {
          progress.value = Math.round((progressEvent.loaded * 100) / progressEvent.total);
        }
      },
    });

    // Handle array of responses
    if (Array.isArray(response.data)) {
      response.data.forEach((item) => {
        previewImages.value.push(item.preview_url);
      });
      uploadedImages.value = [...uploadedImages.value, ...response.data];
      emit("update:modelValue", response.data);
      emit("upload-success", response.data);
    }
  } catch (err: any) {
    error.value = err.response?.data?.message || "Upload failed";
    emit("upload-error", error.value);
  } finally {
    isUploading.value = false;
    progress.value = 0;
  }
};

// Methods
const handleDragEnter = (e: DragEvent) => {
  e.preventDefault();
  isDragging.value = true;
};

const handleDragLeave = (e: DragEvent) => {
  e.preventDefault();
  isDragging.value = false;
};

const handleDrop = async (e: DragEvent) => {
  e.preventDefault();
  isDragging.value = false;
  const files = e.dataTransfer?.files;
  if (files?.length) {
    await uploadFiles(files);
  }
};

const handleFileSelect = async (e: Event) => {
  const target = e.target as HTMLInputElement;
  const files = target.files;
  if (files?.length) {
    await uploadFiles(files);
  }
  target.value = ""; // Reset input
};

// const uploadFile = async (file: File) => {
//   // Validate file type
//   if (!file.type.startsWith("image/")) {
//     error.value = "Please upload an image file";
//     return;
//   }

//   // Validate file size
//   if (file.size > props.maxSize) {
//     error.value = `File size should not exceed ${props.maxSize / 1024 / 1024}MB`;
//     return;
//   }

//   const formData = new FormData();
//   // Change from 'media' to 'media[]' to indicate multiple files
//   formData.append("media[]", file);
//   formData.append("collection", props.collection);
//   formData.append("model", props.model);
//   formData.append("model_id", props.modelId.toString());

//   try {
//     isUploading.value = true;
//     error.value = null;

//     const response = await axios.post("../media/upload", formData, {
//       headers: {
//         "Content-Type": "multipart/form-data",
//       },
//       onUploadProgress: (progressEvent) => {
//         if (progressEvent.total) {
//           progress.value = Math.round((progressEvent.loaded * 100) / progressEvent.total);
//         }
//       },
//     });

//     // Handle array of responses
//     if (Array.isArray(response.data)) {
//       response.data.forEach((item) => {
//         previewImages.value.push(item.preview_url || URL.createObjectURL(file));
//       });
//       emit("update:modelValue", response.data);
//       emit("upload-success", response.data);
//     }
//   } catch (err: any) {
//     error.value = err.response?.data?.message || "Upload failed";
//     emit("upload-error", error.value);
//   } finally {
//     isUploading.value = false;
//     progress.value = 0;
//   }
// };

const removeImage = (index: number) => {
  previewImages.value.splice(index, 1);
};
</script>

<style scoped>
.modal {
  width: 80%; /* Adjust for larger modal */
  max-width: 800px; /* Maximum width */
}
.image-preview img {
  max-width: 100px; /* Adjust as needed */
  margin: 5px;
}
.upload-progress {
  width: 100%;
  background-color: gray;
}
.progress-bar {
  height: 5px;
  background-color: blue;
}
.error-message {
  color: red;
}
.upload-instructions {
  display: flex;
  justify-content: center;
}
</style>
