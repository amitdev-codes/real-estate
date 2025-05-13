<template>
  <div>
    <!-- Modal Backdrop -->
    <div
      v-if="isModalOpen"
      class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center"
    >
      <div class="bg-white rounded-xl max-w-5xl w-full mx-4 max-h-[90vh] overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-4 border-b flex justify-between items-center">
          <h3 class="text-xl font-semibold text-gray-800">{{ title }}</h3>
          <button @click="closeModal" class="text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M6 18L18 6M6 6l12 12"
              />
            </svg>
          </button>
        </div>

        <!-- Content -->
        <div class="p-6">
          <!-- Media Preview Grid -->
          <div
            v-if="existingMedia.length > 0"
            class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6"
          >
            <div v-for="item in existingMedia" :key="item.id" class="relative group">
              <img :src="item.preview_url" class="w-full h-48 object-cover rounded-lg" />
              <div
                class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-lg"
              >
                <button
                  @click="removeMedia(item.id)"
                  class="text-white bg-red-500 p-2 rounded-full"
                >
                  <svg
                    class="w-5 h-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                    />
                  </svg>
                </button>
              </div>
            </div>
          </div>

          <!-- Dropzone -->
          <ImageDropzone
            v-model="uploadedImages"
            :model="model"
            :collection="collection"
            :modelId="modelId"
            conversion="preview"
            :multiple="true"
            @upload-success="handleUploadSuccess"
          />
        </div>

        <!-- Footer -->
        <div class="px-6 py-4 border-t flex justify-between">
          <button
            @click="closeModal"
            class="bg-gray-300 px-4 py-2 rounded hover:bg-gray-400"
          >
            Cancel
          </button>
          <button
            @click="saveImages"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
          >
            Save
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import ImageDropzone from "@/backend/components/ui/inputs/imageDropzone.vue";

const props = defineProps({
  modelId: {
    type: [Number, String],
    required: true,
  },
  model: {
    type: String,
    required: true,
  },
  collection: {
    type: String,
    required: true,
  },
  title: {
    type: String,
    default: "Media Gallery",
  },
});

const emit = defineEmits(["update:modelValue", "close"]);

const isModalOpen = ref(false);
const uploadedImages = ref([]);
const existingMedia = ref([]);

const fetchExistingMedia = async () => {
  try {
    const response = await axios.get(
      `/${props.model}/${props.modelId}/${props.collection}`
    );
    existingMedia.value = response.data;
  } catch (error) {
    console.error("Error fetching media:", error);
  }
};

const removeMedia = async (mediaId) => {
  try {
    await axios.delete(`/media/${mediaId}`);
    existingMedia.value = existingMedia.value.filter((item) => item.id !== mediaId);
    emit("update:modelValue", existingMedia.value);
  } catch (error) {
    console.error("Error removing media:", error);
  }
};
const handleUploadSuccess = (uploadedFiles) => {
  // Add newly uploaded files to existingMedia
  if (Array.isArray(uploadedFiles)) {
    existingMedia.value = [...existingMedia.value, ...uploadedFiles];
  } else {
    existingMedia.value.push(uploadedFiles);
  }
};

const saveImages = async () => {
  emit("update:modelValue", [...existingMedia.value, ...uploadedImages.value]);
  closeModal();
};

const closeModal = () => {
  isModalOpen.value = false;
  emit("close");
};

const openModal = () => {
  isModalOpen.value = true;
  fetchExistingMedia();
};

defineExpose({ openModal });

onMounted(() => {
  if (props.modelId) {
    fetchExistingMedia();
  }
});
</script>
