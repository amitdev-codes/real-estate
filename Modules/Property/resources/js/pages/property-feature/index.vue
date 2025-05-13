<template>
    <!-- Start Content -->
    <BreadcrumbAndPageTitle pageTitle="All Property Features"/>
    
    <!-- Content Grid -->
    <div class="grid lg:grid-cols-12 grid-cols-1 gap-6">

        <div class="lg:col-span-4">
            <!-- Propery Features Order Section -->
            <Card>
                <template #header>
                    Property Feature
                </template>
                <div class="" data-simplebar>
                    <table class="w-full text-start">
                        <thead class="text-base">
                            <tr>
                                <th class="text-start font-semibold text-[15px] px-4 py-3 min-w-[30px]">Icon</th>
                                <th class="text-start font-semibold text-[15px] px-4 py-3 min-w-[140px]">Name</th>
                                <th class="text-end font-semibold text-[15px] px-4 py-3 min-w-[70px]"> Status </th>
                                <th class="text-end font-semibold text-[15px] px-4 py-3 min-w-[70px]"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="feature in features"
                                :key="feature.id"
                                :class="selectedFeature && selectedFeature.id === feature.id ? 'bg-gray-100 dark:bg-gray-800' : ''">
                                <td class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3">
                                    <span class="text-slate-400"><i :class="'mdi mdi-' + feature.icon"></i></span>
                                </td>

                                <td class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3">
                                    <span class="text-slate-400 hover:text-green-600 cursor-pointer"
                                        v-on:click="editFeature(feature)"
                                        :class="selectedFeature && selectedFeature.id === feature.id ? 'text-red-600' : ''"
                                    >
                                        {{ feature.name }}
                                    </span>
                                </td>

                                <td class="text-end border-t border-gray-100 dark:border-gray-800 px-4 py-3">
                                    <SuccessBadge v-if="feature.is_active == true" :label="'Active'"/>
                                    <DangerBadge v-if="feature.is_active == false" :label="'Inactive'"/>
                                </td>

                                <td class="text-center border-t border-gray-100 dark:border-gray-800 px-4 py-3 justify-between">
                                    <button v-if="selectedFeature && selectedFeature.id === feature.id"
                                        @click.prevent="handleDelete(feature.id)" class="text-red-500 delete-action-button" >
                                        <i class="mdi mdi-delete-outline mdi-24px"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </Card>
        </div>

        <div class="lg:col-span-8">
            <PropertyFeatureForm :icons="icons" :feature="selectedFeature"/>
        </div>
    </div>
</template>


<script setup>
    import { ref } from "vue";
    import { useDelete } from "@/utils/delete";

    import BackendLayout from "@/layouts/backend-layout.vue";
    import PropertyFeatureForm from "../../components/property-feature/property-feature-form.vue";
    import BreadcrumbAndPageTitle from "@backend-components/ui/breadcrumb-and-page-title.vue";

    import Card from "@backend-components/ui/card.vue";
    import SuccessBadge from "@backend-components/ui/badges/success-badge.vue";
    import DangerBadge from "@backend-components/ui/badges/danger-badge.vue";

    const props = defineProps({
        features: Object,
        icons: Array
    });

    const selectedFeature = ref(null);

    const editFeature = (feature) => { selectedFeature.value = feature; };

    const { deleteRow } = useDelete();

    const handleDelete = (id) => {   
        deleteRow(`admin.property-features.destroy`, id );
        
        if (selectedFeature.value && selectedFeature.value.id === id) {
            selectedFeature.value = null;
        }
    };

</script>

<script>
    export default {
        layout: BackendLayout,
    }
</script>

<style lang="scss" scoped>

</style>
