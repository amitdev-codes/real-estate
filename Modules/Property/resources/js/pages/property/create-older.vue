<template>
      <BreadcrumbAndPageTitle :pageTitle="'Add Property'" :breadcrumbs="breadcrumbs" />
      <div class="grid md:grid-cols-12 col-span-1 gap-6">

        <div class="xl:col-span-9 md:col-span-8 col-span-1">
                <!-- Start Property Details Section -->
                <PropertyTitleAndDescription/>
                <!-- End Property Details Section -->

                <!-- Start BHK details -->
                <RoomsAndArea/>
                <!-- End BHK details -->

                <!-- Start Image Uploads -->
                <DropzoneImageBox/>
                <!-- End Image Uploads -->

                <!-- Start Distance between key facilities -->
                <FacilitiesDistance :facilities="propertyFacilities"/>
                <!-- End Distance between key facilities -->

                <!-- Start Custom Fields -->
                <CustomFields/>
                <!-- End Custom Fields -->

                <!-- Start Property Features -->
                <PropertyFeatures :features="propertyFeatures"/>

                <!-- Start Search Engine Optimization  -->
                <MetaContent/>

        </div>

        <!--Start Save/Publish & Status Section // Sidebar section  -->
        <div class="xl:col-span-3 md:col-span-4 col-span-1">
                <Card>
                    <div class="col-span-12">
                        <InputLabel for="publish_date" value="Publish Date" />
                        <input name="name" id="publish_date" type="date" class="form-input mt-2" placeholder="Publish Date :">
                    </div>
                    <div class="grid grid-cols-2 gap-6 mt-6 items-center">
                        <a href="" class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md">Save</a>
                        <a href="" class=" text-gray-800 hover:text-green-600">Save as Draft</a>
                    </div>
                </Card>

                <Card>
                    <template #header>
                        Property Status
                    </template>
                    <select name="name" id="publish_status" class="form-input mt-2">
                        <option value="">-- Select --</option>
                        <option v-for="status in propertyStatus" :key="status.id" :value="status.id">{{ status.name }}</option>
                    </select>
                </Card>

                <Card>
                    <template #header>
                        Moderation Status
                    </template>
                    <select name="name" id="moderation_status" class="form-input mt-2">
                        <option value="">-- Select --</option>
                        <option value="Pending">Pending</option>
                        <option value="Approved">Approved</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </Card>

                <PropertyCategories :categories="propertyCategories"/>

                <ProjectListDropdown :projects="projects"/>

                <Card>
                    <template #header>
                        Agent
                    </template>

                    <select name="name" id="agent" class="form-input mt-2">
                        <option value="">-- Select --</option>
                        <!-- <option v-for="agent in agents" :key="agent.id" :value="agent.id">{{ agent.name }}</option> -->
                    </select>
                </Card>

        </div>
      </div>


</template>

<script setup>
import { ref } from 'vue';
import BackendLayout from "@/layouts/backend-layout.vue";


import InputLabel from '@backend-components/ui/input-label.vue';
import Card from '@backend-components/ui/card.vue';

import BreadcrumbAndPageTitle from '@backend-components/ui/breadcrumb-and-page-title.vue';
import PropertyTitleAndDescription from '../../components/property/property-title-and-description.vue';

import RoomsAndArea from '../../components/property/rooms-and-area.vue';
import DropzoneImageBox from '@backend-components/ui/dropzone-image-box.vue';
import FacilitiesDistance from '../../components/property/facilities-distance.vue';
import CustomFields from '../../components/property/custom-fields.vue';
import PropertyFeatures from '../../components/property/property-features.vue';
import MetaContent from '@backend-components/ui/forms/meta-content.vue';
import PropertyCategories from '../../components/property/property-categories.vue';
import ProjectListDropdown from '../../components/project/project-list-dropdown.vue';

const breadcrumbs = ref([
    { name: 'Property', route: 'admin.properties.index' },
    { name: 'Create Property', route: 'admin.properties.create' },
])

const props = defineProps({
  propertyFacilities: {
    type: Object
  },
  propertyFeatures: {
    type: Object
  },
  propertyStatus: {
    type: Object
  },
  propertyCategories: {
    type: Object
  },
  projects: {
    type: Object
  }
});
</script>

<script>
export default {
  layout: BackendLayout,
};
</script>

<style lang="scss" scoped></style>
