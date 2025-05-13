<template>
    <div class="property-enquiry-form">
        <form @submit.prevent="submitEnquiry">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label>Name</label>
                    <input v-model="form.contact_name" type="text" required />
                </div>
                <div>
                    <label>Email</label>
                    <input v-model="form.contact_email" type="email" required />
                </div>
                <div>
                    <label>Phone</label>
                    <input v-model="form.contact_phone" type="tel" />
                </div>
                <div>
                    <label>Preferred Contact Method</label>
                    <select v-model="form.preferred_contact_method">
                        <option value="email">Email</option>
                        <option value="phone">Phone</option>
                        <option value="both">Both</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <label>Enquiry Type</label>
                <div class="flex space-x-4">
                    <label v-for="type in enquiryTypes" :key="type.value">
                        <input
                            type="radio"
                            v-model="form.enquiry_type"
                            :value="type.value"
                        />
                        {{ type.label }}
                    </label>
                </div>
            </div>

            <div class="mt-4">
                <label>Additional Preferences</label>
                <div class="flex space-x-4">
                    <label v-for="pref in contactPreferences" :key="pref.value">
                        <input
                            type="checkbox"
                            v-model="form.contact_preferences"
                            :value="pref.value"
                        />
                        {{ pref.label }}
                    </label>
                </div>
            </div>

            <div class="mt-4">
                <label>Message</label>
                <textarea v-model="form.message" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Submit Enquiry
            </button>
        </form>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
    property: Object,
});

const form = useForm({
    property_id: props.property?.id||null,
    contact_name: "",
    contact_email: "",
    contact_phone: "",
    preferred_contact_method: "email",
    enquiry_type: "general_inquiry",
    message: "",
    contact_preferences: [],
});

const enquiryTypes = [
    { value: "general_inquiry", label: "General Inquiry" },
    { value: "pricing", label: "Pricing" },
    { value: "availability", label: "Availability" },
    { value: "inspection", label: "Inspection" },
    { value: "other", label: "Other" },
];

const contactPreferences = [
    { value: "email_updates", label: "Email Updates" },
    { value: "sms_alerts", label: "SMS Alerts" },
    { value: "brochure", label: "Request Brochure" },
];

const submitEnquiry = () => {
    form.post(route("property.enquiry.store"));
};
</script>
<script>
import frontendLayout from "@/layouts/frontend-layout.vue";
export default {
  layout: BackendLayout,
};
</script>
