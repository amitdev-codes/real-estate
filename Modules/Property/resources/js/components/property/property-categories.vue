<template>
    <Card>
        <template #header>
            Categories
        </template>
    
        <div v-for="category in categories" :key="category.id">
            <input type="checkbox" name="name" id="categories" class="form-checkbox rounded border-gray-200 dark:border-gray-800 text-green-600 focus:border-green-300 focus:ring focus:ring-offset-0 focus:ring-green-200 focus:ring-opacity-50 me-2">
            <InputLabel for="categories" :value="category.name" />
        </div>
    </Card>
</template>




<script setup>
import Card from '@backend-components/ui/card.vue';
import InputLabel from '@backend-components/ui/input-label.vue';


defineProps({
    categories: Object
});

</script>

<style lang="scss" scoped>

</style>