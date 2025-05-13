<template>
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">
        <div class="flex-1 w-4xl bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
            <!-- Breadcrumb -->
            <div class="bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600 p-4 sm:p-6">
                <nav class="flex items-center space-x-2">
                    <button
                        @click="goBack"
                        class="text-gray-600 dark:text-gray-300 hover:text-gray-800 dark:hover:text-gray-100 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 px-3 py-1 rounded-md text-sm font-medium transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500"
                    >
                        Back
                    </button>
                    <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-300">
                        <inertia-link :href="breadcrumb[0].to" class="hover:text-gray-800 dark:hover:text-gray-100">{{ breadcrumb[0].label }}</inertia-link>
                        <span>/</span>
                        <span class="text-gray-800 dark:text-gray-100 font-medium">{{ breadcrumb[1].label }}</span>
                    </div>
                </nav>
            </div>

            <!-- Header -->
            <div class="bg-green-600 dark:bg-green-700 text-white p-4 sm:p-6 hover:bg-yellow-400 dark:hover:bg-yellow-500 transition-colors duration-300">
                <h4 class="text-lg font-bold">{{ title }}</h4>
                <p class="text-sm mt-1">{{ subtitle }}</p>
            </div>

            <!-- Content (Slot) -->
            <div class="p-4 sm:p-6 flex-1">
                <slot />
            </div>

            <!-- Footer Buttons -->
            <div class="p-4 sm:p-6 bg-gray-50 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-600 flex justify-end space-x-4">
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
                    @click="$emit('submit')"
                />
            </div>
        </div>
    </div>
</template>

<script setup>
import { router } from '@inertiajs/vue3';
import Button from "@/backend/components/ui/buttons/SuccessButton.vue"; // Adjust path if needed

defineProps({
    title: {
        type: String,
        required: true,
    },
    subtitle: {
        type: String,
        default: "",
    },
    breadcrumb: {
        type: Array,
        required: true,
    },
    processing: {
        type: Boolean,
        default: false,
    },
});

const goBack = () => {
    router.visit(window.history.back()); // Use Inertia to go back
};

const cancel = () => {
    router.visit(window.history.back()); // Use Inertia for cancel as well
};
</script>