<template>
    <BreadcrumbAndPageTitle
        :pageTitle="
            (modelName || resourceName || 'notifications')
                .charAt(0)
                .toUpperCase() +
            (modelName || resourceName || 'notifications').slice(1)
        "
        :breadcrumbs="breadcrumbs"
        style="margin-bottom: 16px"
    />
    <div
        class="w-full p-4 bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg"
    >
        <!-- Filters and Bulk Actions-->
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <button
                        @click="isFilterModalOpen = true"
                        class="flex items-center space-x-2 px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors"
                    >
                        <span>Filters</span>
                        <i class="mdi mdi-filter"></i>
                    </button>

                    <button
                        v-if="selectedNotifications.length > 0"
                        @click="handleBulkDelete(selectedNotifications)"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors"
                    >
                        Delete Selected ({{ selectedNotifications.length }})
                    </button>
                    <button
                        v-if="selectedNotifications.length > 0"
                        @click="handleBulkMarkAsRead(selectedNotifications)"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-yellow-600 transition-colors"
                    >
                        Mark As Read ({{ selectedNotifications.length }})
                    </button>
                </div>

                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ filteredNotifications.length }} notifications
                </div>
            </div>
        </div>

        <!-- Notifications Table -->
        <div class="overflow-x-auto">
            <table
                class="min-w-full divide-y divide-gray-200 border-collapse rounded-lg overflow-hidden dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200"
            >
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <!-- Existing Checkbox Column -->
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            <input
                                type="checkbox"
                                v-model="selectAll"
                                @change="toggleSelectAll"
                                class="rounded border-gray-300 text-green-500 focus:ring-green-500 w-4 h-4"
                            />
                        </th>
                        <!-- Existing Notification Column -->
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Notification
                        </th>
                        <!-- Group Column -->
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Group
                        </th>
                        <!-- Subgroup Column -->
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Subgroup
                        </th>
                        <!-- Sender Name Column -->
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Sender Name
                        </th>
                        <!-- Sender Email Column -->
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Sender Email
                        </th>
                        <!-- Existing Status and Date Columns -->
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Status
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Date
                        </th>
                        <!-- Existing Actions Column -->
                        <th
                            class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider"
                        >
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody
                    class="bg-white divide-y divide-gray-200 dark:bg-gray-800"
                >
                    <tr
                        v-for="notification in paginatedNotifications"
                        :key="notification.id"
                        class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                    >
                        <!-- Existing Checkbox Cell -->
                        <td class="px-6 py-4">
                            <input
                                type="checkbox"
                                v-model="selectedNotifications"
                                :value="notification.id"
                                class="rounded border-gray-300 focus:ring-green-500 w-4 h-4"
                            />
                        </td>
                        <!-- Existing Notification Cell -->
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <div
                                        class="h-10 w-10 rounded-full flex items-center justify-center bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-200"
                                    >
                                        <i :class="notification.group.icon"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div
                                        class="text-sm font-medium text-gray-900 dark:text-white"
                                    >
                                        {{ notification.message }}
                                    </div>
                                    <div
                                        class="text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        {{ notification.message }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <!-- Group Cell -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">
                                {{ notification.group.name }}
                            </div>
                            <div
                                class="text-sm text-gray-500 dark:text-gray-400"
                            >
                                {{ notification.group.slug }}
                            </div>
                        </td>
                        <!-- Subgroup Cell -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">
                                <div v-if="notification.subgroups.length">
                                    <span
                                        v-for="subgroup in notification.subgroups"
                                        :key="subgroup.id"
                                    >
                                        {{ subgroup.name
                                        }}<span v-if="!$last">, </span>
                                    </span>
                                </div>
                                <div v-else>N/A</div>
                            </div>
                        </td>
                        <!-- Sender Name Cell -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">
                                {{ notification.sender_name || "N/A" }}
                            </div>
                        </td>
                        <!-- Sender Email Cell -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900 dark:text-white">
                                {{ notification.email || "N/A" }}
                            </div>
                        </td>
                        <!-- Existing Status Cell -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                :class="[
                                    'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                                    notification.read_at
                                        ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200'
                                        : 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                ]"
                            >
                                {{ notification.read_at ? "Read" : "Unread" }}
                            </span>
                        </td>
                        <!-- Existing Date Cell -->
                        <td
                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                        >
                            {{ formatDate(notification.created_at) }}
                        </td>
                        <!-- Existing Actions Cell -->
                        <td
                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                        >
                            <button
                                v-if="!notification.read_at"
                                @click="markAsRead(notification.id)"
                                class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 mr-3"
                            >
                                Mark as Read
                            </button>
                            <button
                                @click="viewNotification(notification)"
                                class="text-green-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 text-lg"
                            >
                                <span class="mdi mdi-eye"></span>
                            </button>
                            <button
                                @click="deleteNotification(notification)"
                                class="px-1 py-2 text-red-500 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 text-lg"
                            >
                                <span class="mdi mdi-delete"></span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-6 border-t border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    Showing {{ paginatedNotifications.length }} of
                    {{ filteredNotifications.length }} notifications
                </div>
                <div class="flex space-x-2">
                    <!-- Previous Button -->
                    <button
                        @click="prevPage"
                        :disabled="currentPage === 1"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors"
                    >
                        Previous
                    </button>

                    <!-- Numbered Pagination -->
                    <button
                        v-for="page in totalPages"
                        :key="page"
                        @click="currentPage = page"
                        :class="[
                            'px-4 py-2 text-sm font-medium rounded-md transition-colors',
                            currentPage === page
                                ? 'bg-green-500 text-white'
                                : 'text-gray-700 bg-gray-200 hover:bg-gray-300 dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600',
                        ]"
                    >
                        {{ page }}
                    </button>

                    <!-- Next Button -->
                    <button
                        @click="nextPage"
                        :disabled="currentPage === totalPages"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-md hover:bg-gray-300 dark:text-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 transition-colors"
                    >
                        Next
                    </button>
                </div>
            </div>
        </div>

        <!-- Filter Modal -->
        <div
            v-if="isFilterModalOpen"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
        >
            <div
                class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-11/12 md:w-1/2 p-6"
            >
                <div class="flex justify-between items-center mb-4">
                    <h3
                        class="text-lg font-semibold text-gray-900 dark:text-white"
                    >
                        Filters
                    </h3>
                    <button
                        @click="isFilterModalOpen = false"
                        class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
                    >
                        <i class="mdi mdi-close"></i>
                    </button>
                </div>
                <div class="space-y-4">
                    <!-- Group Filter -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Group</label
                        >
                        <select
                            v-model="selectedGroup"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        >
                            <option value="">All Groups</option>
                            <option
                                v-for="group in groups"
                                :key="group.id"
                                :value="group.id"
                            >
                                {{ group.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Read Status Filter -->
                    <div>
                        <label
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Status</label
                        >
                        <select
                            v-model="readStatus"
                            class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                        >
                            <option value="">All Status</option>
                            <option value="read">Read</option>
                            <option value="unread">Unread</option>
                        </select>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button
                        @click="isFilterModalOpen = false"
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>

        <!-- Notification Modal (Existing Code) -->
        <NotificationModal
            :is-open="isModalOpen"
            :current-notification="currentNotification"
            :format-date="formatDate"
            @close="isModalOpen = false"
            @reply="handleNotificationReply"
        />
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import BreadcrumbAndPageTitle from "@backend-components/ui/breadcrumb-and-page-title.vue";

import NotificationModal from "./viewNotificationModal.vue";

import { useDelete } from "@/utils/delete";
import { toast } from "vue3-toastify";

const props = defineProps({
    notifications: {
        type: Object,
        required: true,
    },
    groups: {
        type: Array,
        required: true,
    },
    subGroups: {
        type: Array,
        required: true,
    },
});

// State and computed properties
const selectedGroup = ref("");
const readStatus = ref("");
const currentPage = ref(1);
const itemsPerPage = ref(10);
const isModalOpen = ref(false);
const currentNotification = ref(null);
const selectedNotifications = ref([]);
const selectAll = ref(false);
const isFilterModalOpen = ref(false);

const filteredNotifications = computed(() => {
    let filtered = props.notifications.data;

    if (selectedGroup.value) {
        filtered = filtered.filter((n) => n.group.id === selectedGroup.value);
    }

    if (readStatus.value === "read") {
        filtered = filtered.filter((n) => n.read_at);
    } else if (readStatus.value === "unread") {
        filtered = filtered.filter((n) => !n.read_at);
    }

    return filtered;
});

const totalPages = computed(() => {
    return Math.ceil(filteredNotifications.value.length / itemsPerPage.value);
});

const paginatedNotifications = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    const end = start + itemsPerPage.value;
    return filteredNotifications.value.slice(start, end);
});

