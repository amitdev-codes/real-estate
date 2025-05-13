<template>
    <div
        v-show="dropdownOpen2"
        class="dropdown-menu absolute end-0 m-0 mt-4 z-10 w-80 rounded-md overflow-hidden bg-white dark:bg-slate-900 shadow dark:shadow-gray-700"
    >
        <div class="px-4 py-4 flex justify-between items-center">
            <span class="font-semibold">Notifications</span>
            <span
                v-if="unreadCount > 0"
                class="flex items-center justify-center bg-red-600/20 text-red-600 text-[10px] font-bold rounded-md w-5 max-h-5 ms-1"
            >
                {{ unreadCount }}
            </span>
        </div>

        <!-- Group Tabs -->
        <div class="px-4 border-b border-gray-100 dark:border-gray-800">
            <div class="flex space-x-4">
                <button
                    v-for="group in notificationGroups"
                    :key="group.id"
                    @click="selectedGroup = group.id"
                    :class="[
                        'py-2 px-1 text-sm font-medium border-b-2 transition-colors',
                        selectedGroup === group.id
                            ? 'border-green-600 text-green-600'
                            : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300',
                    ]"
                >
                    {{ group.name }}
                </button>
            </div>
        </div>

        <!-- Notifications List -->
        <div class="overflow-y-auto" style="max-height: 400px">
            <div v-if="loading" class="flex justify-center p-4">
                <div
                    class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-gray-900"
                ></div>
            </div>

            <template v-else>
                <div
                    v-if="filteredNotifications.length === 0"
                    class="text-center py-8 text-gray-500"
                >
                    No notifications in this group
                </div>

                <template v-else>
                    <a
                        v-for="notification in filteredNotifications"
                        :key="notification.id"
                        @click="viewNotification(notification)"
                        class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-slate-800 border-b border-gray-100 dark:border-gray-800 cursor-pointer"
                    >
                        <div class="flex items-center">
                            <div
                                class="h-10 w-10 rounded-md shadow shadow-green-600/10 dark:shadow-gray-700 bg-green-600/10 dark:bg-slate-800 text-green-600 dark:text-white flex items-center justify-center"
                            >
                                <i :class="notification.group.icon"></i>
                            </div>
                            <div class="ms-3 flex-grow">
                                <p
                                    class="text-sm font-medium text-gray-900 dark:text-white"
                                >
                                    {{ notification.title }}
                                </p>
                                <p
                                    class="text-xs text-gray-500 dark:text-gray-400 mt-0.5"
                                >
                                    {{ notification.message }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ formatDate(notification.created_at) }}
                                </p>
                            </div>
                            <div
                                v-if="!notification.read_at"
                                class="h-2 w-2 bg-red-500 rounded-full"
                            ></div>
                        </div>
                    </a>
                </template>
            </template>
        </div>
    </div>

    <!-- View All Link -->
    <div class="p-4 border-t border-gray-100 dark:border-gray-800">
        <a
            @click="viewAllNotifications"
            class="block w-full text-center text-sm text-green-600 hover:text-green-700 font-medium"
        >
            View All Notifications
        </a>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from "vue";
import { router } from "@inertiajs/vue3";
import axios from "axios";

// Props
const props = defineProps({
    dropdownOpen2: Boolean,
});

// State
const loading = ref(true);
const notifications = ref([]);
const notificationGroups = ref([]);
const selectedGroup = ref(null);
const unreadCount = ref(0);

// Computed
const filteredNotifications = computed(() => {
    if (!selectedGroup.value) return notifications.value;
    return notifications.value.filter(
        (n) => n.group.id === selectedGroup.value
    );
});



// Methods
const fetchNotifications = async () => {
    try {
        const [notificationsResponse, groupsResponse] = await Promise.all([
            axios.get("/notifications"),
            axios.get("/notification-groups"),
        ]);

        notifications.value = notificationsResponse.data.notifications;
        notificationGroups.value = groupsResponse.data.groups;
        unreadCount.value = notifications.value.filter(
            (n) => !n.read_at
        ).length;

        if (!selectedGroup.value && notificationGroups.value.length > 0) {
            selectedGroup.value = notificationGroups.value[0].id;
        }
    } catch (error) {
        console.error("Error fetching notifications:", error);
    } finally {
        loading.value = false;
    }
};

const viewNotification = async (notification) => {
    if (!notification.read_at) {
        await markAsRead(notification.id);
    }
    router.visit(`/notifications/${notification.id}`);
};

const markAsRead = async (id) => {
    try {
        await axios.post(`/notifications/${id}/mark-as-read`);
        await fetchNotifications();
    } catch (error) {
        console.error("Error marking notification as read:", error);
    }
};

const viewAllNotifications = () => {
    router.visit("/notifications");
};

const formatDate = (date) => {
    return new Date(date).toLocaleDateString(undefined, {
        year: "numeric",
        month: "short",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
    });
};

// Watchers
watch(
    () => props.dropdownOpen2,
    (newValue) => {
        if (newValue) {
            fetchNotifications();
        }
    }
);

// Lifecycle
onMounted(() => {
    if (props.dropdownOpen2) {
        fetchNotifications();
    }
});
</script>
