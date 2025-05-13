<template>
  <BreadcrumbAndPageTitle
    :pageTitle="props.property ? 'Edit Property' : 'Add Property'"
    :breadcrumbs="breadcrumbs"
  />
  <Vueform
    ref="vueFormRef"
    :endpoint="submitForm"
    :scroll-to-invalid="true"
    validate-on="step"
    size="sm"
    :display-errors="true"
  >
    <template #empty>
      <Card>
        <FormSteps>
          <FormStep
            name="property_description"
            :elements="['title_section']"
            :labels="{ next: 'Property Details >' }"
            >Description
          </FormStep>
          <FormStep
            name="property_details"
            :elements="['purpose_and_status', 'address_section', 'details_section']"
            :labels="{
              next: 'Category and Features >',
              previous: '< Property Description',
            }"
            >Details
          </FormStep>
          <FormStep
            name="additional_features"
            :elements="[
              'category_and_features',
              'distances_from_facilities',
              'custom_fields_section',
            ]"
            :labels="{ next: 'Image Uploads >', previous: '< Property Details' }"
            >Category and Facilities
          </FormStep>
          <FormStep
            name="images_uploads"
            :elements="['images_section']"
            :labels="{
              next: 'Search Engine Optimization >',
              previous: '< Category and Features',
            }"
            >Images
          </FormStep>
          <FormStep
            name="seo_section"
            :elements="['seo_section', 'publish_section']"
            :labels="{
              finish: props.property ? 'Update Property' : 'Create Property',
              previous: '< Image Uploads',
            }"
            >Search Engine Optimization
          </FormStep>
        </FormSteps>
      </Card>

      <FormElements>
        <GroupElement name="title_section" class="group-element-container">
          <StaticElement
            name="h2_title"
            content="Property Title and Description"
            tag="h5"
            class="text-gray-500"
          />
          <StaticElement name="hr_title" tag="hr" />
          <TextElement
            name="title"
            label="Title"
            :columns="{ default: 12, sm: 6 }"
            @input="updateSlug"
            rules="required|max:255|min:5"
          />
          <TextElement
            name="slug"
            label="Slug"
            :columns="{ default: 12, sm: 6 }"
            rules="required|max:255|min:5"
          />
          <TextareaElement
            name="short_description"
            label="Short description"
            rules="required|max:1000|min:5"
          />
          <EditorElement
            name="description"
            label="Description"
            rules="required|max:10000|min:5"
          />
          <TextareaElement
            name="private_notes"
            label="Private notes"
            description="Private notes will be visible only to owner. It won't be shown on the frontend."
          />
        </GroupElement>

        <!--Purpose and Status -->
        <GroupElement name="purpose_and_status" class="group-element-container">
          <StaticElement
            name="h2_purpose_and_status"
            content="Property Purpose and Status"
            tag="h5"
            class="text-gray-500"
          />
          <StaticElement name="hr_purpose_and_status" tag="hr" />
          <SelectElement
            name="property_status_id"
            label="Property Status"
            :native="false"
            :columns="{ default: 12, sm: 6 }"
            :items="propertyStatus"
            label-prop="name"
            value-prop="id"
            rules="required"
          />

          <SelectElement
            name="project_id"
            label="Project"
            :native="false"
            :columns="{ default: 12, sm: 6 }"
            :items="projects"
            :search="true"
            label-prop="name"
            value-prop="id"
          />

          <SelectElement
            name="construction_type"
            label="New/Established Property"
            :native="false"
            :columns="{ default: 12, sm: 6 }"
            :items="['New Construction', 'Established Property']"
            default="Established Property"
          />
          <DateElement
            name="property_availability_date"
            label="Property Availability Date"
            :columns="{ default: 12, sm: 6 }"
            :conditions="
              rentingStatusId
                ? [['purpose_and_status.property_status_id', rentingStatusId]]
                : []
            "
          />
        </GroupElement>

        <!--Address Details -->
        <GroupElement
          name="address_section"
          :columns="{ default: 12, xl: 6 }"
          class="group-element-container"
        >
          <StaticElement
            name="h2_details"
            content="Address Details"
            tag="h5"
            class="text-gray-500"
          />
          <StaticElement name="hr_details" tag="hr" />
          <SelectElement
            name="country"
            :search="true"
            :native="false"
            label="Country"
            pplcaeholder="search"
            default="13"
            autocomplete="off"
            :items="usePage().props.countries"
            :columns="{ default: 12, sm: 6 }"
          />
          <SelectElement
            name="state"
            :search="true"
            :native="false"
            label="State"
            default="1"
            autocomplete="off"
            :items="usePage().props.states"
            :columns="{ default: 12, sm: 6 }"
          />
          <SelectElement
            name="city"
            :search="true"
            :native="false"
            label="City"
            default="5"
            autocomplete="off"
            :items="usePage().props.cities"
            :columns="{ default: 12, sm: 6 }"
          />
          <TextElement
            name="street"
            label="Street"
            :columns="{ default: 12, sm: 6 }"
            rules="required"
          />
          <TextElement
            name="building_number"
            label="Building No"
            :columns="{ default: 12, sm: 6 }"
          />
          <TextElement
            name="postal_code"
            label="Zip Code"
            :columns="{ default: 12, sm: 6 }"
            rules="required|numeric"
          />
          <TextElement
            name="latitude"
            label="Latitude"
            input-type="number"
            :columns="{ default: 12, sm: 6 }"
          />
          <TextElement
            name="longitude"
            label="Longitude"
            input-type="number"
            :columns="{ default: 12, sm: 6 }"
          />
        </GroupElement>

        <!--Property Details -->
        <GroupElement
          name="details_section"
          :columns="{ default: 12, xl: 6 }"
          class="group-element-container"
        >
          <StaticElement
            name="h2_rooms_and_area_group"
            content="Rooms and Area"
            tag="h5"
            class="text-gray-500"
          />
          <StaticElement name="hr_rooms_and_area_group" tag="hr" />
          <TextElement
            name="bedrooms"
            label="Beds"
            input-type="number"
            :columns="{ default: 12, sm: 6 }"
            rules="required|numeric"
          />
          <TextElement
            name="bathrooms"
            label="Baths"
            input-type="number"
            :columns="{ default: 12, sm: 6 }"
            rules="required|numeric"
          />
          <TextElement
            name="floors"
            label="Floors"
            input-type="number"
            :columns="{ default: 12, sm: 6 }"
            rules="required|numeric"
          />
          <TextElement
            name="parkings"
            label="Parking"
            input-type="number"
            :columns="{ default: 12, sm: 6 }"
            rules="required|numeric"
          />
          <TextElement
            name="area"
            label="Area"
            input-type="number"
            :columns="{ default: 12, sm: 6 }"
            rules="required|numeric"
          />
          <SelectElement
            name="unit_id"
            label="Unit"
            :native="false"
            :columns="{ default: 12, sm: 6 }"
            :items="areaUnits"
            label-prop="name"
            value-prop="id"
            placeholder="Select Unit"
            rules="required"
          />
          <TextElement
            name="base_price"
            label="Price"
            input-type="number"
            :columns="{ default: 12, sm: 6 }"
            rules="required|numeric"
          />
          <TextElement
            name="offer_price"
            label="Offer Price"
            input-type="number"
            :columns="{ default: 12, sm: 6 }"
            rules="required|numeric"
          />
        </GroupElement>

        <!-- Category and Features -->
        <GroupElement name="category_and_features" class="group-element-container">
          <StaticElement
            name="h2_category_and_features"
            content="Category and Features"
            tag="h5"
            class="text-gray-500"
          />
          <StaticElement name="hr_category_and_features" tag="hr" class="mb-1" />
          <TagsElement
            name="property_types"
            label="Property Types"
            :items="propertyTypes"
            label-prop="name"
            value-prop="id"
            :close-on-select="false"
            :search="true"
            rules="required"
          />
          <TagsElement
            name="features"
            label="Property Features"
            :items="features"
            label-prop="name"
            value-prop="id"
            :close-on-select="false"
            :search="true"
            rules="required"
          />
        </GroupElement>

        <!-- Features and others -->
        <GroupElement
          name="distances_from_facilities"
          class="group-element-container"
          :columns="{ default: 12, xl: 6 }"
        >
          <StaticElement
            name="h2_distance_facilities"
            content="Facility Distances from the property"
            tag="h5"
            class="text-gray-500"
          />
          <StaticElement name="hr_distance_facilities" tag="hr" />
          <ListElement
            name="facilities_distance"
            id="facilities_distance"
            add-text="Add facility"
            :initial="0"
            :sort="true"
          >
            <template #default="{ index }">
              <ObjectElement :name="index">
                <SelectElement
                  name="facility"
                  placeholder="Facility"
                  :native="false"
                  :columns="{ container: 5 }"
                  :items="facilities"
                  :search="true"
                  label-prop="name"
                  value-prop="id"
                  rules="required"
                />
                <TextElement
                  name="distance"
                  placeholder="Distance"
                  input-type="number"
                  :columns="{ container: 4 }"
                  rules="required"
                />
                <SelectElement
                  name="unit_id"
                  placeholder="Unit"
                  :native="false"
                  :columns="{ container: 3 }"
                  rules="required"
                  :items="lengthUnits"
                  label-prop="name"
                  value-prop="id"
                />
              </ObjectElement>
            </template>
          </ListElement>
        </GroupElement>

        <!-- Custom Fields -->
        <GroupElement
          name="custom_fields_section"
          class="group-element-container"
          :columns="{ default: 12, xl: 6 }"
        >
          <StaticElement
            name="h2_custom_fields"
            content="Custom Fields"
            tag="h5"
            class="text-gray-500"
          />
          <StaticElement name="hr_custom_fields" tag="hr" />
          <ListElement
            name="custom_fields"
            id="custom_fields"
            add-text="Add Field"
            :initial="0"
          >
            <template #default="{ index }">
              <ObjectElement :name="index">
                <TextElement
                  name="field_title"
                  placeholder="Title"
                  :columns="{ container: 6 }"
                  rules="required"
                />
                <TextElement
                  name="field_value"
                  placeholder="Value"
                  :columns="{ container: 6 }"
                  rules="required"
                />
              </ObjectElement>
            </template>
          </ListElement>
        </GroupElement>

        <!--Image Uploads -->
        <GroupElement name="images_section" class="group-element-container">
          <StaticElement
            name="h2_images"
            content="Property Images"
            tag="h5"
            class="text-gray-500"
          />
          <StaticElement name="hr_images" tag="hr" />
          <FileElement
            name="hero_image"
            label="Cover Image"
            :drop="true"
            accept=".jpg,.png,.gif"
            view="image"
            :columns="{ container: 6 }"
          />
          <FileElement
            name="image_360"
            label="360 Image"
            :drop="true"
            accept=".jpg,.png,.gif"
            view="image"
            :columns="{ container: 6 }"
          />
          <MultifileElement
            name="floor_plan_images"
            label="Property Floor Plan"
            :drop="true"
            accept=".jpg,.png,.gif"
            view="gallery"
            :columns="{ container: 6 }"
          />
          <MultifileElement
            name="property_gallery"
            label="Property Gallery"
            :drop="true"
            accept=".jpg,.png,.gif"
            view="image"
            :columns="{ container: 6 }"
          />
          <TextElement name="video_link" label="Video Link" :columns="{ container: 6 }" />
        </GroupElement>

        <!-- SEO -->
        <GroupElement
          name="seo_section"
          class="group-element-container"
          :columns="{ default: 12, xl: 6 }"
        >
          <StaticElement
            name="h2_seo"
            content="Search Engine Optimization"
            tag="h5"
            class="text-gray-500"
          />
          <StaticElement name="hr_seo" tag="hr" />
          <TextElement name="seo_title" label="SEO Title" />
          <TextareaElement name="seo_description" label="SEO Description" />
          <FileElement name="seo_image" label="SEO Image" :drop="true" />
          <ToggleElement
            name="seo_indexing"
            text="Indexing"
            :labels="{ on: 'ON', off: 'OFF' }"
            :true-value="1"
            :false-value="0"
            width="w-full"
            size="md"
          />
        </GroupElement>

        <GroupElement
          name="publish_section"
          class="group-element-container"
          :columns="{ default: 12, xl: 6 }"
        >
          <StaticElement name="h2_agent" content="Agent" tag="h5" class="text-gray-500" />
          <StaticElement name="hr_agent" tag="hr" />
          <template v-if="isAgent">
            <TextElement
              name="agent_id"
              label="Assigned Agent"
              :modelValue="loggedInAgent.id"
              :disabled="true"
              :placeholder="loggedInAgent.first_name"
            />
          </template>
          <template v-else>
            <SelectElement
              name="agent_id"
              label="Assigned Agent"
              :native="false"
              rules="required"
              :items="agents"
              label-prop="name"
              value-prop="id"
            />
          </template>

          <StaticElement
            name="h2_seo"
            content="Publish Dates and Status"
            tag="h5"
            top="2"
            class="text-gray-500"
          />
          <StaticElement name="hr_seo" tag="hr" />

          <DateElement name="publish_start_date" label="Publish Start Date" />
          <DateElement name="publish_end_date" label="Publish End Date" />
          <ToggleElement
            name="is_published"
            text="Publish Status"
            :true-value="1"
            :false-value="0"
            :top="1"
            size="md"
            class="mt-2"
            :columns="{ container: 6 }"
          />
          <ToggleElement
            name="has_ads"
            text="Include Ads"
            :true-value="1"
            :false-value="0"
            size="md"
            class="mt-2"
            :columns="{ container: 6 }"
          />
          <ToggleElement
            name="is_featured"
            text="Featured"
            :true-value="1"
            :false-value="0"
            size="md"
            class="mt-2"
            :columns="{ container: 6 }"
          />
          <ToggleElement
            name="is_active"
            text="Active"
            :true-value="1"
            :false-value="0"
            size="md"
            class="mt-2"
            :columns="{ container: 6 }"
          />
        </GroupElement>
      </FormElements>
      <FormStepsControls
        :add-class="{
          FormStepsControls: {
            container: 'w-10',
          },
        }"
      />
    </template>
  </Vueform>
