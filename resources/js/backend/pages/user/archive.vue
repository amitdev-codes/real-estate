<template>
    <StepperForm
        :show="showProfileEditor"
        title="Archive User Profile"
        :steps="filteredFormSteps" 
        :model-value="data"
        :submit-handler="
            (vueformData, form$) =>
                handleSubmit(
                    vueformData,
                    form$,
                    'users.archive.update',
                    props.data.id,
                    () => (showProfileEditor = false)
                )
        "
        @close="showProfileEditor = false"
    >
        <template #default>
            <UserDetails :data="props.data" />
            <AgentDetails
                v-if="props.data.primary_role === 'Agent'"
                :data="props.data"
            />
            <AgencyDetails
                v-else-if="props.data.primary_role === 'Agency'"
                :data="props.data"
            />
           <AddressDetails :data="props.data" />
            <PersonalBioDetails :data="props.data" /> 
        </template>
    </StepperForm>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";  // Added computed
import { useRoute, useRouter } from "vue-router";
import axios from "axios";
import { toast } from "vue3-toastify";
import UserDetails from "./components/UserDetails.vue";
import AgentDetails from "./components/AgentDetails.vue";
import AgencyDetails from "./components/AgencyDetails.vue";
import AddressDetails from "./components/AddressDetails.vue";
import PersonalBioDetails from "./components/PersonalBioDetails.vue";
import StepperForm from "@components/StepperForm.vue";

const props = defineProps({
    data: { type: Object, default: () => ({}) },
    agencies: { type: Array, default: () => ([]) },  // Fixed default value to array
});

const data = ref({});
const showProfileEditor = ref(true);  // Added since it's used in template

const baseFormSteps = [  // Renamed to baseFormSteps for clarity
    {
        name: "UserDetails",
        label: "UserDetails",
        elements: ["basic_info", "name", "email", "mobile_no", "status"],
    },
    {
        name: "AgentDetails",  // Split into specific Agent details
        label: "Agent Details",
        elements: ["license_number", "experience", "professional"],
    },
    {
        name: "AgencyDetails",  // Added Agency-specific step
        label: "Agency Details",
        elements: ["website", "registered_agency_number","description", "short_description"],  // Adjust elements as needed
    },
    {
        name: "AddressDetails",
        label: "AddressDetails",
        elements: ["street", "building_number", "city", "state", "country", "postal_code", "latitude", "longitude"], // Adjust elements as needed
    },
    {
        name: "PersonalBioDetails",
        label: "PersonalBioDetails",
        elements: ["image"],
    },
];

// Compute filtered steps based on role
const filteredFormSteps = computed(() => {
    if (props.data.primary_role === 'Agent') {
        return baseFormSteps.filter(step => 
            step.name !== 'AgencyDetails'
        );
    } else if (props.data.primary_role === 'Agency') {
        return baseFormSteps.filter(step => 
            step.name !== 'AgentDetails'
        );
    }
    return baseFormSteps;  // Default case if no role is specified
});

const handleSubmit = () => {
    toast.info("This is a read-only archive form.");
};
</script>

<script>
import BackendLayout from "@/layouts/backend-layout.vue";

export default {
    layout: BackendLayout,
};
</script>