<template>
    <Card>
        <template #header>
            Facilities distance from the property.
        </template>

        <div class="grid grid-cols-12 gap-4 items-center mb-6">
            <div class="col-span-4 ">
                <select name="name" id="facility" class="form-input mt-2">
                    <option value="">-- Select --</option>
                    <option v-for="facility in facilities" :key="facility.id" :value="facility.id">{{ facility.name }}</option>
                </select>
            </div>
            <div class="flex-grow lg:col-span-5">
                <input name="name" id="facility_distance" type="text" class="form-input mt-2" placeholder="Distance between facilities :">
            </div>
        
            <div class="flex-grow lg:col-span-2">
                <select name="name" id="distance_ubit" class="form-input mt-2">
                    <option value="meter">Meter</option>
                    <option value="feet">Feet</option>
                </select>
            </div>
        
            <div class="flex-none">
                <a href="#"
                    class="h-9 w-9 inline-flex items-center justify-center align-middle text-center border-grey-600
                        hover:bg-green-700 border-green-600 text-gray-500 rounded-md me-1">
                    <i class="mdi mdi-trash-can-outline"></i>
                </a>
            </div>
        </div>
        
        <a href="" class="text-gray-800 hover:text-green-600">Add More</a>
    </Card>    
</template>




<script setup>
import Card from '@backend-components/ui/card.vue';

const props = defineProps({
    facilities: Object
});
</script>