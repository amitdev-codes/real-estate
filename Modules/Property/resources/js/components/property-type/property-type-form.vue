<template>
    <Card>
        <template #header>{{ form.id ? "Edit" : "Create" }} Property Type</template>
        <form @submit.prevent="handleSubmit">
            <div class="grid grid-cols-12 gap-4">
                <div class="md:col-span-4 col-span-12">
                    <InputLabel for="name" value="Title" />
                    <input v-model="form.name" class="form-input mt-2 w-full" placeholder="PropertyType Title :">
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="md:col-span-4 col-span-12">
                    <InputLabel for="slug" value="Slug" />
                    <input v-model="form.slug" class="form-input mt-2 w-full" placeholder="PropertyType Slug :">
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
                        track-by="['name', 'aliases', 'tags']"
                        :options="icons"
                        :showLabels="false"
                        :searchable="true"
                        :option-height="104"
                        :limit="20"
                        :breakTags="false">

                        <!-- Custom display for each option -->
                        <template #option="{ option }">
                            <div class="flex items-center overflow-clip">
                                <i :class="`mdi mdi-${option.name} mr-2`"></i>
                                <span class="text-sm">{{ option.name }}</span>
                            </div>
                        </template>

                        <!-- Display the selected icon -->
                        <template #singleLabel="{ option }">
                            <div class="flex items-center overflow-clip">
                                <i :class="`mdi mdi-${option.name} mr-2`"></i>
                                <span class="text-sm ">{{ option.name }}</span>
                            </div>
                        </template>
                    </Multiselect>

                    <input type="hidden" v-model="form.icon">

                    <InputError class="mt-2" :message="form.errors.icon" />
                </div>

                <div class="col-span-12">
                    <InputLabel for="description" value="Description" />
                    <textarea v-model="form.description" class="form-input mt-2 w-full textarea" placeholder="PropertyType description :"></textarea>
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div class="col-span-12">
                    <Vueform v-model="vueFormModel" form-key="property-type-form" ref="vueformRef">
                        <InputLabel for="images" value="Images" />
                        <MultifileElement name="images" :drop="true" accept="image/*" view="gallery"  class="mb-4"/>
                    </Vueform>
                    <InputError class="mt-2" :message="form.errors.image" />
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
    propertyType: Object,
});

const vueformRef = ref(null)
const vueFormModel = ref(null)

const form = useForm({
    id: props.propertyType?.id || null,
    name: props.propertyType?.name || '',
    slug: props.propertyType?.slug || '',
    iconObject: null,
    icon: props.propertyType?.icon || '',
    description: props.propertyType?.description || '',
    images: props.propertyType?.images || [],
    is_active: !!(props.propertyType?.is_active ?? true),
});

watch(() => props.propertyType, (newPropertyType) => {
    form.clearErrors();

    form.id = newPropertyType?.id || null;
    form.name = newPropertyType?.name || '';
    form.slug = newPropertyType?.slug || '';
    form.icon = newPropertyType?.icon || '';
    form.iconObject = props.icons.find(icon => icon.name === newPropertyType?.icon) || null;
    form.description = newPropertyType?.description || '';
    form.images = newPropertyType?.images || [];
    form.is_active = !!(newPropertyType?.is_active ?? true);

    if(newPropertyType?.image_path){
        vueformRef.value.el$('images').load(props.propertyType.image_path) 
    }
    
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
    .replace(/\s+/g, '-')
    .replace(/[^\w\-]+/g, '')
    .replace(/\-\-+/g, '-')
}

const formButtonText = computed(() => form.id ? "Update" : "Save");

const handleSubmit = () => {

    form.images = vueFormModel.value.images

    form.id
        ? form.put(route("admin.property-types.update", form.id),{
                onSuccess: () => {
                    form.reset();
                    form.clearErrors();
                    vueformRef.value?.reset();     
                    toast.success('Property type updated successfully')          
                },
            })
        : form.post(route("admin.property-types.store"),{
                onSuccess: () => {
                    form.reset();
                    form.clearErrors();
                    vueformRef.value?.reset();
                    toast.success('Property type created successfully')
                },
            });
};

function resetForm()  {
    form.reset();
    form.clearErrors();
    vueformRef.value?.reset();
};
</script>

<script>

export default {
  data() {
    return {
      formData: {
        files: [],
        // Other form data
      },
    };
  },
};
</script>


<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style lang="css" scoped>
    .multiselect__placeholder {
        margin-bottom: 0px;
        padding-top: 2px;
    }

    img {
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    button {
        font-size: 1rem;
    }

    .multiselect__tags {
        background: unset !important;
    }
</style>



