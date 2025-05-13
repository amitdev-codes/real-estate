<template>
    <Card>
        <template #header>{{ form.id ? "Edit" : "Create" }} Property Category</template>
        <form @submit.prevent="handleSubmit">
            <div class="grid grid-cols-12 gap-4">
                <div class="md:col-span-6 col-span-12">
                    <InputLabel for="name" value="Title" />
                    <input v-model="form.name" class="form-input mt-2 w-full" placeholder="Category Title :">
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="md:col-span-6 col-span-12">
                    <InputLabel for="slug" value="Slug" />
                    <input v-model="form.slug" class="form-input mt-2 w-full" placeholder="Category Slug :">
                    <InputError class="mt-2" :message="form.errors.slug" />
                </div>

                <!-- Fixed the v-model binding for Multiselect -->
                <div class="md:col-span-6 col-span-12">
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

                <div class="md:col-span-6 col-span-12">
                    <CategoryDropdown
                    v-model="form.parent_id"
                    :id="'parent_id'"
                    :name="'parent_id'"
                    :categories="categories"
                    :category="category"
                    @update:category="handleCategoryChange"
                    />
                </div>

                <div class="col-span-12">
                    <InputLabel for="description" value="Description" />
                    <textarea v-model="form.description" class="form-input mt-2 w-full textarea" placeholder="Category description :"></textarea>
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div class="col-span-12">
                    <Vueform>
                    <FileElement
                      v-model="form.image"
                      name="image"
                      accept="image/*"
                      :preview="true"
                      :preview-as-background="true"
                      :preview-max-height="200"
                      :preview-max-width="200"
                      class="mb-4"
                      view="gallery"
                      :drop="true"
                    />
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

import Card from '@backend-components/ui/card.vue';
import InputLabel from '@backend-components/ui/input-label.vue';
import ToggleSwitch from '@backend-components/ui/toggle-switch/toggle-switch.vue';
import InputError from "@backend-components/ui/input-error.vue";
import PrimaryButton from "@backend-components/ui/buttons/primary-button.vue";
import CategoryDropdown from "./property-category-dropdown.vue";

const props = defineProps({
    icons: Array,
    category: Object,
    categories: Array
});

const emit = defineEmits(["update:category"]);

const form = useForm({
    id: props.category?.id || null,
    parent_id: props.category?.parent_id || '',
    name: props.category?.name || '',
    slug: props.category?.slug || '',
    iconObject: null,
    icon: props.category?.icon || '',
    description: props.category?.description || '',
    images: props.category?.images || [],
    is_active: !!(props.category?.is_active ?? true),
    image: null,
});

watch(() => props.category, (newCategory) => {
    form.clearErrors(); // clear any previous errors
    form.id = newCategory?.id || null;
    form.parent_id = newCategory?.parent_id || '';
    form.name = newCategory?.name || '';
    form.slug = newCategory?.slug || '';
    form.icon = newCategory?.icon || '';
    form.iconObject = props.icons.find(icon => icon.name === newCategory?.icon) || null;
    form.description = newCategory?.description || '';
    form.images = newCategory?.images || [];
    form.is_active = !!(newCategory?.is_active ?? true);
    form.image = newCategory?.image || null;
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

// const imageSrc = ref(null)
// const image = ref('')

// function loadFile(event) {
//     image.value = document.getElementById(event.target.name)
//     imageSrc.value = URL.createObjectURL(event.target.files[0])
// }

const formButtonText = computed(() => form.id ? "Update" : "Save");

const handleSubmit = () => {
    form.id
        ? form.put(route("admin.property-categories.update", form.id),{
                onSuccess: () => {
                    form.reset();
                    form.clearErrors();
                },
            })
        : form.post(route("admin.property-categories.store"),{
                onSuccess: () => {
                    form.reset();
                    form.clearErrors();
                },
            });
};

function resetForm()  {
    form.reset();
    form.clearErrors();
};
    // Handle category change
    const handleCategoryChange = (category) => {
      form.parent_id = category; // Update the parent_id in the reactive form
      console.log("Parent ID updated:", form.parent_id);
    };
</script>

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
</style>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>


