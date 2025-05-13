<template>
  <div class="max-h-[400px] overflow-y-auto">
    <div v-if="loading" class="flex justify-center p-4">
      <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-gray-900"></div>
    </div>

    <template v-else>
      <div v-for="group in groupedNotifications" :key="group.id" class="mb-4">
        <!-- Group Header -->
        <div class="px-4 py-2 bg-gray-50 dark:bg-gray-800 font-semibold flex items-center">
          <i :class="[group.icon, 'mr-2']"></i>
          {{ group.name }}
        </div>

        <!-- No Notifications Message -->
        <div v-if="!group.notifications.length" class="p-4 text-center text-gray-500">
          No notifications in this group
        </div>

        <!-- Notifications List -->
        <div v-else>
          <div
            v-for="notification in group.notifications"
            :key="notification.id"
            :class="[
              'p-4 border-b hover:bg-gray-50 dark:hover:bg-gray-800 cursor-pointer',
              { 'opacity-75': notification.read_at, 'bg-blue-50 dark:bg-blue-900/20': !notification.read_at }
            ]"
            @click="viewNotification(notification)"
          >
            <div class="flex justify-between items-start">
              <div>
                <h4 class="font-medium text-sm">{{ notification.title }}</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                  {{ notification.message }}
                </p>
              </div>
              <div v-if="!notification.read_at" class="h-2 w-2 bg-blue-600 rounded-full"></div>
            </div>
            <div class="mt-2 text-xs text-gray-500">
              {{ formatDate(notification.created_at) }}
            </div>
          </div>
        </div>
      </div>
    </template>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import axios from 'axios';

// Refs
const groupedNotifications = ref([]);
const loading = ref(true);

// Methods
const fetchNotifications = async () => {
  try {
    const response = await axios.get('/api/notifications/grouped');
    groupedNotifications.value = response.data;
  } catch (error) {
    console.error('Error fetching notifications:', error);
  } finally {
    loading.value = false;
  }
};

const markAsRead = async (id) => {
  try {
    await axios.post(`/api/notifications/${id}/mark-as-read`);
    await fetchNotifications();
  } catch (error) {
    console.error('Error marking notification as read:', error);
  }
};

const viewNotification = async (notification) => {
  if (!notification.read_at) {
    await markAsRead(notification.id);
  }
  router.visit(`/notifications/${notification.id}`);
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString(undefined, {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit'
  });
};

// Lifecycle hooks
onMounted(() => {
  fetchNotifications();
});
</script>
