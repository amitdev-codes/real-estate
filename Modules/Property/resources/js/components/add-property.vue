<template>
  <!-- <TitleAndBreadcrumb /> -->

  <div class="grid md:grid-cols-12 col-span-1 gap-6">
    <div class="xl:col-span-9 md:col-span-8 col-span-1">
      <!-- Start Property Details Section -->

      <!-- End Property Details Section -->

      <!-- Start BHK details -->
      <RoomsAndArea />
      <!-- End BHK details -->

      <!-- Start Image Uploads -->
      <DropzoneImageBox />
      <!-- End Image Uploads -->

      <!-- Start Distance between key facilities -->
      <FacilitiesDistance />
      <!-- End Distance between key facilities -->

      <!-- Start Custom Fields -->
      <CustomFields />
      <!-- End Custom Fields -->

      <!-- Start Property Features -->
      <PropertyFeatures />

      <!-- Start Search Engine Optimization  -->
      <MetaContent />
    </div>

    <!--Start Save/Publish & Status Section // Sidebar section  -->
    <div class="xl:col-span-3 md:col-span-4 col-span-1">
      <Card>
        <div class="col-span-12">
          <InputLabel for="publish_date" value="Publish Date" />
          <input
            name="name"
            id="publish_date"
            type="date"
            class="form-input mt-2"
            placeholder="Publish Date :"
          />
        </div>
        <div class="grid grid-cols-2 gap-6 mt-6 items-center">
          <a
            href=""
            class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md"
            >Save</a
          >
          <a href="" class="text-gray-800 hover:text-green-600">Save as Draft</a>
        </div>
      </Card>

      <Card>
        <template #header> Property Status </template>
        <select name="name" id="publish_status" class="form-input mt-2">
          <option value="">-- Select --</option>
          <option value="Selling">Selling</option>
          <option value="Renting">Renting</option>
          <option value="Sold">Sold</option>
          <option value="Rented">Rented</option>
        </select>
      </Card>

      <Card>
        <template #header> Moderation Status </template>
        <select name="name" id="moderation_status" class="form-input mt-2">
          <option value="">-- Select --</option>
          <option value="Pending">Pending</option>
          <option value="Approved">Approved</option>
          <option value="Rejected">Rejected</option>
        </select>
      </Card>

      <PropertyCategories />

      <ProjectListDropdown />

      <Card>
        <template #header> Agent </template>

        <select name="name" id="agent" class="form-input mt-2">
          <option value="">-- Select --</option>
          <option v-for="agent in agents" :key="agent.id" :value="agent.id">
            {{ agent.name }}
          </option>
        </select>
      </Card>
    </div>
    <!-- End Save/Publish & Status Section -->
  </div>
  <!-- </div> -->
  <!-- End Content -->
</template>

<script setup>
import { ref } from "vue";

import InputLabel from "@backend-components/ui/input-label.vue";
import Card from "@backend-components/ui/card.vue";

import PropertyFeatures from "./property/property-features.vue";
import FacilitiesDistance from "./property/facilities-distance.vue";
import RoomsAndArea from "./property/rooms-and-area.vue";
import CustomFields from "./property/custom-fields.vue";
import MetaContent from "@backend-components/ui/forms/meta-content.vue";
import DropzoneImageBox from "@backend-components/ui/dropzone-image-box.vue";
import PropertyCategories from "./property/property-categories.vue";
import ProjectListDropdown from "./project/project-list-dropdown.vue";

// create agent user list with agency name
const agents = ref([
  { id: 1, name: "John Doe", agency: "Agency 1" },
  { id: 2, name: "Jane Doe", agency: "Agency 2" },
  { id: 3, name: "Adam Smith", agency: null },
  { id: 4, name: "Sarah Johnson", agency: "Agency 4" },
  { id: 5, name: "James Brown", agency: "Agency 5" },
]);
</script>

<style lang="scss" scoped></style>
