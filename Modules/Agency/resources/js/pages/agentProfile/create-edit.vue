<template>
    <FormLayout
        title="Edit Agent Profile"
        subtitle="Review and update agent status"
        :breadcrumb="[
            { label: 'Agents', to: route('agency.agents.index') },
            { label: 'Edit Agent' }
        ]"
        :processing="processing"
        @submit="handleSubmit"
    >
        <!-- Agent Details Section -->
        <div class="border-b border-gray-200 pb-4 sm:pb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Agent Details</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <div class="space-y-3">
                    <p><span class="font-medium text-gray-600">Name:</span> {{ data.name }}</p>
                    <p><span class="font-medium text-gray-600">Email:</span> {{ data.email }}</p>
                    <p><span class="font-medium text-gray-600">Phone:</span> {{ data.phone }}</p>
                    <p><span class="font-medium text-gray-600">License Number:</span> {{ data.license_number }}</p>
                </div>
                <div class="space-y-3">
                    <p><span class="font-medium text-gray-600">Agency:</span> {{ data.agency_name }}</p>
                    <p><span class="font-medium text-gray-600">Experience:</span> {{ data.experience }}</p>
                    <p><span class="font-medium text-gray-600">Primary Area:</span> {{ data.primary_area }}</p>
                    <p><span class="font-medium text-gray-600">Bio:</span> {{ data.short_description || "N/A" }}</p>
                </div>
            </div>
        </div>

        <!-- Profile Picture Section -->
        <div class="border-b border-gray-200 py-4 sm:py-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Profile Picture</h2>
            <div v-if="data.media_url" class="flex justify-center sm:justify-start">
                <img
                    :src="data.media_url"
                    alt="Profile Picture"
                    class="w-32 h-32 sm:w-40 sm:h-40 rounded-full object-cover border-2 border-gray-300 shadow-sm"
                />
            </div>
            <p v-else class="text-gray-500 text-center sm:text-left">No profile picture available</p>
        </div>

        <!-- Testimonials Section -->
        <div class="border-b border-gray-200 py-4 sm:py-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Testimonials</h2>
            <div v-if="testimonials && testimonials.length > 0" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div v-for="testimonial in testimonials" :key="testimonial.id" class="flex justify-center">
                    <img
                        :src="testimonial.url"
                        :alt="`Testimonial ${testimonial.id}`"
                        class="w-32 h-32 sm:w-40 sm:h-40 object-cover rounded-lg border border-gray-300 shadow-sm hover:shadow-md transition-shadow duration-200"
                    />
                </div>
            </div>
            <p v-else class="text-gray-500 text-center sm:text-left">No testimonials available</p>
        </div>

        <!-- Form Section -->
        <form @submit.prevent="handleSubmit" class="p-6 flex-1">
                <div class="space-y-6">
                    <!-- Status Field -->
                    <div>
                        <label
                            for="status"
                            class="block text-sm font-medium text-gray-700"
                            >Status</label
                        >
                        <div class="relative mt-1">
                            <select
                                v-model="form.status"
                                id="status"
                                class="block w-full appearance-none rounded-md border border-gray-300 bg-white py-2 pl-3 pr-10 text-gray-700 shadow-sm focus:border-gray-500 focus:outline-none focus:ring-1 focus:ring-gray-500 sm:text-sm"
                                :class="{ 'border-red-500': errors.status }"
                            >
                                <option value="pending">Pending</option>
                                <option value="active">Active</option>
                                <option value="suspended">Rejected</option>
                            </select>
                            <span
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-2"
                            >
                                <svg
                                    class="h-5 w-5 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M19 9l-7 7-7-7"
                                    ></path>
                                </svg>
                            </span>
                        </div>
                        <p
                            v-if="errors.status"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.status }}
                        </p>
                    </div>

                    <!-- Remarks Field (Shown only if status is not active) -->
                    <div v-if="form.status !== 'active'">
                        <label
                            for="remarks"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Remarks
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            v-model="form.remarks"
                            id="remarks"
                            rows="6"
                            class="mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-gray-500 focus:ring-1 focus:ring-gray-500 sm:text-sm"
                            :class="{ 'border-red-500': errors.remarks }"
                            placeholder="Enter remarks (required for Pending or Rejected status)"
                        ></textarea>
                        <p
                            v-if="errors.remarks"
                            class="mt-1 text-sm text-red-600"
                        >
                            {{ errors.remarks }}
                        </p>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="mt-8 flex justify-end space-x-4">
                    <Button
                        label="Cancel"
                        variant="cancel"
                        :processing="processing"
                        @click="cancel"
                    />
                    <Button
                        label="Submit"
                        variant="success"
                        :processing="processing"
                        type="submit"
                    />
                </div>
        </form>
    </FormLayout>
</template>

<script setup>
import FormLayout from "@components/FormLayout.vue";
import BackendLayout from "@/layouts/backend-layout.vue";
import { router } from "@inertiajs/vue3";
import { ref, watch } from "vue";
import { toast } from "@/utils/toast.js";

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
    testimonials: {
        type: Array,
        default: () => [],
    },
});

const form = ref({
    status: props.data.status,
    remarks: props.data.remarks,
});

const errors = ref({});
const processing = ref(false);

watch(() => form.value.status, (newStatus) => {
    if (!['pending', 'rejected'].includes(newStatus)) {
        form.value.remarks = '';
    }
});

const handleSubmit = () => {
    errors.value = {};
    processing.value = true;

    if (!form.value.status) {
        errors.value.status = "Status is required";
    }
    if (['pending', 'suspended'].includes(form.value.status) && !form.value.remarks) {
        errors.value.remarks = "Remarks are required for Pending or Rejected status";
    }

    if (Object.keys(errors.value).length > 0) {
        toast.error("Please fix the errors in the form");
        processing.value = false;
        return;
    }

    router.put(route("agency.agents.update", props.data.id), form.value, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("Agent status updated successfully");
            router.visit(route("agency.agents.index"));
        },
        onError: (serverErrors) => {
            errors.value = serverErrors;
            toast.error("Please fix the errors in the form");
            processing.value = false;
        },
        onFinish: () => {
            processing.value = false;
        },
    });
};
</script>

<script>
export default {
    layout: BackendLayout,
};
</script>