// Methods
const formatDate = (date) => {
    return new Date(date).toLocaleDateString(undefined, {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

//mark as read
const markAsRead = async (id) => {
    try {
        await router.post(`/notifications/${id}/mark-as-read`);
        router.reload(); // Reload the page to reflect changes
        toast.success("Notification marked as read.");
    } catch (error) {
        console.error("Error marking notification as read:", error);
        toast.error("Error marking notification as read.");
    }
};

const handleBulkMarkAsRead = async () => {
    try {
        await router.post("/notifications/bulk-mark-as-read", {
            ids: selectedNotifications.value,
        });
        router.reload(); // Reload the page to reflect changes
        toast.success("Notifications marked as read.");
    } catch (error) {
        console.error("Error marking notifications as read:", error);
        toast.error("Error marking notifications as read.");
    }
};

const viewNotification = (notification) => {
    currentNotification.value = notification;
    isModalOpen.value = true;
};

const prevPage = () => {
    if (currentPage.value > 1) {
        currentPage.value--;
    }
};

const nextPage = () => {
    if (currentPage.value < totalPages.value) {
        currentPage.value++;
    }
};

const { bulkDelete } = useDelete();

//delete notification
const deleteNotification = async (id) => {
    try {
        await router.delete(route("notifications.destroy", id));
        router.reload(); // Reload the page to reflect changes
        toast.success("Notification deleted successfully.");
    } catch (error) {
        console.error("Error deleting notification:", error);
        toast.error("Error deleting notification.");
    }
};

//bulk delete
const handleBulkDelete = async () => {
    try {
        await router.post("/notifications/bulk-delete", {
            ids: selectedNotifications.value,
        });
        router.reload(); // Reload the page to reflect changes
        toast.success("Notifications deleted successfully.");
    } catch (error) {
        console.error("Error deleting notifications:", error);
        toast.error("Error deleting notifications.");
    }
};

const handleNotificationReply = async ({ notificationId, remarks }) => {
    const { props } = usePage(); // Get the current page props

    try {
        const response = await router.put(
            route("notifications.reply", notificationId), // Use the route helper
            {
                reply: remarks,
            },
            {
                preserveState: false, // Set to true if you want to preserve the current state
                onSuccess: (page) => {
                    toast.success("Reply sent successfully.");
                },
                onError: (errors) => {
                    toast.error("Error sending reply:.");
                },
            }
        );
    } catch (error) {
        console.error("Error sending reply:", error);
    }
};

const toggleSelectAll = () => {
    if (selectAll.value) {
        selectedNotifications.value = paginatedNotifications.value.map(
            (n) => n.id
        );
    } else {
        selectedNotifications.value = [];
    }
};
</script>

<script>
import BackendLayout from "@/layouts/backend-layout.vue";
export default {
    layout: BackendLayout,
};
</script>

<style scoped>
/* Override parent/global styles for checkboxes */
input[type="checkbox"] {
    appearance: none;
    /* Remove default browser styling */
    -webkit-appearance: none;
    /* For Safari */
    width: 16px;
    height: 16px;
    border: 2px solid #d1d5db;
    /* Gray border */
    border-radius: 4px;
    /* Rounded corners */
    background-color: white;
    /* White background */
    cursor: pointer;
    position: relative;
    transition: background-color 0.2s, border-color 0.2s;
}

/* Checked state */
input[type="checkbox"]:checked {
    background-color: #10b981;
    /* Green background */
    border-color: #10b981;
    /* Green border */
}

/* Checkmark icon */
input[type="checkbox"]:checked::after {
    content: "";
    position: absolute;
    left: 4px;
    top: 1px;
    width: 5px;
    height: 10px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

/* Focus state */
input[type="checkbox"]:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.5);
    /* Green focus ring */
}

/* Dark mode styles */
.dark input[type="checkbox"] {
    border-color: #4b5563;
    /* Dark mode border */
    background-color: #374151;
    /* Dark mode background */
}

.dark input[type="checkbox"]:checked {
    background-color: #10b981;
    /* Green background */
    border-color: #10b981;
    /* Green border */
}

.dark input[type="checkbox"]:checked::after {
    border-color: white;
    /* White checkmark */
}
</style>
