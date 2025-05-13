<template>
    <Card>
        <template #header>{{ form.id ? "Edit" : "Create" }} Property Feature</template>
        <form @submit.prevent="handleSubmit">
            <div class="grid grid-cols-12 gap-4">
                <div class="md:col-span-4 col-span-12">
                    <InputLabel for="name" value="Title" />
                    <input v-model="form.name" class="form-input mt-2 w-full" placeholder="Feature Title :">
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="md:col-span-4 col-span-12">
                    <InputLabel for="slug" value="Slug" />
                    <input v-model="form.slug" class="form-input mt-2 w-full" placeholder="Feature Slug :">
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
                    <textarea v-model="form.description" class="form-input mt-2 w-full textarea" placeholder="Feature description :"></textarea>
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div class="col-span-12 flex justify-between mt-4">
                    <div class="col-span-4 flex items-center">
                        <ToggleSwitch v-model="form.is_active" label="Active" />
                    </div>

                    <div class="col-span-4 flex justify-end gap-4">
                        <!-- <button type="submit" class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md px-6 py-2">
                            {{ formButtonText }}
                        </button> -->

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
    feature: Object
});

const form = useForm({
    id: props.feature?.id || null,
    name: props.feature?.name || '',
    slug: props.feature?.slug || '',
    iconObject: null,
    icon: props.feature?.icon || '',
    description: props.feature?.description || '',
    is_active: !!(props.feature?.is_active ?? true),
});

watch(() => props.feature, (newFeature) => {
    form.clearErrors(); // clear any previous errors
    form.id = newFeature?.id || null;
    form.name = newFeature?.name || '';
    form.slug = newFeature?.slug || '';
    form.icon = newFeature?.icon || '';
    form.iconObject = props.icons.find(icon => icon.name === newFeature?.icon) || null;
    form.description = newFeature?.description || '';
    form.is_active = !!(newFeature?.is_active ?? true);
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
        ? form.put(route("admin.property-features.update", form.id),{
                onSuccess: () => {
                    form.reset();
                    form.clearErrors();
                    toast.success('Property type updated successfully')
                },
            })
        : form.post(route("admin.property-features.store"),{
                onSuccess: () => {
                    form.reset();
                    form.clearErrors();
                    toast.success('Property type created successfully')
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
