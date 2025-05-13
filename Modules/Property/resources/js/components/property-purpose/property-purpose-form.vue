<template>
    <Card>
        <template #header>{{ form.id ? "Edit" : "Create" }} Property Purpose</template>
        <form @submit.prevent="handleSubmit">
            <div class="grid grid-cols-12 gap-4">
                <div class="md:col-span-6 col-span-12">
                    <InputLabel for="name" value="Title" />
                    <input v-model="form.name" class="form-input mt-2 w-full" placeholder="Purpose Title :">
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="md:col-span-6 col-span-12">
                    <InputLabel for="slug" value="Slug" />
                    <input v-model="form.slug" class="form-input mt-2 w-full" placeholder="Purpose Slug :">
                    <InputError class="mt-2" :message="form.errors.slug" />
                </div>

                <div class="col-span-12">
                    <InputLabel for="description" value="Description" />
                    <textarea v-model="form.description" class="form-input mt-2 w-full textarea" placeholder="Purpose description :"></textarea>
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
import { watch, computed } from "vue";
import { useForm } from "@inertiajs/vue3";

import Card from '@backend-components/ui/card.vue';
import InputLabel from '@backend-components/ui/input-label.vue';
import ToggleSwitch from '@backend-components/ui/toggle-switch/toggle-switch.vue';
import InputError from "@backend-components/ui/input-error.vue";
import PrimaryButton from "@backend-components/ui/buttons/primary-button.vue";

const props = defineProps({
    purpose: Object
});

const form = useForm({
    id: props.purpose?.id || null,
    name: props.purpose?.name || '',
    slug: props.purpose?.slug || '',
    description: props.purpose?.description || '',
    is_active: !!(props.purpose?.is_active ?? true),
});

watch(() => props.purpose, (newPurpose) => {
    form.clearErrors(); // clear any previous errors
    form.id = newPurpose?.id || null;
    form.name = newPurpose?.name || '';
    form.slug = newPurpose?.slug || '';
    form.description = newPurpose?.description || '';
    form.is_active = !!(newPurpose?.is_active ?? true);
}, { immediate: true });

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
        ? form.put(route("admin.property-purposes.update", form.id),{
                onSuccess: () => {
                    form.reset();
                    form.clearErrors();
                },
            })
        : form.post(route("admin.property-purposes.store"),{
                onSuccess: () => {
                    form.reset();
                    form.clearErrors();
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
