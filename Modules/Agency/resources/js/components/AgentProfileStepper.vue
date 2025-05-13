<template>
    <div>
        <!-- Main Content -->
        <div class="max-w-[90rem] mx-auto">
            <div class="bg-white rounded-xl shadow-sm">
                <!-- Stepper Header -->
                <div class="px-8 py-6 border-b">
                    <div class="flex justify-between">
                        <template v-for="(step, index) in steps" :key="index">
                            <div class="flex flex-col items-center flex-1">
                                <div
                                    class="w-10 h-10 rounded-full flex items-center justify-center"
                                    :class="[
                                        currentStep === index
                                            ? 'bg-blue-600 text-white'
                                            : currentStep > index
                                            ? 'bg-green-500 text-white'
                                            : 'bg-gray-200 text-gray-600',
                                    ]"
                                >
                                    <span v-if="currentStep > index">✓</span>
                                    <span v-else>{{ index + 1 }}</span>
                                </div>
                                <span
                                    class="mt-2 text-sm font-medium"
                                    :class="
                                        currentStep === index
                                            ? 'text-blue-600'
                                            : 'text-gray-600'
                                    "
                                >
                                    {{ step.title }}
                                </span>
                            </div>
                            <div
                                v-if="index < steps.length - 1"
                                class="flex-grow mt-4"
                            >
                                <div class="h-0.5 bg-gray-200"></div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Step Content -->
                <div class="p-8 space-y-6 text-gray-600">
                    <component
                        :is="steps[currentStep].component"
                        :data="currentStepData"
                        :agencies="agencies"
                        @update="updateProfileData"
                    />
                </div>
                <!-- Status Update Dialog -->
                <div
                    v-if="showStatusDialog"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                >
                    <div class="bg-white rounded-lg p-6 w-full max-w-lg">
                        <!-- Increased width here -->
                        <h3 class="text-lg font-semibold mb-4">
                            Update Status
                        </h3>

                        <div class="space-y-8">
                            <!-- Dropdown for selecting status -->
                            <div class="flex flex-col space-y-2">
                                <label
                                    for="status"
                                    class="block text-sm font-medium"
                                    >Status</label
                                >
                                <select
                                    id="status"
                                    v-model="selectedStatus"
                                    class="w-full border rounded-md p-2"
                                >
                                    <option value="active">Approve</option>
                                    <option value="pending">Reject</option>
                                    <option value="suspended">Suspend</option>
                                </select>
                            </div>

                            <!-- Remarks field (only show when status is not approved) -->
                            <div
                                v-if="selectedStatus !== 'active'"
                                class="space-y-2"
                            >
                                <label
                                    for="remarks"
                                    class="block text-sm font-medium"
                                    >Remarks</label
                                >
                                <textarea
                                    id="remarks"
                                    v-model="remarks"
                                    class="w-full border rounded-md p-2"
                                    :class="{ 'border-red-500': remarksError }"
                                    rows="3"
                                ></textarea>
                                <p
                                    v-if="remarksError"
                                    class="text-red-500 text-sm"
                                >
                                    {{ remarksError }}
                                </p>
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-end space-x-3 mt-4">
                                <button
                                    @click="closeStatusDialog"
                                    class="px-4 py-2 border rounded-md hover:bg-gray-50"
                                >
                                    Cancel
                                </button>
                                <button
                                    @click="submitStatus"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700"
                                >
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="px-8 py-6 border-t flex justify-between">
                    <button
                        v-if="currentStep > 0"
                        @click="handleStepChange('prev')"
                        class="px-6 py-2.5 border rounded-md hover:bg-gray-50 font-medium"
                    >
                        Previous
                    </button>
                    <button
                        v-if="currentStep < steps.length - 1"
                        @click="handleStepChange('next')"
                        class="ml-auto px-6 py-2.5 bg-blue-600 text-white rounded-md hover:bg-blue-700 font-medium"
                    >
                        Continue
                    </button>
                    <button
                        v-if="currentStep === steps.length - 1"
                        @click="openStatusDialog"
                        class="px-6 py-2.5 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium"
                    >
                        Update Status
                    </button>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import BasicInfo from "../../../../Agent/resources/js/components/BasicInfo.vue";
import Professional from "../../../../Agent/resources/js/components/Professional.vue";
import ServiceAreas from "../../../../Agent/resources/js/components/ServiceAreas.vue";
import BioPhoto from "../../../../Agent/resources/js/components/BioPhoto.vue";
import Testimonials from "../../../../Agent/resources/js/components/Testimonials.vue";

import { router } from "@inertiajs/vue3";
import { toast } from "@/utils/toast.js";
import Swal from "sweetalert2";

