<template>
    <Card>
        <template #header>
            Property Features
        </template>

        <!-- Loop features in checkboxs here -->
        <div class="flex flex-wrap gap-6 ">
            <div v-for="feature in features" :key="feature.id" class="form-checkbox ">
                <input type="checkbox" name="name" id="feature" class="form-checkbox-input me-2">
                <InputLabel for="features" :value="feature.name" />  
            </div>
        </div>
    </Card>
</template>

<script setup>
// import { ref } from 'vue';

import Card from '@backend-components/ui/card.vue';
import InputLabel from '@backend-components/ui/input-label.vue';

const props = defineProps({
    features: Object
});
</script>

<style lang="scss" scoped>

</style>