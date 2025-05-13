<template>
    <div class="notification-center">
        <div v-for="notification in notifications" :key="notification.id" class="notification">
            <h3>{{ notification.title }}</h3>
            <p>{{ notification.message }}</p>
            <span>{{ notification.created_at }}</span>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { usePage } from '@inertiajs/vue3'

const notifications = ref([])

onMounted(() => {
    fetchNotifications()
})

const fetchNotifications = () => {
    // Fetch user's notifications via Inertia
    notifications.value = usePage().props.notifications || []
}
</script>