// const props = usePage().props;
const props = defineProps({
    data: {
        type: Object,
        default: () => ({}),
    },
    agencies: {
        type: Array,
        default: () => ({}),
    },
});

const showStatusDialog = ref(false);
const selectedStatus = ref("approved");
const remarks = ref("");
const remarksError = ref("");

const steps = ref([
    { title: "Basic Info", component: BasicInfo },
    { title: "Professional", component: Professional },
    { title: "Service Areas", component: ServiceAreas },
    { title: "Bio & Photo", component: BioPhoto },
    { title: "Testimonials", component: Testimonials },
]);

const currentStep = ref(0);
const profileData = ref({
    first_name: props.data?.first_name || "",
    last_name: props.data?.last_name || "",
    email: props.data?.email || "",
    phone: props.data?.phone || "",
    license_number: props.data?.license_number || "",
    experience: props.data?.experience || "",
    agency_id: props.data?.agency_id || "",
    primary_area: props.data?.primary_area || [],
    additional_areas: props.data?.additional_areas || [],
    short_description: props.data?.short_description || "",
    image: null,
    modelId: props.data?.id || "",
    media_url: props.data?.media_url || "",
    specializations: props.data?.specializations || [],
    testimonials: props.data?.testimonials || [],
});

const currentStepData = computed(() => {
    switch (currentStep.value) {
        case 0:
            return {
                first_name: profileData.value.first_name,
                last_name: profileData.value.last_name,
                email: profileData.value.email,
                phone: profileData.value.phone,
            };
        case 1:
            return {
                license_number: profileData.value.license_number,
                experience: profileData.value.experience,
                agency_id: profileData.value.agency_id,
            };
        case 2:
            return {
                primary_area: profileData.value.primary_area,
                additional_areas: profileData.value.additional_areas,
            };
        case 3:
            return {
                modelId: props.data.id,
                image: profileData.value.image,
                specializations: profileData.value.specializations,
                short_description: profileData.value.short_description,
                media_url: profileData.value.media_url,
            };
        case 4:
            return {
                modelId: props.data.id,
                testimonials: profileData.value.testimonials,
            };
        default:
            return {};
    }
});

const updateProfileData = (newData) => {
    profileData.value = {
        ...profileData.value,
        ...newData,
    };
};

const validateStep = (step, data) => {
    switch (step) {
        case 0:
            return {
                isValid:
                    data.first_name &&
                    data.last_name &&
                    data.email &&
                    data.phone,
                fields: ["first name", "last name", "email", "phone number"],
            };
        case 1:
            return {
                isValid:
                    data.license_number && data.experience && data.agency_id,
                fields: ["license number", "experience", "agency_id"],
            };
        case 2:
            return {
                isValid: data.primary_area?.length > 0,
                fields: ["primary area"],
            };
        case 3:
            return {
                isValid:
                    data.short_description && data.specializations?.length > 0,
                fields: ["description", "specializations"],
            };
        case 4:
            return {
                isValid: true, // Testimonials are optional
                fields: [],
            };
    }
};

const handleStepChange = (direction) => {
    const validation = validateStep(currentStep.value, currentStepData.value);

    if (direction === "next" && !validation.isValid) {
        Swal.fire({
            title: "Required Fields Missing",
            text: `Please fill in all required fields: ${validation.fields.join(
                ", "
            )}`,
            icon: "warning",
            confirmButtonColor: "#3B82F6",
        });
        return;
    }

    currentStep.value += direction === "next" ? 1 : -1;
};
const openStatusDialog = () => {
    showStatusDialog.value = true;
};

const closeStatusDialog = () => {
    showStatusDialog.value = false;
    selectedStatus.value = "approved";
    remarks.value = "";
    remarksError.value = "";
};

const submitStatus = () => {
    if (
        (selectedStatus.value === "suspended" ||
            selectedStatus.value === "suspended") &&
        !remarks.value.trim()
    ) {
        remarksError.value =
            "Remarks are required for reject or suspend status";
        return;
    }

    const formData = new FormData();
    formData.append("status", selectedStatus.value);
    formData.append("remarks", remarks.value);
    formData.append("_method", "PUT");

    router.post(route("agency.agents.update", props.data.id), formData, {
        onSuccess: () => {
            toast.success("Status Updated Successfully");
            closeStatusDialog();
        },
        onError: (errors) => {
            console.error("Validation errors:", errors);
            toast.error("Failed to update status");
        },
    });
};
defineExpose({
    currentStep,
    profileData,
    currentStepData,
    handleStepChange,
    //   saveProfile,
    submitStatus,
});
</script>
