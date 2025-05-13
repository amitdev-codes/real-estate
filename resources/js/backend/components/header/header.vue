<template>
    <!-- Top Header -->
    <div class="top-header">
        <div class="header-bar flex justify-between">
            <div class="flex items-center space-x-1">
                <!-- Logo -->
                <a href="#" class="xl:hidden block me-2">
                    <img
                        src="@backend-assets/images/logo-icon-32.png"
                        class="md:hidden block"
                        alt=""
                    />
                    <span class="md:block hidden">
                        <img
                            src="@backend-assets/images/logo-dark.png"
                            class="inline-block dark:hidden"
                            alt=""
                        />
                        <img
                            src="@backend-assets/images/logo-dark.png"
                            class="hidden dark:inline-block"
                            alt=""
                        />
                    </span>
                </a>
                <!-- Show or close sidebar -->
                <a
                    @click="handlerClick"
                    id="close-sidebar"
                    class="h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-white rounded-md"
                    href="javascript:void(0)"
                >
                    <i data-feather="menu" class="h-4 w-4"></i>
                </a>
                <!-- Frontend Navigation -->
                <div class="ps-1.5">
                    <div class="form-icon relative sm:block hidden">
                        <a
                            href="/"
                            target="_blank"
                            class="h-8 w-32 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[15px] text-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-white rounded-md"
                        >
                            <i class="mdi mdi-home-outline text-[28px]"></i>
                            Homepage
                        </a>
                    </div>
                </div>
            </div>

            <ul class="list-none mb-0 space-x-1">
                <!-- Notification Dropdown -->
                <li class="dropdown inline-block relative">
                    <button
                        @click="dropdownOpen2 = !dropdownOpen2"
                        class="dropdown-toggle h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-white rounded-md"
                    >
                        <i data-feather="bell" class="h-4 w-4"></i>
                        <span
                            v-if="unreadCount > 0"
                            class="absolute -top-1 -right-1 flex items-center justify-center bg-red-500 text-white text-[10px] font-bold rounded-full w-4 h-4"
                        >
                            {{ unreadCount }}
                        </span>
                    </button>
                    <div
                        v-show="dropdownOpen2"
                        class="dropdown-menu absolute end-0 m-0 mt-4 z-10 w-96 rounded-lg overflow-hidden bg-white dark:bg-slate-900 shadow-lg dark:shadow-gray-700"
                        ref="dropdown2"
                    >
                        <div
                            class="px-4 py-3 bg-gray-50 dark:bg-slate-800 flex justify-between items-center"
                        >
                            <h3 class="text-sm font-semibold text-slate-700 dark:text-white">
                                Notifications
                            </h3>
                            <span class="text-xs text-slate-500 dark:text-slate-400">
                                {{ unreadCount }} Unread
                            </span>
                        </div>
                        <div class="max-h-[400px] overflow-y-auto">
                            <template v-if="hasNotifications">
                                <div
                                    v-for="(group, groupName) in filteredNotifications"
                                    :key="groupName"
                                    class="border-b last:border-b-0 border-gray-100 dark:border-slate-700"
                                >
                                    <div class="px-4 py-2 bg-gray-100 dark:bg-slate-800">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center mr-3"
                                            >
                                                <i
                                                    :data-feather="getGroupIcon(groupName)"
                                                    class="h-5 w-5 text-blue-600 dark:text-blue-300"
                                                ></i>
                                            </div>
                                            <h4 class="font-semibold text-slate-700 dark:text-white">
                                                {{ groupName }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="pl-12 pr-4">
                                        <div
                                            v-for="message in group.slice(0, 2)"
                                            :key="message.id"
                                            class="py-3 border-b last:border-b-0 border-gray-100 dark:border-slate-700"
                                        >
                                            <div
                                                @click="viewNotification(message.id)"
                                                class="cursor-pointer hover:bg-gray-50 dark:hover:bg-slate-800 p-2 rounded"
                                            >
                                                <div class="flex items-start space-x-3">
                                                    <div
                                                        class="w-2 h-2 bg-blue-500 rounded-full mt-2 flex-shrink-0"
                                                    ></div>
                                                    <div class="flex-grow">
                                                        <div class="flex justify-between items-center">
                                                            <h6 class="text-sm font-medium text-slate-700 dark:text-white">
                                                                {{ message.title }}
                                                            </h6>
                                                            <small class="text-xs text-slate-400 dark:text-slate-500">
                                                                {{ formatTimeAgo(message.created_at) }}
                                                            </small>
                                                        </div>
                                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                                            {{ message.message }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-if="group.length > 2" class="py-2 text-center">
                                            <button
                                                @click="viewGroupNotifications(groupName)"
                                                class="text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                                            >
                                                View {{ group.length - 2 }} more
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <div
                                v-else
                                class="text-center py-6 text-slate-500 dark:text-slate-400"
                            >
                                No notifications
                            </div>
                        </div>
                        <div class="px-4 py-2 border-t border-gray-100 dark:border-slate-700">
                            <button
                                @click="viewAllNotifications"
                                class="w-full text-center text-sm text-blue-600 hover:text-blue-700 dark:text-blue-400 dark:hover:text-blue-300"
                            >
                                View All Notifications
                            </button>
                        </div>
                    </div>
                </li>

                <!-- User/Profile Dropdown -->
                <li class="dropdown inline-block relative">
                    <button
                        @click="dropdownOpen3 = !dropdownOpen3"
                        class="dropdown-toggle h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-white rounded-md"
                    >
                        <ProfileImage />
                    </button>
                    <div
                        v-show="dropdownOpen3"
                        class="dropdown-menu absolute end-0 m-0 mt-4 z-10 w-44 rounded-md overflow-hidden bg-white dark:bg-slate-900 shadow dark:shadow-gray-700"
                        ref="dropdown3"
                    >
                        <ul class="py-2 text-start">
                            <li>
                                <button
                                    @click="profile"
                                    class="block py-1 px-4 dark:text-white/70 hover:text-green-600 dark:hover:text-white"
                                >
                                    <i class="mdi mdi-account-outline me-2"></i>Profile
                                </button>
                            </li>
                            <li v-if="$page.props.auth.user && !$page.props.auth.user.roles.includes('Agency')">
                                <Link
                                    :href="route('profile-setting')"
                                    class="block py-1 px-4 dark:text-white/70 hover:text-green-600 dark:hover:text-white"
                                    @click="closeDropdown3"
                                >
                                    <i class="mdi mdi-cog-outline me-2"></i>Settings
                                </Link>
                            </li>
                            <li>
                                <button
                                    @click="logout"
                                    class="block py-1 px-4 dark:text-white/70 hover:text-green-600 dark:hover:text-white"
                                >
                                    <i class="mdi mdi-logout me-2"></i>Logout
                                </button>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";
import { router, Link, usePage } from "@inertiajs/vue3";
import feather from "feather-icons";
import ProfileImage from "@backend-components/ProfileImage.vue";

const dropdownOpen2 = ref(false);
const dropdownOpen3 = ref(false);
const dropdown2 = ref(null); // Ref for notification dropdown
const dropdown3 = ref(null); // Ref for profile dropdown
const notifications = ref([]);
const unreadCount = ref(0);

const props = defineProps({
    handlerClick: Function,
});

const hasNotifications = computed(() => {
    return Object.keys(filteredNotifications.value).length > 0;
});

const filteredNotifications = computed(() => {
    return Object.entries(notifications.value).reduce((acc, [groupName, messages]) => {
        if (messages.length > 0) {
            acc[groupName] = messages;
        }
        return acc;
    }, {});
});

const fetchNotifications = async () => {
    try {
        const response = await axios.get("/fetchNotifications");
        notifications.value = response.data.notifications;
        unreadCount.value = response.data.unread_count;
        feather.replace();
    } catch (error) {
        console.error("Error fetching notifications:", error);
    }
};

const getGroupIcon = (groupName) => {
    const icons = {
        System: "settings",
        User: "user",
        Order: "shopping-cart",
        default: "bell",
    };
    return icons[groupName] || icons.default;
};

const formatTimeAgo = (timestamp) => {
    const date = new Date(timestamp);
    const now = new Date();
    const diffSeconds = Math.floor((now - date) / 1000);
    if (diffSeconds < 60) return "Just now";
    if (diffSeconds < 3600) return `${Math.floor(diffSeconds / 60)}m ago`;
    if (diffSeconds < 86400) return `${Math.floor(diffSeconds / 3600)}h ago`;
    return `${Math.floor(diffSeconds / 86400)}d ago`;
};

const viewNotification = (notificationId) => {
    router.get(route("notifications.index"));
    dropdownOpen2.value = false;
};

const viewGroupNotifications = (groupName) => {
    router.get(route("notifications.group", groupName));
    dropdownOpen2.value = false;
};

const viewAllNotifications = () => {
    router.get(route("notifications.index"));
    dropdownOpen2.value = false;
};

const closeDropdown2 = () => {
    console.log("Closing dropdown 2");
    dropdownOpen2.value = false;
};

const closeDropdown3 = () => {
    console.log("Closing dropdown 3");
    dropdownOpen3.value = false;
};

const handleClickOutside = (event) => {
    const toggleButton = event.target.closest('.dropdown-toggle');
    if (dropdownOpen2.value && dropdown2.value && !dropdown2.value.contains(event.target) && !toggleButton) {
        closeDropdown2();
    }
    if (dropdownOpen3.value && dropdown3.value && !dropdown3.value.contains(event.target) && !toggleButton) {
        closeDropdown3();
    }
};

const logout = () => {
    router.post("/logout");
    dropdownOpen3.value = false; // Close dropdown on logout
};

const profile = () => {
    router.get(route("admin.user.profile"));
    dropdownOpen3.value = false; // Close dropdown on profile navigation
};

// Reset dropdown states on page change
router.on("navigate", () => {
    dropdownOpen2.value = false;
    dropdownOpen3.value = false;
});

onMounted(() => {
    fetchNotifications();
    const pollInterval = setInterval(fetchNotifications, 30000);
    document.addEventListener("click", handleClickOutside);
    feather.replace();

    onUnmounted(() => {
        clearInterval(pollInterval);
        document.removeEventListener("click", handleClickOutside);
    });
});
</script>

<style lang="scss" scoped></style>