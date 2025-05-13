<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Profile Overview Card (8 columns) -->
            <div class="bg-white rounded-xl shadow-sm lg:col-span-8">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-800">Profile Overview</h2>
                        <button
                            @click="openProfileEditor"
                            class="text-blue-600 hover:text-blue-700 text-sm transition-colors"
                        >
                            Edit Profile
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div class="flex-shrink-0">
                            <div class="aspect-square w-full max-w-xs mx-auto">
                                <MediaDisplay
                                    :key="props.data.media_url"
                                    :data="props.data"
                                    model="agency"
                                    collection="agency"
                                    conversion="preview"
                                    :media_url="media_url"
                                    :rounded="true"
                                    :withDownload="true"
                                />
                            </div>
                        </div>

                        <!-- Right Column (Details) -->
                        <div class="flex-grow space-y-4">
                            <div class="space-y-4 bg-gray-50 p-4 rounded-lg h-fit">
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-600 text-sm">Status:</span>
                                    <span
                                        :class="[
                                            'px-2 py-1 rounded-full text-xs',
                                            props.data?.status === 'active'
                                                ? 'bg-green-100 text-green-800'
                                                : 'bg-red-100 text-red-800',
                                        ]"
                                    >
                                        {{ props.data?.status }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                    <span>{{ props.data?.email || "Add your email" }}</span>
                                </p>
                                <p class="text-gray-600 text-sm flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ props.data?.phone || "Add your phone" }}</span>
                                </p>
                                <p class="text-gray-600 text-sm flex items-center space-x-2">
                                    <span class="font-bold">Registered Agency Number:</span>
                                    <span>{{ props.data?.registered_agency_number || "N/A" }}</span>
                                </p>
                                <p class="text-gray-600 text-sm flex items-center space-x-2">
                                    <span class="font-bold">Agency:</span>
                                    <span>{{ props.data?.agency_name || "N/A" }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Completion Card (4 columns) -->
            <div class="bg-white rounded-xl shadow-sm p-4 lg:col-span-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Profile Completion</h2>
                <div class="flex items-start space-x-6">
                    <div class="relative w-24 h-24">
                        <svg viewBox="0 0 36 36" class="w-full h-full">
                            <path
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none"
                                stroke="#f3f4f6"
                                stroke-width="3"
                            />
                            <path
                                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none"
                                stroke="#3b82f6"
                                stroke-width="3"
                                :stroke-dasharray="`${profileCompletion}, 100`"
                            />
                            <text x="18" y="18" text-anchor="middle" dominant-baseline="central" class="text-xs font-bold">
                                {{ profileCompletion }}%
                            </text>
                        </svg>
                    </div>
                    <div class="flex-grow space-y-2">
                        <div v-for="(item, index) in completionItems" :key="index" class="flex items-center">
                            <div :class="item.completed ? 'bg-green-100' : 'bg-gray-100'" class="rounded-full p-1 mr-2">
                                <svg :class="item.completed ? 'text-green-500' : 'text-gray-400'" class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path v-if="item.completed" fill-rule="evenodd" clip-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                                    <path v-else d="M10 3a7 7 0 100 14 7 7 0 000-14zm-1 10V7h2v6H9z" />
                                </svg>
                            </div>
                            <span :class="item.completed ? 'text-gray-800' : 'text-gray-600'" class="text-sm">{{ item.text }}</span>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex flex-col space-y-3">
                    <button
                        @click="$refs.mediaModal.openModal()"
                        class="flex items-center w-auto mx-auto bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700"
                    >
                        <span class="mdi mdi-file-document mr-2"></span>
                        Add Testimonial
                    </button>
                    <button
                        @click="openProfileEditor"
                        class="flex items-center w-auto mx-auto bg-green-600 text-white font-semibold px-4 py-2 rounded hover:bg-green-700"
                    >
                        <span class="mdi mdi-account-edit mr-2"></span>
                        Complete Profile
                    </button>
                </div>
            </div>

            <!-- Profile Editor Modal -->
            <StepperFormModal
                :show="showProfileEditor"
                title="Edit Agency Profile"
                :steps="formSteps"
                :model-value="data"
                :submit-handler="(vueformData, form$) => handleSubmit(vueformData, form$, 'agency.update', props.data.id, () => showProfileEditor = false)"
                @close="showProfileEditor = false"
            >
                <template #default>
                    <BasicInfo :data="props.data" />
                    <ContactInfo :data="props.data" />
                    <BioPhoto :data="props.data" />
                </template>
            </StepperFormModal>

            <MediaModal
                ref="mediaModal"
                model="agency"
                :modelId="props.data.id"
                collection="agency_testimonials"
                title="Agency Photos"
                @update:modelValue="handleMediaUpdate"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, computed, defineProps } from "vue";
import BackendLayout from "@/layouts/backend-layout.vue";
import MediaDisplay from "@/Components/MediaDisplay.vue";
import BasicInfo from "../../components/BasicInfo.vue";
import ContactInfo from "../../components/ContactInfo.vue";
import BioPhoto from "../../components/BioPhoto.vue";
import MediaModal from "@/backend/components/ui/inputs/MediaModal.vue";
import { handleSubmit } from "@/utils/formSubmit.js"; // Import the reusable function
import StepperFormModal from "@components/StepperFormModal.vue";


const props = defineProps({
    data: { type: Object, default: () => ({}) },
    agencies: { type: Array, default: () => ({}) },
});

const showProfileEditor = ref(false);
const data = ref({});


// Define the steps for the stepper form
const formSteps = [
    { name: "account", label: "Basic Info", elements: ["basic_info", "name",  "email", "phone","website","registered_agency_number"] },
    { name: "contact", label: "Contact Info", elements: ["contact_info", "state", "city", "street","building_number","postal_code","latitude","longitude"] },
    { name: "bio_photo", label: "Bio Photo", elements: ["bio_photo", "image", "short_description", "description"] },
];

const completionItems = ref([
    { text: "Basic Information", completed: computed(() => props.data?.name?.trim() !== "") },
    { text: "Contact Details", completed: computed(() => !!props.data?.email && !!props.data?.phone) },
    { text: "Profile Picture", completed: computed(() => props.data?.name?.trim() !== "" && props.data?.media_url && !props.data?.media_url.includes("static/images/no_image.jpg")) },
    { text: "Registered Agency Number", completed: computed(() => !!props.data?.registered_agency_number) },
]);

const profileCompletion = computed(() => {
    const completed = completionItems.value.filter((item) => item.completed.valueOf()).length;
    return Math.round((completed / completionItems.value.length) * 100);
});
const handleMediaUpdate = (newMedia) => {
    if (Array.isArray(newMedia)) {
        data.value.testimonials = newMedia.map((media) => ({
            id: media.id,
            preview_url: media.preview_url,
            thumb_url: media.thumb_url,
        }));
    }
};

const openProfileEditor = () => {
    showProfileEditor.value = true;
};
</script>

<script>
export default {
    layout: BackendLayout,
};
</script>

<style scoped>
svg path:nth-child(2) {
    transition: stroke-dasharray 0.5s ease;
}
.badge {
    display: inline-block !important;
    padding: 0.25rem 0.75rem !important;
    border-radius: 9999px !important;
    font-size: 0.875rem !important;
    font-weight: 500 !important;
}
.badge-active {
    background-color: #d1fae5 !important;
    color: #047857 !important;
}
.badge-inactive {
    background-color: #fee2e2 !important;
    color: #b91c1c !important;
}
</style>