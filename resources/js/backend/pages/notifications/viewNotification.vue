<template>
    <div class="container mx-auto p-6">
        <div v-if="notification" class="bg-white dark:bg-slate-900 shadow-md rounded-lg p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold text-slate-800 dark:text-white">
                    {{ notification.title }}
                </h1>
                <div class="flex items-center space-x-2">
                    <span
                        :class="[
                            'px-3 py-1 rounded-full text-xs font-medium',
                            notification.read_at
                                ? 'bg-green-100 text-green-800'
                                : 'bg-red-100 text-red-800'
                        ]"
                    >
                        {{ notification.read_at ? 'Read' : 'Unread' }}
                    </span>
                    <span class="text-sm text-slate-500 dark:text-slate-400">
                        {{ formatDate(notification.created_at) }}
                    </span>
                </div>
            </div>

            <div class="prose dark:prose-invert max-w-full">
                <p>{{ notification.message }}</p>
            </div>

            <div class="mt-6 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-slate-600 dark:text-slate-300">
                        Type: {{ getTypeTitle(notification.type) }}
                    </span>
                </div>

                <div class="flex space-x-2">
                    <button
                        v-if="!notification.read_at"
                        @click="markAsRead"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors"
                    >
                        Mark as Read
                    </button>
                    <Link
                        :href="route('notifications.index')"
                        class="px-4 py-2 bg-gray-200 dark:bg-slate-700 text-slate-700 dark:text-white rounded-md hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors"
                    >
                        Back to Notifications
                    </Link>
                </div>
            </div>
        </div>

        <div v-else class="text-center text-slate-500 dark:text-slate-400 mt-10">
            No notification found.
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { router, Link } from '@inertiajs/vue3';

const props = defineProps({
    notification: {
        type: Object,
        default: null
    }
});

const notification = ref(props.notification);

const formatDate = (timestamp) => {
    return new Date(timestamp).toLocaleString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

const getTypeTitle = (type) => {
    const titles = {
        'inspection': 'Inspection Notification',
        'contract': 'Contract Update',
        'inquiry': 'Inquiry Notification',
        'general': 'General Notification'
    };
    return titles[type] || 'Notification';
};

const markAsRead = () => {
    router.post(route('notifications.read', notification.value.id), {}, {
        onSuccess: () => {
            notification.value.read_at = new Date();
        }
    });
};
</script>
<script>
import BackendLayout from "@/layouts/backend-layout.vue";
export default {
    layout: BackendLayout,
};
</script>
