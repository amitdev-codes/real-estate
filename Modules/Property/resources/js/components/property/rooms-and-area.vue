<template>
    <Card>
        <template #header>
            Area, Rooms and Floor
        </template>
    
        <div class="grid md:grid-cols-12 gap-4">
            <div class="lg:col-span-3 md:col-span-6 col-span-12">
                <InputLabel for="beds" value="Beds" />
                <div class="form-icon relative mt-2">
                    <i class="mdi mdi-bed absolute top-2 start-4 text-green-600"></i>
                    <input name="beds" id="beds" type="number" class="form-input ps-11" placeholder="Total Beds :">
                </div>
            </div>
    
            <div class="lg:col-span-3 md:col-span-6 col-span-12">
                <InputLabel for="baths" value="Baths" />
                <div class="form-icon relative mt-2">
                    <i class="mdi mdi-shower absolute top-2 start-4 text-green-600"></i>
                    <input name="baths" id="baths" type="number" class="form-input ps-11" placeholder="Baths :">
                </div>
            </div>
    
            <div class="lg:col-span-3 md:col-span-6 col-span-12">
                <InputLabel for="floors" value="Floors" />
                <div class="form-icon relative mt-2">
                    <i class="mdi mdi-arrow-expand-all absolute top-2 start-4 text-green-600"></i>
                    <input name="floors" id="floors" type="number" class="form-input ps-11" placeholder="Floors :">
                </div>
            </div>
    
            <div class="lg:col-span-3 md:col-span-6 col-span-12">
                <InputLabel for="area" value="Square ft:" />
                <div class="form-icon relative mt-2">
                    <i class="mdi mdi-arrow-expand-all absolute top-2 start-4 text-green-600"></i>
                    <input name="number" id="area" type="number" class="form-input ps-11" placeholder="Size (sqf) :">
                </div>
            </div>
    
            <div class="md:col-span-6 col-span-12">
                <InputLabel for="price" value="Price" />
                <div class="form-icon relative mt-2">
                    <i class="mdi mdi-currency-usd absolute top-2 start-4 text-green-600"></i>
                    <input name="number" id="price" type="number" class="form-input ps-11" placeholder="Price :">
                </div>
            </div>
    
            <div class="md:col-span-6 col-span-12">
                <InputLabel for="offer_price" value="Offer Price" />
                <div class="form-icon relative mt-2">
                    <i class="mdi mdi-currency-usd absolute top-2 start-4 text-green-600"></i>
                    <input name="number" id="price" type="number" class="form-input ps-11" placeholder="Offer price :">
                </div>
            </div>
        </div>
    </Card>
</template>



<script setup>
    import Card from '@backend-components/ui/card.vue';
    import InputLabel from '@backend-components/ui/input-label.vue';
</script>


<style lang="scss" scoped>

</style>