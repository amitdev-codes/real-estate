<template>
    <Card>
        <template #header>
            Project
        </template>

        <select name="name" id="project" class="form-input mt-2">
            <option value="">-- Select --</option>
            <option v-for="project in projects" :key="project.id" :value="project.id">{{ project.name }}</option>
        </select>
    </Card>
</template>

<script setup>
import { ref } from 'vue';
import Card from '@backend-components/ui/card.vue';


defineProps({
    projects: Object
})

</script>

<style lang="scss" scoped>

</style>



