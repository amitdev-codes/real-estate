<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-16">
        <!-- Stats Overview Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Profile Overview Card (8 columns) -->
            <div class="bg-white rounded-xl shadow-sm lg:col-span-8">
                <div class="p-6 border-b border-gray-100">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-semibold text-gray-800">
                            Profile Overview
                        </h2>
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
                        <!-- Left Column -->
                        <div class="">
                            <div class="aspect-square w-full max-w-sm mx-auto">
                                <MediaDisplay
                                    :key="mediaKey"
                                    :data="userData"
                                    model="user"
                                    collection="users"
                                    conversion="preview"
                                    :rounded="true"
                                    :withDownload="true"
                                    @upload-success="handleMediaUploadSuccess"
                                />
                            </div>

                            <div class="space-y-4 bg-gray-50 p-4 rounded-lg">
                                <div class="flex items-center space-x-2">
                                    <span class="text-gray-600 text-sm"
                                        >Status:</span
                                    >
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

                                <div class="space-y-3">
                                    <p
                                        class="text-gray-600 text-sm flex items-center space-x-2"
                                    >
                                        <svg
                                            class="w-4 h-4 text-gray-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"
                                            />
                                        </svg>
                                        <span>{{
                                            props.data?.email ||
                                            "Add your email"
                                        }}</span>
                                    </p>

                                    <p
                                        class="text-gray-600 text-sm flex items-center space-x-2"
                                    >
                                        <svg
                                            class="w-4 h-4 text-gray-400"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                        >
                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                                            />
                                        </svg>
                                        <span>{{
                                            props.data?.mobile_no ||
                                            "Add your phone"
                                        }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-8">
                            <div>
                                <h3 class="text-gray-500 font-bold mb-4">
                                    My Listings Last 7 Days
                                </h3>
                                <div class="grid grid-cols-3 gap-4">
                                    <div
                                        class="bg-yellow-50 p-4 rounded-lg text-center transition-transform hover:scale-105"
                                    >
                                        <p class="text-2xl text-yellow-600">
                                            {{ wishlistCount }}
                                        </p>
                                        <p class="text-gray-600 text-sm">
                                            Properties in Wishlist
                                        </p>
                                    </div>
                                    <div
                                        class="bg-red-50 p-4 rounded-lg text-center transition-transform hover:scale-105"
                                    >
                                        <p class="text-2xl text-red-600">
                                            {{ cartsCount }}
                                        </p>
                                        <p class="text-gray-600 text-sm">
                                            Properties in Carts
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Completion Card (4 columns) -->
            <div class="bg-white rounded-xl shadow-sm p-4 lg:col-span-4">
                <h2 class="text-xl font-semibold text-gray-800 mb-6">
                    Profile Completion
                </h2>

                <div class="flex items-start space-x-8">
                    <!-- Pie Chart -->
                    <div class="relative w-32 h-32">
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
                            <text
                                x="18"
                                y="18"
                                text-anchor="middle"
                                dominant-baseline="central"
                                class="text-xs font-bold"
                            >
                                {{ profileCompletion }}%
                            </text>
                        </svg>
                    </div>

                    <!-- Completion Checklist -->
                    <div class="flex-grow space-y-3">
                        <div
                            v-for="(item, index) in completionItems"
                            :key="index"
                            class="flex items-center"
                        >
                            <div
                                :class="
                                    item.completed
                                        ? 'bg-green-100'
                                        : 'bg-gray-100'
                                "
                                class="rounded-full p-1 mr-3"
                            >
                                <svg
                                    :class="
                                        item.completed
                                            ? 'text-green-500'
                                            : 'text-gray-400'
                                    "
                                    class="w-4 h-4"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                >
                                    <path
                                        v-if="item.completed"
                                        fill-rule="evenodd"
                                        clip-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                    />
                                    <path
                                        v-else
                                        d="M10 3a7 7 0 100 14 7 7 0 000-14zm-1 10V7h2v6H9z"
                                    />
                                </svg>
                            </div>
                            <span
                                :class="
                                    item.completed
                                        ? 'text-gray-800'
                                        : 'text-gray-600'
                                "
                                class="text-sm"
                            >
                                {{ item.text }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Buttons for testimonials and profile completion -->
                <div class="mt-4 flex flex-col space-y-4">
                    <button
                        @click="$refs.mediaModal.openModal()"
                        class="flex items-center w-auto mx-auto bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700"
                    >
                        <span class="mdi mdi-file-document mr-2"></span>
                        <!-- Document Icon -->
                        Add Testimonial
                    </button>

                    <button
                        @click="openProfileEditor"
                        class="flex items-center w-auto mx-auto bg-green-600 text-white font-semibold px-4 py-2 rounded hover:bg-green-700"
                    >
                        <span class="mdi mdi-account-edit mr-2"></span>
                        <!-- Account Edit Icon -->
                        Complete Profile
                    </button>
                </div>
            </div>
            <div
                v-if="showProfileEditor"
                class="fixed inset-0 w-full bg-black bg-opacity-50 z-50 flex items-center justify-center"
            >
                <div
                    class="bg-white rounded-lg p-10 w-full max-w-7xl mx-auto shadow-box-circle dark:bg-dark-1000"
                >
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-800">
                            Edit Profile
                        </h2>
                        <button
                            @click="showProfileEditor = false"
                            class="text-gray-400 hover:text-gray-600 transition-colors"
                        >
                            <svg
                                class="w-6 h-6"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </button>
                    </div>

                    <!-- Vueform -->
                    <Vueform
                        v-bind="vueform"
                        :model-value="data"
                        :endpoint="handleSubmit"
                        size="lg"
                    >
                        <template #empty>
                            <FormSteps>
                                <FormStep
                                    name="account"
                                    :elements="[
                                        'basic_info',
                                        'name',
                                        'email',
                                        'mobile_no',
                                    ]"
                                >
                                    Basic Info
                                </FormStep>
                                <FormStep
                                    name="address"
                                    :elements="[
                                        'address_info',
                                        'building_number',
                                        'states',
                                        'cities',
                                        'postal_code',
                                    ]"
                                >
                                    Address Info
                                </FormStep>
                            </FormSteps>

                            <FormElements>
                                <BasicInfo :data="props.data" />
                                <AddressInfo
                                    :data="props.data"
                                    :cities="cities"
                                    :states="states"
                                />
                            </FormElements>
                            <FormStepsControls />
                        </template>
                    </Vueform>
                </div>
            </div>
            <!-- Testimonials -->
            <MediaModal
                ref="mediaModal"
                model="agent"
                :modelId="props.data.id"
                collection="agent_testimonials"
                title="User Photos"
                @update:modelValue="handleMediaUpdate"
            />
        </div>
    </div>
