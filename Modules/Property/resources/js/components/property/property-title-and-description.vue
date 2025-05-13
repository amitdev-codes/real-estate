<template>
    <Card>
        <template #header>
            Property title and description
        </template>
            <div class="grid grid-cols-12 gap-5">
                <div class="md:col-span-6 col-span-12">
                    <InputLabel for="title" value="Title" />
                    <input name="title" id="title" type="text" class="form-input mt-2" placeholder="Property Title :">
                </div>
                <div class="md:col-span-6 col-span-12">
                    <InputLabel for="slug" value="Slug" />
                    <input name="slug" id="slug" type="text" class="form-input mt-2" placeholder="Property Slug :">
                </div>
    
                <div class="col-span-12">
                    <InputLabel for="short_description" value="Short description" />
                    <textarea name="short_description" id="short_description" type="text" class="form-input mt-2 textarea" placeholder="Short description of property :"></textarea>
                </div>
    
                <div class="col-span-12">
                    <InputLabel for="description" value="Description" />
                    <textarea name="description" id="description" type="text" class="form-input mt-2 textarea" placeholder="Property description :"></textarea>
                </div>
            </div>
    
            <!-- <button type="submit" id="submit" name="send"
                class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md mt-5">
                Add Property
            </button> -->
    </Card>
</template>

<script setup>
    import InputLabel from '@backend-components/ui/input-label.vue';
    import Card from '@backend-components/ui/card.vue';
</script>

