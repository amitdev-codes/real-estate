<template>
    <Card>
        <template #header>{{ form.id ? "Edit" : "Create" }} Property Facility</template>
        <form @submit.prevent="handleSubmit">
            <div class="grid grid-cols-12 gap-4">
                <div class="md:col-span-4 col-span-12">
                    <InputLabel for="name" value="Title" />
                    <input v-model="form.name" class="form-input mt-2 w-full" placeholder="Facility Title :">
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="md:col-span-4 col-span-12">
                    <InputLabel for="slug" value="Slug" />
                    <input v-model="form.slug" class="form-input mt-2 w-full" placeholder="Facility Slug :">
                    <InputError class="mt-2" :message="form.errors.slug" />
                </div>

                <!-- Fixed the v-model binding for Multiselect -->
                <div class="md:col-span-4 col-span-12">
                    <InputLabel for="icon" value="Icon" />
                    <Multiselect
                        v-model="form.iconObject"
                        class="mt-2 max-h-10"
                        placeholder="Select an Icon"
                        label="name"
                        track-by="name"
                        :options="icons"
                        :showLabels="false"
                        :searchable="true"
                        :option-height="104">

                        <!-- Custom display for each option -->
                        <template #option="{ option }">
                            <div class="flex items-center">
                                <i :class="`mdi mdi-${option.name} mr-2`"></i>
                                <span>{{ option.name }}</span>
                            </div>
                        </template>

                        <!-- Display the selected icon -->
                        <template #singleLabel="{ option }">
                            <div class="flex items-center ">
                                <i :class="`mdi mdi-${option.name} mr-2`"></i>
                                <span>{{ option.name }}</span>
                            </div>
                        </template>
                    </Multiselect>

                    <input type="hidden" v-model="form.icon">

                    <InputError class="mt-2" :message="form.errors.icon" />
                </div>

                <div class="col-span-12">
                    <InputLabel for="description" value="Description" />
                    <textarea v-model="form.description" class="form-input mt-2 w-full textarea" placeholder="Facility description :"></textarea>
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div class="col-span-12 flex justify-between mt-4">
                    <div class="col-span-4 flex items-center">
                        <ToggleSwitch v-model="form.is_active" label="Active" />
                    </div>

                    <div class="col-span-4 flex justify-end gap-4">
                       <PrimaryButton type="submit" :label="formButtonText" :processing="form.processing"/>

                        <button v-if="form.id" type="button" @click="resetForm"
                            class="btn bg-gray-500 hover:bg-gray-600 border-gray-500 hover:border-gray-600 text-white rounded-md px-6 py-2">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </Card>
</template>

<script setup>
import { ref, watch, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import Multiselect from 'vue-multiselect';
import { toast } from "vue3-toastify";

import Card from '@backend-components/ui/card.vue';
import InputLabel from '@backend-components/ui/input-label.vue';
import ToggleSwitch from '@backend-components/ui/toggle-switch/toggle-switch.vue';
import InputError from "@backend-components/ui/input-error.vue";
import PrimaryButton from "@backend-components/ui/buttons/primary-button.vue";

const props = defineProps({
    icons: Array,
    facility: Object
});

const form = useForm({
    id: props.facility?.id || null,
    name: props.facility?.name || '',
    slug: props.facility?.slug || '',
    iconObject: null,
    icon: props.facility?.icon || '',
    description: props.facility?.description || '',
    is_active: !!(props.facility?.is_active ?? true),
});

watch(() => props.facility, (newFacility) => {
    form.clearErrors(); // clear any previous errors
    form.id = newFacility?.id || null;
    form.name = newFacility?.name || '';
    form.slug = newFacility?.slug || '';
    form.icon = newFacility?.icon || '';
    form.iconObject = props.icons.find(icon => icon.name === newFacility?.icon) || null;
    form.description = newFacility?.description || '';
    form.is_active = !!(newFacility?.is_active ?? true);
}, { immediate: true });

watch(() => form.icon, (newIcon) => {
    form.iconObject = props.icons.find(icon => icon.name === newIcon) || null;
});

watch(() => form.iconObject, (newIconObject) => {
    form.icon = newIconObject ? newIconObject.name : '';
});

watch(() => form.name, (newName) => {
      form.slug = generateSlug(newName);
});

function generateSlug(text) {
    return text
    .toString()
    .toLowerCase()
    .trim()
    .replace(/\s+/g, '-') // Replace spaces with -
    .replace(/[^\w\-]+/g, '') // Remove all non-word chars
    .replace(/\-\-+/g, '-') // Replace multiple - with single -
}

const formButtonText = computed(() => form.id ? "Update" : "Save");

const handleSubmit = () => {
    form.id
        ? form.put(route("admin.nearby-facilities.update", form.id),{

                onSuccess: () => {
                    form.reset();
                    form.clearErrors();
                    toast.success('Nearby facility updated successfully')   
                },
            })
        : form.post(route("admin.nearby-facilities.store"),{
                onSuccess: () => {
                    form.reset();
                    form.clearErrors();
                    toast.success('Nearby facility created successfully')
                },
            });
};

function resetForm()  {
    form.reset(); // Reset the form fields
    form.clearErrors();
};
</script>

<style lang="css" scoped>
    .multiselect__placeholder {
        margin-bottom: 0px;
        padding-top: 2px;
    }
</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
