<template>
    <div class="media-display">
        <div class="media-container relative">
            <img
                :src="mediaUrl"
                :alt="title"
                :class="[imageClasses, roundedClass]"
                @error="handleImageError"
            />

            <!-- Action Buttons -->
            <div class="action-buttons absolute top-2 right-2 flex gap-2">
                <button
                    v-if="withDownload"
                    @click="downloadImage"
                    class="btn-action"
                >
                    <i class="mdi mdi-download"></i>
                </button>

                <label class="btn-action cursor-pointer">
                    <i class="mdi mdi-upload"></i>
                    <input
                        type="file"
                        class="hidden"
                        accept="image/*"
                        @change="handleUpload"
                    />
                </label>
            </div>

            <!-- Loading Overlay -->
            <div v-if="loading" class="loading-overlay">
                <i class="mdi mdi-loading mdi-spin text-3xl"></i>
            </div>
        </div>

        <!-- Media Info -->
        <div class="media-info mt-4 text-center">
            <h5 class="text-lg font-medium">{{ data?.name || title }}</h5>
            <div v-if="data?.role" class="mt-1">
                <span class="badge-role">{{ data.role }}</span>
            </div>
            <slot></slot>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import axios from "axios";

const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    model: {
        type: String,
        required: true,
    },
    collection: {
        type: String,
        required: true,
    },
    conversion: {
        type: String,
        default: "preview",
    },
    title: {
        type: String,
        default: "Media",
    },
    dimension: {
        type: String,
        default: "lg",
    },
    rounded: {
        type: Boolean,
        default: false,
    },
    withDownload: {
        type: Boolean,
        default: true,
    },
});

const emit = defineEmits(["update:data", "upload-success", "upload-error"]);

const loading = ref(false);
const imageError = ref(false);
const currentMedia = ref(props.data?.media_url?.value || null); // Initialize properly

// Watch for prop changes
watch(
    () => props.data?.media_url?.value,
    (newUrl) => {
        currentMedia.value = newUrl;
    }
);

// Computed Properties
const dimensions = {
    sm: "h-24 w-24",
    md: "h-32 w-32",
    lg: "h-48 w-48",
    xl: "h-64 w-64",
};

const displayImage = computed(() => {
    return (
        props.data?.media_url ??
        "http://127.0.0.1:5173/resources/assets/backend/images/client/07.jpg"
    );
});

const imageClasses = computed(
    () => `
  object-cover
  ${dimensions[props.dimension] || dimensions.lg}
`
);

const roundedClass = computed(() =>
    props.rounded ? "rounded-full" : "rounded-lg"
);

// Methods
const handleImageError = () => {
    imageError.value = true;
};

// const handleUpload = async (event) => {
//     const file = event.target.files[0];
//     if (!file) return;

//     loading.value = true;
//     const formData = new FormData();
//     formData.append("media", file);
//     formData.append("model", props.model);
//     formData.append("collection", props.collection);

//     try {
//         const response = await axios.post("/media/upload", formData);
//         currentMedia.value = response.data[0]?.url;

//         // Emit the updated data
//         emit("upload-success", response.data[0]);

//         // Update the parent component's data
//         emit("update:data", {
//             ...props.data,
//             media_url: response.data[0]?.url,
//             preview_url: response.data[0]?.preview_url,
//             thumb_url: response.data[0]?.thumb_url,
//         });
//     } catch (error) {
//         emit("upload-error", error);
//     } finally {
//         loading.value = false;
//     }
// };

const mediaUrl = computed(() => {
    if (currentMedia.value) {
        // If currentMedia is an object from upload response
        if (typeof currentMedia.value === 'object' && currentMedia.value.preview_url) {
            return props.conversion === "thumb" 
                ? currentMedia.value.thumb_url 
                : currentMedia.value.preview_url;
        }
        // If currentMedia is a string URL
        return currentMedia.value;
    }
    return props.data?.media_url || "/path/to/default/image.jpg";
});

const handleUpload = async (event) => {
    const file = event.target.files[0];
    if (!file) return;

    loading.value = true;
    const formData = new FormData();
    formData.append("media", file);
    formData.append("model", props.model);
    formData.append("collection", props.collection);

    try {
        const response = await axios.post("/media/upload", formData);
        // Update currentMedia with the full response object
        currentMedia.value = response.data[0]; // This should trigger mediaUrl update
        
        emit("upload-success", response.data[0]);
        emit("update:data", {
            ...props.data,
            media_url: response.data[0]?.url,
            preview_url: response.data[0]?.preview_url,
            thumb_url: response.data[0]?.thumb_url,
        });
    } catch (error) {
        emit("upload-error", error);
    } finally {
        loading.value = false;
    }
};

const downloadImage = () => {
    const link = document.createElement("a");
    link.href = displayImage.value;
    link.download = `${props.title || "image"}.jpg`;
    link.click();
};

onMounted(async () => {
    await fetchMedia();
});

const fetchMedia = async () => {
    try {
        const response = await axios.get(`/${props.model}/${props.data.id}/${props.collection}`);
        currentMedia.value = response.data[0]; 
    } catch (error) {
        console.error("Error fetching media:", error);
    }
};

// const mediaUrl = computed(() => {
//     if (currentMedia.value) {
//         return props.conversion === "thumb"
//             ? currentMedia.value.thumb_url
//             : currentMedia.value.preview_url;
//     }
//     return props.data?.media_url || "/path/to/default/image.jpg";
// });
</script>

<style scoped>
.media-display {
    @apply relative;
}

.media-container {
    @apply relative overflow-hidden bg-gray-100;
}

.btn-action {
    @apply p-2 bg-white rounded-full shadow-md
         hover:bg-gray-50 transition-colors
         flex items-center justify-center;
}

.loading-overlay {
    @apply absolute inset-0 bg-black bg-opacity-50
         flex items-center justify-center text-white;
}

.badge-role {
    @apply px-3 py-1 text-sm font-medium
         bg-blue-100 text-blue-700 rounded-full;
}

.hidden {
    display: none;
}

/* Material Design Icons Animations */
.mdi-spin {
    animation: spin 1s infinite linear;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
