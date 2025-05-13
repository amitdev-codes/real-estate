<template>
    <Card>
        <div class="grid grid-cols-6 gap-5">           
            <div class="col-span-4">
                <InputLabel for="country" value="Country" />
                <select name="country" id="country">
                    <option value="">-- Select Country --</option>
                </select>
            </div>

            <div class="col-span-4">
                <InputLabel for="state" value="State" />
                <select name="state" id="state">
                    <option value="">-- Select State --</option>
                </select>
            </div>

            <div class="col-span-4">
                <InputLabel for="city" value="City" />
                <select name="city" id="city">
                    <option value="">-- Select City --</option>
                </select>
            </div>

            <div class="col-span-6">
                <InputLabel for="street" value="Street" />
                <input name="street" id="street" type="text" class="form-input mt-2" placeholder="Street :">
            </div>

            <div class="col-span-6">
                <InputLabel for="building_no" value="Building No." />
                <input name="building_no" id="building_no" type="text" class="form-input mt-2" placeholder="Building No. :">
            </div>

            <div class="col-span-6">
                <InputLabel for="latitude" value="Latitude" />
                <input name="latitude" id="latitude" type="text" class="form-input mt-2" placeholder="Latitude :">
            </div>

            <div class="col-span-6">
                <InputLabel for="longitude" value="Longitude" />
                <input name="longitude" id="longitude" type="text" class="form-input mt-2" placeholder="Longitude :">
            </div>                         
        </div>        
    </Card>
</template>

<script setup>

import Card from "@/backend/components/ui/card.vue";
import InputLabel from "@/backend/components/ui/input-label.vue";


</script>

<style lang="scss" scoped>

</style>