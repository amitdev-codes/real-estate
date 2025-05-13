<template>
    <div 
      class="border-2 border-dashed border-gray-300 rounded-lg p-6 transition-colors" 
      :class="{ 'border-blue-500 bg-blue-50': isDragging }"
    >
      <div v-if="!files.length" class="text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
        </svg>
        <p class="mt-1 text-sm text-gray-600">
          Drag and drop files here, or 
          <span 
            class="font-medium text-blue-600 hover:text-blue-500 cursor-pointer"
            @click="$refs.fileInput.click()"
          >
            browse
          </span>
        </p>
        <p class="mt-1 text-xs text-gray-500">
          {{ acceptedFileTypesLabel }}
        </p>
      </div>
  
      <div v-else>
        <ul class="mt-2 divide-y divide-gray-200">
          <li v-for="(file, index) in files" :key="index" class="py-3 flex justify-between items-center">
            <div class="flex items-center">
              <svg class="h-5 w-5 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
              </svg>
              <span class="text-sm text-gray-700 truncate" :title="file.name">{{ file.name }}</span>
            </div>
            <div class="flex items-center">
              <div v-if="file.progress < 100 && file.progress > 0" class="mr-4 w-20">
                <div class="bg-gray-200 rounded-full h-2.5">
                  <div class="bg-blue-600 h-2.5 rounded-full" :style="{ width: file.progress + '%' }"></div>
                </div>
              </div>
              <button
                type="button"
                @click="removeFile(index)"
                class="ml-2 text-red-500 hover:text-red-700"
              >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
              </button>
            </div>
          </li>
        </ul>
  
        <div class="mt-4 flex justify-between">
          <button 
            type="button" 
            class="text-sm text-blue-600 hover:text-blue-500" 
            @click="$refs.fileInput.click()"
          >
            Add more files
          </button>
          <button 
            type="button" 
            class="text-sm text-blue-600 hover:text-blue-500"
            @click="uploadFiles"
            :disabled="uploading || !files.length"
          >
            {{ uploading ? 'Uploading...' : 'Upload files' }}
          </button>
        </div>
      </div>
  
      <input
        ref="fileInput"
        type="file"
        :multiple="multiple"
        :accept="acceptedFileTypes.join(',')"
        class="hidden"
        @change="onFileChange"
      />
    </div>
  </template>
  
  <script setup>
  import { ref, computed, onMounted } from "vue";
  import MediaUploadService from "@/utils/MediaUploadService";
  
  const props = defineProps({
    modelValue: {
      type: Array,
      default: () => [],
    },
    model: {
      type: String,
      required: true,
    },
    collection: {
      type: String,
      required: true,
    },
    modelId: {
      type: [Number, String],
      required: true,
    },
    conversion: {
      type: String,
      default: "preview"
    },
    multiple: {
      type: Boolean,
      default: true,
    },
    maxFiles: {
      type: Number,
      default: 10,
    },
    acceptedFileTypes: {
      type: Array,
      default: () => ['image/jpeg', 'image/png', 'image/gif', 'image/webp']
    }
  });
  
  const emit = defineEmits(["update:modelValue", "upload-success", "upload-error"]);
  
  const files = ref([]);
  const isDragging = ref(false);
  const uploading = ref(false);
  
  const acceptedFileTypesLabel = computed(() => {
    return props.acceptedFileTypes.map(type => type.replace('image/', '').toUpperCase()).join(', ');
  });
  
  const onFileChange = (event) => {
    const newFiles = Array.from(event.target.files);
    
    // Check if adding these files would exceed maxFiles
    if (files.value.length + newFiles.length > props.maxFiles) {
      emit("upload-error", { message: `Maximum ${props.maxFiles} files allowed` });
      return;
    }
    
    // Add progress property to each file
    newFiles.forEach(file => {
      // Validate file type
      if (!props.acceptedFileTypes.includes(file.type)) {
        emit("upload-error", { message: `File type ${file.type} not allowed` });
        return;
      }
      
      files.value.push({
        file,
        name: file.name,
        size: file.size,
        type: file.type,
        progress: 0
      });
    });
    
    // Reset the input
    event.target.value = '';
  };
  
  const removeFile = (index) => {
    files.value.splice(index, 1);
  };
  
  const uploadFiles = async () => {
    if (!files.value.length) return;
    
    uploading.value = true;
    const uploadedFiles = [];
    
    try {
      for (let i = 0; i < files.value.length; i++) {
        const fileObj = files.value[i];
        const formData = new FormData();
        formData.append('file', fileObj.file);
        formData.append('model', props.model);
        formData.append('model_id', props.modelId);
        formData.append('collection', props.collection);
        formData.append('conversion', props.conversion);
        
        const updateProgress = (progressEvent) => {
          const percentCompleted = Math.round((progressEvent.loaded * 100) / progressEvent.total);
          files.value[i].progress = percentCompleted;
        };
        
        const response = await MediaUploadService.uploadMedia(formData, updateProgress);
        uploadedFiles.push(response);
      }
      
      emit("upload-success", uploadedFiles);
      emit("update:modelValue", [...props.modelValue, ...uploadedFiles]);
      files.value = [];
    } catch (error) {
      emit("upload-error", error);
    } finally {
      uploading.value = false;
    }
  };
  
  // Drag and drop handlers
  const initDragAndDrop = () => {
    const dropzone = document.querySelector('.border-dashed');
    
    if (!dropzone) return;
    
    const preventDefaults = (e) => {
      e.preventDefault();
      e.stopPropagation();
    };
    
    const highlight = () => {
      isDragging.value = true;
    };
    
    const unhighlight = () => {
      isDragging.value = false;
    };
    
    const handleDrop = (e) => {
      preventDefaults(e);
      unhighlight();
      
      const dt = e.dataTransfer;
      const newFiles = Array.from(dt.files);
      
      if (files.value.length + newFiles.length > props.maxFiles) {
        emit("upload-error", { message: `Maximum ${props.maxFiles} files allowed` });
        return;
      }
      
      newFiles.forEach(file => {
        if (!props.acceptedFileTypes.includes(file.type)) {
          emit("upload-error", { message: `File type ${file.type} not allowed` });
          return;
        }
        
        files.value.push({
          file,
          name: file.name,
          size: file.size,
          type: file.type,
          progress: 0
        });
      });
    };
    
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
      dropzone.addEventListener(eventName, preventDefaults, false);
    });
    
    ['dragenter', 'dragover'].forEach(eventName => {
      dropzone.addEventListener(eventName, highlight, false);
    });
    
    ['dragleave', 'drop'].forEach(eventName => {
      dropzone.addEventListener(eventName, unhighlight, false);
    });
    
    dropzone.addEventListener('drop', handleDrop, false);
  };
  
  onMounted(() => {
    initDragAndDrop();
  });
  </script>
  