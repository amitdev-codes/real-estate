<template>
    <div
        v-if="isOpen"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        @click.self="closeModal"
    >
        <div
            class="bg-white rounded-lg shadow-lg w-11/12 max-w-4xl overflow-hidden"
        >
            <!-- Header -->
            <div class="flex justify-between items-center p-6 border-b">
                <h2 class="text-xl font-semibold">{{ dynamicTitle }}</h2>
                <button
                    @click="closeModal"
                    class="text-gray-500 hover:text-gray-700"
                >
                    <i class="mdi mdi-close"></i>
                </button>
            </div>

            <!-- Body: Two Columns -->
            <Vueform
                :endpoint="route('notifications.store')"
                size="sm"
                :display-errors="false"
                @success="handleSuccess"
                @error="handleError"
            >
                <template #empty>
                    <div
                        class="bg-white rounded-lg p-6 w-full max-w-7xl mx-auto"
                    >
                        <!-- Two-Column Layout -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column: Enquiry Type and Message -->
                            <div>
                                <!-- Checkboxes for Enquiry Types -->
                                <GroupElement
                                    name="enquiry_types"
                                    label="Enquiry Types"
                                >
                                    <HiddenElement
                                        name="notification_group_id"
                                        :default="props.notificationGroupId"
                                    />
                                    <TagsElement
                                        :native="false"
                                        name="notification_sub_group_ids"
                                        rules="required"
                                        :items="props.notificationSubGroups"
                                    />
                                </GroupElement>

                                <TextareaElement
                                    name="message"
                                    label="Message"
                                    rules="required"
                                    :autogrow="true"
                                />
                            </div>

                            <!-- Right Column: Contact Information -->
                            <div>
                                <GroupElement
                                    name="contact_details"
                                    label="Contact Information"
                                >
                                    <TextElement
                                        name="first_name"
                                        label="First Name *"
                                        rules="required"
                                    />
                                    <TextElement
                                        name="last_name"
                                        label="Last Name *"
                                        rules="required"
                                    />
                                    <TextElement
                                        name="email"
                                        label="Email *"
                                        type="email"
                                        rules="required|email"
                                        :disabled="!!usePage().props.auth.user"
                                        :default="
                                            usePage().props.auth.user
                                                ? usePage().props.auth.user
                                                      .email
                                                : null
                                        "
                                    />
                                    <PhoneElement
                                        :default="
                                            usePage().props.auth.user
                                                ? usePage().props.auth.user
                                                      .mobile_no
                                                : +61
                                        "
                                        name="phone"
                                        label="Mobile Number"
                                        :allow-incomplete="true"
                                        :unmask="true"
                                        :include="[
                                            'Au',
                                            'us',
                                            'gb',
                                            'de',
                                            'np',
                                        ]"
                                        rules="required"
                                        size="sm"
                                    />

                                    <TextElement
                                        name="postcode"
                                        label="Postcode *"
                                        rules="required"
                                    />
                                </GroupElement>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="mt-6 border-t pt-6">
                            <ButtonElement full name="submit" submits>
                                Submit
                            </ButtonElement>
                        </div>
                    </div>
                </template>
            </Vueform>
        </div>
    </div>
</template>

<script setup>
import { ref, defineEmits } from "vue";
import { usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

// Modal state
const isOpen = ref(false);
const dynamicTitle = ref("");
const props = defineProps({
    notificationSubGroups: Array,
    notificationGroupId: Object,
});

// Open modal
const openModal = (title) => {
    dynamicTitle.value = title;
    isOpen.value = true;
};

const closeModal = () => {
    isOpen.value = false;
};

// Handle form submission success
const handleSuccess = (response, form$) => {
    toast.success(response.data.message);
    isOpen.value = false;
};

const handleError = (errors, details, form$) => {
    form$.messageBag.clear();
    if (errors.response?.data?.errors) {
        Object.entries(errors.response.data.errors).forEach(
            ([field, messages]) => {
                let messageBag = form$.el$(field)?.messageBag;
                if (messageBag) {
                    messageBag.clear();
                    messages.forEach((message) => messageBag.append(message));
                }
            }
        );
    } else {
        // Handle general error
        form$.messageBag.append(
            "An error occurred. Please try again.",
            "error"
        );
    }
};

// Expose openModal to parent component
defineExpose({ openModal });
</script>

<style scoped></style>