</template>

<script setup>
import Card from "@backend-components/ui/card.vue";
import BackendLayout from "@/layouts/backend-layout.vue";
import BreadcrumbAndPageTitle from "@backend-components/ui/breadcrumb-and-page-title.vue";

import { ref, onMounted, watch, computed } from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

const vueFormRef = ref(null);

const breadcrumbs = ref([{ name: "Property", route: "admin.properties.index" }]);

const props = defineProps({
  features: Array,
  // categories : Array,
  propertyTypes: Array,
  facilities: Array,
  // propertyPurpose : Array,
  areaUnits: Array,
  lengthUnits: Array,
  propertyStatus: Array,
  projects: Array,
  property: Object,
  address: Object,
  metaContent: Object,
  agents: Array,
});

const rentingStatusId = computed(() => {
  return props.propertyStatus.find((status) => status.name.toLowerCase() === "renting")
    ?.id;
});

const slugify = (text) => {
  return text
    .toString()
    .toLowerCase()
    .trim()
    .replace(/\s+/g, "-")
    .replace(/[^\w\-]+/g, "")
    .replace(/\-\-+/g, "-")
    .replace(/^-+/, "")
    .replace(/-+$/, "");
};

const updateSlug = (event) => {
  const slug = slugify(event.target.value);
  vueFormRef.value.update({ slug });
};

