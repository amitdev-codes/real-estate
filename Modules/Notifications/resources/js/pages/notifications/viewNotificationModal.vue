<template>
    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-50">
            <!-- Backdrop -->
            <TransitionChild
                as="template"
                enter="duration-300 ease-out"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="duration-200 ease-in"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div class="fixed inset-0 bg-black/50 dark:bg-black/60" />
            </TransitionChild>

            <!-- Modal Panel -->
            <div class="fixed inset-0 overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4">
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95"
                    >
                        <DialogPanel
                            class="w-full max-w-2xl transform overflow-hidden rounded-lg bg-white dark:bg-gray-800 p-6 shadow-xl transition-all"
                        >
                            <!-- Header -->
                            <DialogTitle
                                as="div"
                                class="flex items-center justify-between mb-6"
                            >
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="h-12 w-12 rounded-full flex items-center justify-center bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-200"
                                    >
                                        <i
                                            :class="
                                                currentNotification?.group?.icon
                                            "
                                            class="text-xl"
                                        ></i>
                                    </div>
                                    <div>
                                        <h3
                                            class="text-xl font-semibold text-gray-900 dark:text-white"
                                        >
                                            {{ currentNotification?.title }}
                                        </h3>
                                        <p
                                            class="text-sm text-gray-500 dark:text-gray-400"
                                        >
                                            {{ formatDate(currentNotification?.created_at) }}
                                        </p>
                                    </div>
                                </div>
                                <button
                                    @click="closeModal"
                                    class="text-gray-400 hover:text-gray-500 dark:hover:text-gray-300"
                                >
                                    <span class="sr-only">Close</span>
                                    <svg
                                        class="h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </DialogTitle>

                            <!-- Content -->
                            <div class="space-y-6">
                                <!-- Group and Subgroups -->
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-300">
                                        <div>
                                            <strong>Group:</strong> {{ currentNotification?.group?.name }}
                                        </div>
                                        <div>
                                            <strong>Status:</strong>
                                            <span
                                                :class="[
                                                    'ml-2 px-2 py-1 text-xs font-medium rounded-full',
                                                    currentNotification?.read_at
                                                        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                                        : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                ]"
                                            >
                                                {{ currentNotification?.read_at ? "Read" : "Unread" }}
                                            </span>
                                        </div>
                                    </div>
                                    <div v-if="currentNotification?.subgroups?.length">
                                        <h4 class="font-medium text-gray-900 dark:text-white mb-2">Subgroups</h4>
                                        <div class="flex flex-wrap gap-2">
                                            <span
                                                v-for="subgroup in currentNotification.subgroups"
                                                :key="subgroup.id"
                                                class="px-3 py-1 bg-gray-100 dark:bg-gray-700 rounded-full text-sm text-gray-700 dark:text-gray-300"
                                            >
                                                {{ subgroup.name }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Sender Information -->
                                <div class="space-y-4">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white">Sender Information</h4>
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300">
                                        <p><strong>Full Name:</strong> {{ currentNotification?.sender_name || "N/A" }}</p>
                                        <p><strong>Email:</strong> {{ currentNotification?.email || "N/A" }}</p>
                                        <p><strong>Phone:</strong> {{ currentNotification?.phone || "N/A" }}</p>
                                        <p><strong>Postcode:</strong> {{ currentNotification?.postcode || "N/A" }}</p>
                                    </div>
                                </div>

                                <!-- Message Card -->
                                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                                    <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Message</h4>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        {{ currentNotification?.message }}
                                    </p>
                                </div>

                                <!-- Reply Section -->
                                <div v-if="!currentNotification?.reply && !currentNotification?.replied_at">
                                    <label
                                        for="remarks"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2"
                                    >
                                        Your Reply
                                    </label>
                                    <textarea
                                        id="remarks"
                                        v-model="remarks"
                                        rows="4"
                                        class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white resize-none"
                                        placeholder="Enter your remarks..."
                                    ></textarea>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="mt-6 flex justify-end space-x-3" v-if="!currentNotification?.reply && !currentNotification?.replied_at">
                                <button
                                    @click="closeModal"
                                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                >
                                    Cancel
                                </button>
                                <button
                                    @click="handleReply"
                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                    :disabled="!remarks.trim()"
                                >
                                    Send Reply
                                </button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref } from "vue";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";

const props = defineProps({
    isOpen: Boolean,
    currentNotification: Object,
    formatDate: Function,
});

const emit = defineEmits(["close", "reply"]);
const remarks = ref("");
const closeModal = () => {
    remarks.value = "";
    emit("close");
};

const handleReply = () => {
    if (!remarks.value.trim()) return;

    emit("reply", {
        notificationId: props.currentNotification?.id,
        remarks: remarks.value,
    });

    remarks.value = "";
    closeModal();
};
</script>