</template>

<script setup>
import { ref, computed, defineProps } from "vue";
import MediaDisplay from "@/Components/MediaDisplay.vue";
import BasicInfo from "../../components/BasicInfo.vue";
import AddressInfo from "../../components/AddressInfo.vue"; // Import the new component
import { router } from "@inertiajs/vue3";
import { toast } from "@/utils/toast.js";
import MediaModal from "@/backend/components/ui/inputs/MediaModal.vue";

// Define props
const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    states: {
        type: Array,
        default: () => [],
    },
    cities: {
        type: Array,
        default: () => [],
    },
    media_url: {
        type: String,
        default: "",
    },
});

const wishlistCount = ref(12); // New ref
const cartsCount = ref(8); // New ref
const showProfileEditor = ref(false);
const data = ref({});
const userData = ref(props.data);
const mediaKey = ref(0);

// console.log(props.data);

// Handle form submission
const handleSubmit = (vueformData, form$) => {
    const formData = form$.requestData;
    const userId = props.data.id;
    try {
        router.put(route("frontend.userProfile.update"), formData, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                showProfileEditor.value = false;
                toast.success("Profile Updated Successfully");
            },
            onError: (errors) => {
                showProfileEditor.value = false;
                console.error("Validation errors:", errors);
                toast.error("Please fix the errors in the form");
            },
        });
    } catch (error) {
        toast.error("An unexpected error occurred");
        console.error(error);
    }
};

// Profile completion tracking
const completionItems = ref([
    {
        text: "Basic Information",
        completed: computed(() => props.data?.name?.trim() !== ""),
    },
    {
        text: "Contact Details",
        completed: computed(
            () => props.data?.email && props.data?.phone !== ""
        ),
    },
    {
        text: "Profile Picture",
        completed: computed(() => {
            const hasValidName = props.data?.name?.trim() !== "";
            const hasValidMediaUrl =
                props.data?.thumb_url !== undefined &&
                !props.data?.thumb_url?.includes("static/images/no_image.jpg");
            return hasValidName && hasValidMediaUrl;
        }),
    },
]);

const profileCompletion = computed(() => {
    const completed = completionItems.value.filter((item) =>
        item.completed.valueOf()
    ).length;
    return Math.round((completed / completionItems.value.length) * 100);
});

const handleMediaUpdate = (newMedia) => {
    if (Array.isArray(newMedia)) {
        data.testimonials = newMedia.map((media) => ({
            id: media.id,
            preview_url: media.preview_url,
            thumb_url: media.thumb_url,
        }));
    }
};

const handleMediaUploadSuccess = (mediaData) => {
    // Update the local userData ref
    userData.value = {
        ...userData.value,
        media_url: mediaData.url,
        preview_url: mediaData.preview_url,
        thumb_url: mediaData.thumb_url,
    };

    // Force re-render of MediaDisplay component
    mediaKey.value++;

    // alert("done");

    // Optionally refresh the page data
    router.reload({ only: ["data"] });
};

const openProfileEditor = () => {
    showProfileEditor.value = true;
};
</script>

<script>
import FrontendLayout from "@/layouts/frontend-layout.vue";
export default {
    layout: FrontendLayout,
};
</script>
<style scoped>
/* Customize the pie chart animation */
svg path:nth-child(2) {
    transition: stroke-dasharray 0.5s ease;
}

/* Ensure Tailwind classes are applied with high specificity */
.badge {
    display: inline-block !important;
    padding: 0.25rem 0.75rem !important;
    border-radius: 9999px !important;
    font-size: 0.875rem !important;
    font-weight: 500 !important;
}

.badge-active {
    background-color: #d1fae5 !important; /* Tailwind's bg-green-100 */
    color: #047857 !important; /* Tailwind's text-green-800 */
}

.badge-inactive {
    background-color: #fee2e2 !important; /* Tailwind's bg-red-100 */
    color: #b91c1c !important; /* Tailwind's text-red-800 */
}
</style>
