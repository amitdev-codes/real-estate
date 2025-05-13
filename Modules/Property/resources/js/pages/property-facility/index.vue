<template>
    <!-- Start Content -->
    <BreadcrumbAndPageTitle pageTitle="All Property Facilities"/>

    <!-- Content Grid -->
    <div class="grid lg:grid-cols-12 grid-cols-1 gap-6">

        <div class="lg:col-span-4">
            <!-- Propery Facilities Order Section -->
            <Card>
                <template #header>
                    Property Facility
                </template>
                <div class="block w-full xl:max-h-[700px] max-h-[500px]" data-simplebar>
                    <table class="w-full text-start table-responsive">
                        <thead class="text-base">
                            <tr>
                                <th class="text-start font-medium px-4 py-3 min-w-[30px]">Icon</th>
                                <th class="text-start font-medium px-4 py-3 min-w-[140px]">Name</th>
                                <th class="text-end font-medium px-4 py-3 min-w-[70px]"> Status </th>
                                <th class="text-end font-medium px-4 py-3 min-w-[70px]"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="facility in facilities"
                                :key="facility.id"
                                :class="selectedFacility && selectedFacility.id === facility.id ? 'bg-gray-100 dark:bg-gray-800' : ''">
                                <td class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3">
                                    <span class="text-slate-400"><i :class="'mdi-18px mdi mdi-' + facility.icon"></i></span>
                                </td>

                                <td class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3">
                                    <span class="text-slate-400 hover:text-green-600 cursor-pointer"
                                        v-on:click="editFacility(facility)"
                                        :class="selectedFacility && selectedFacility.id === facility.id ? 'text-red-600' : ''"
                                    >
                                        {{ facility.name }}
                                    </span>
                                </td>

                                <td class="text-end border-t text-xs border-gray-100 dark:border-gray-800 px-4 py-3">
                                    <SuccessBadge v-if="facility.is_active == true" :label="'Active'"/>
                                    <DangerBadge v-if="facility.is_active == false" :label="'Inactive'"/>
                                </td>

                                <td class="text-center border-t border-gray-100 dark:border-gray-800 px-4 py-3 justify-between">
                                    <!-- <Link v-if="selectedFacility && selectedFacility.id === facility.id"
                                        :href="route('admin.property-facilities.destroy', facility.id)"
                                        method="delete"
                                        as="button"
                                        class="text-red-500">
                                        <i class="mdi mdi-delete-outline mdi-18px font-normal"></i>
                                    </Link> -->

                                    <button v-if="selectedFacility && selectedFacility.id === facility.id"
                                        @click.prevent="handleDelete(facility.id)" class="text-red-500 delete-action-button" >
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
            <PropertyFacilityForm :facility="selectedFacility" :icons="icons" />
        </div>
    </div>
</template>


<script setup>
    import { ref } from "vue";
    import { useDelete } from "@/utils/delete";

    import BackendLayout from "@/layouts/backend-layout.vue";
    import PropertyFacilityForm from "../../components/property-facility/property-facility-form.vue";
    import BreadcrumbAndPageTitle from "@backend-components/ui/breadcrumb-and-page-title.vue";

    import Card from "@backend-components/ui/card.vue";
    import SuccessBadge from "@backend-components/ui/badges/success-badge.vue";
    import DangerBadge from "@backend-components/ui/badges/danger-badge.vue";


    const props = defineProps({
        facilities: Object,
        icons: Array
    });

    const selectedFacility = ref(null);

    const editFacility = (facility) => { selectedFacility.value = facility; };

    const { deleteRow } = useDelete();

    const handleDelete = (id) => {   
        deleteRow(`admin.nearby-facilities.destroy`, id );
        
        if (selectedFacility.value && selectedFacility.value.id === id) {
            selectedFacility.value = null;
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
