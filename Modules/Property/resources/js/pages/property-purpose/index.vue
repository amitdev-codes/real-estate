<template>
    <!-- Start Content -->
    <BreadcrumbAndPageTitle pageTitle="All Property Purposes"/>

    <!-- Content Grid -->
    <div class="grid lg:grid-cols-12 grid-cols-1 gap-6">

        <div class="lg:col-span-4">
            <!-- Propery Purposes Order Section -->
            <Card>
                <template #header>
                    Property Purpose
                </template>
                <div class="" data-simplebar>
                    <table class="w-full text-start">
                        <thead class="text-base">
                            <tr>
                                <th class="text-start font-semibold text-[15px] px-4 py-3 min-w-[30px]">Name</th>
                                <!-- <th class="text-start font-semibold text-[15px] px-4 py-3 min-w-[140px]">Slug</th> -->
                                <th class="text-end font-semibold text-[15px] px-4 py-3 min-w-[70px]"> Status </th>
                                <th class="text-end font-semibold text-[15px] px-4 py-3 min-w-[70px]"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="purpose in purposes"
                                :key="purpose.id"
                                :class="selectedPurpose && selectedPurpose.id === purpose.id ? 'bg-gray-100 dark:bg-gray-800' : ''">

                                <td class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3">
                                    <span class="text-slate-400 hover:text-green-600 cursor-pointer"
                                        v-on:click="editPurpose(purpose)"
                                        :class="selectedPurpose && selectedPurpose.id === purpose.id ? 'text-red-600' : ''">
                                        {{ purpose.name }}
                                    </span>
                                </td>

                                <!-- <td class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3">
                                    <span class="text-slate-400">{{ purpose.slug }}</span>
                                </td> -->

                                <td class="text-end border-t border-gray-100 dark:border-gray-800 px-4 py-3">
                                    <SuccessBadge v-if="purpose.is_active == true" :label="'Active'"/>
                                    <DangerBadge v-if="purpose.is_active == false" :label="'Inactive'"/>
                                </td>

                                <td class="text-center border-t border-gray-100 dark:border-gray-800 px-4 py-3 justify-between">
                                    <Link v-if="selectedPurpose && selectedPurpose.id === purpose.id"
                                        :href="route('admin.property-purposes.destroy', purpose.id)"
                                        method="delete"
                                        as="button"
                                        class="text-red-500">
                                        <i class="mdi mdi-delete font-normal"></i>
                                    </Link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </Card>
        </div>

        <div class="lg:col-span-8">
            <PropertyPurposeForm :purpose="selectedPurpose"/>
        </div>
    </div>
</template>


<script setup>
    import { ref } from "vue";
    import BackendLayout from "@/layouts/backend-layout.vue";
    import PropertyPurposeForm from "../../components/property-purpose/property-purpose-form.vue";
    import BreadcrumbAndPageTitle from "@backend-components/ui/breadcrumb-and-page-title.vue";


    import Card from "@backend-components/ui/card.vue";
    import SuccessBadge from "@backend-components/ui/badges/success-badge.vue";
    import DangerBadge from "@backend-components/ui/badges/danger-badge.vue";

    const props = defineProps({
        purposes: Object,
    });

    const selectedPurpose = ref(null);

    const editPurpose = (purpose) => { selectedPurpose.value = purpose; };

</script>

<script>
    export default {
        layout: BackendLayout,
    }
</script>

<style lang="scss" scoped>

</style>