const loggedInAgent = computed(() => usePage().props.agent);
const loggedInUser = computed(() => usePage().props.auth.user);

const isAgent = computed(() => loggedInUser.value?.role === "Agent");
// Populate form values based on property data
const fillValues = () => {
  const formValues = {};

  if (props.property) {
    // Map property fields to the form keys
    formValues.title = props.property.title || "";
    formValues.slug = props.property.slug || "";
    formValues.short_description = props.property.short_description || "";
    formValues.description = props.property.description || "";
    formValues.private_notes = props.property.private_notes || "";

    // Purpose and status
    formValues.property_status_id = props.property.property_status_id || null;
    formValues.project_id = props.property.project_id || null;
    formValues.construction_type = props.property.construction_type || null;
    formValues.property_availability_date =
      props.property.property_availability_date || null;

    // Address section
    formValues.country = props.property.address?.country || "13"; // Default value
    formValues.state = props.property.address?.state || "";
    formValues.city = props.property.address?.city || "";
    formValues.street = props.property.address?.street || "";
    formValues.building_number = props.property.address?.building_number || "";
    formValues.postal_code = props.property.address?.postal_code || "";
    formValues.latitude = props.property.address?.latitude || "";
    formValues.longitude = props.property.address?.longitude || "";

    // Rooms and Area
    formValues.bedrooms = props.property.bedrooms || "";
    formValues.bathrooms = props.property.bathrooms || "";
    formValues.floors = props.property.floors || "";
    formValues.parkings = props.property.parkings || "";
    formValues.area = props.property.area || "";
    formValues.unit_id = props.property.unit_id || null;
    formValues.base_price = props.property.base_price || "";
    formValues.offer_price = props.property.offer_price || "";

    // property_categories and property_features
    formValues.property_types =
      props.property.property_types?.map((type) => type.id) || [];
    formValues.features = props.property.features || [];

    formValues.facilities_distance =
      props.property.nearby_facilities?.map((facility_distance) => ({
        facility: facility_distance.nearby_facility_id,
        distance: facility_distance.distance,
        unit_id: facility_distance.unit_id,
      })) || [];

    formValues.custom_fields = props.property.custom_fields || [];

    formValues.video_link = props.property.video_link || "";

    // SEO
    formValues.seo_title = props.property.meta_content?.seo_title || "";
    formValues.seo_description = props.property.meta_content?.seo_description || "";
    formValues.seo_indexing = props.property.meta_content?.seo_indexing || 0;

    formValues.agent_id = props.property.agent_id || null;
    formValues.publish_start_date = props.property.publish_start_date || "";
    formValues.publish_end_date = props.property.publish_end_date || "";
    formValues.is_published = props.property.is_published || 0;
    formValues.has_ads = props.property.has_ads || 0;
    formValues.is_featured = props.property.is_featured || 0;
    formValues.is_active = props.property.is_active || 0;
  }

  if (vueFormRef.value) {
    vueFormRef.value.update(formValues);
  }
};

onMounted(() => {
  fillValues();
});

const submitForm = async (FormData, form$) => {
  form$.clearMessages();

  const method = props.property?.id ? "put" : "post";

  const routeName = props.property?.id
    ? route("admin.properties.update", props.property.id)
    : route("admin.properties.store");

  const formData = {
    ...form$.requestData,
    agent_id: loggedInAgent.value.id,
  };

  const inertiaForm = useForm(formData);

  inertiaForm.submit(method, routeName, {
    preserveScroll: true,
    onError: (errors) => {
      form$.invalid = true;
      console.log(errors);
      handleFormErrors(errors, form$);

      toast.error(
        (props.property?.id
          ? "Failed to update property"
          : "Failed to create property.") + " Please fix the errors."
      );
    },
    onSuccess: () => {
      form$.clearMessages();
      if (props.resetOnSuccess) {
        form$.clear();
        form$.reset();
      }
      toast.success(
        props.property?.id
          ? "Property updated successfully"
          : "Property created successfully"
      );
    },
  });
};

const handleFormErrors = (errors, form$) => {
  const fieldPaths = getFieldPaths(form$.elements$);
  Object.entries(errors).forEach(([field, error]) => {
    const matchingPath = fieldPaths.find((path) => path.endsWith(`.${field}`));
    if (matchingPath) {
      const element = form$.el$(matchingPath);
      if (element) {
        console.log(matchingPath);
        element.messageBag.append(error);
      } else {
        console.log(`Element not found for field path: ${matchingPath}`);
      }
    } else {
      console.log(`Field not found in any group: ${field}`);
    }
  });
};

const getFieldPaths = (groupElements, basePath = "") => {
  const fieldPaths = [];
  Object.keys(groupElements).forEach((elementName) => {
    const element = groupElements[elementName];
    if (element.type === "StaticElement") {
      return;
    }
    const currentPath = basePath ? `${basePath}.${elementName}` : elementName;

    if (element.children$) {
      fieldPaths.push(...getFieldPaths(element.children$, currentPath));
    } else if (element.type === "ListElement") {
      const listItems = element.children$ || {};
      Object.keys(listItems).forEach((index) => {
        const itemBasePath = `${currentPath}.${index}`;
        fieldPaths.push(...getFieldPaths(listItems[index].children$, itemBasePath));
      });
    } else {
      fieldPaths.push(currentPath);
    }
  });
  return fieldPaths;
};
</script>

<script>
export default {
  layout: BackendLayout,
};
</script>

<style lang="scss" scoped>
.group-element-container {
  @apply rounded-md shadow dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900 h-fit mt-4;
}
</style>
