<template>
  <BreadcrumbAndPageTitle :pageTitle="'Add Property'" :breadcrumbs="breadcrumbs" />
  <Vueform>
    <template #empty>
      <Card>
        <FormSteps>
          <FormStep
            name="property_description"
            :elements="['title-section']"
            :labels="{ next: 'Property Details >' }"
            >Description
          </FormStep>
          <FormStep
            name="property_details"
            :elements="['address-section', 'details-section']"
            :labels="{ next: 'Image Uploads >', previous: '< Property Description' }"
            >Details
          </FormStep>
          <FormStep
            name="image_box"
            :elements="['h2-images', 'hr-images', 'hero_image', 'images']"
            :labels="{ next: 'Other Features >', previous: '< Property Details' }"
            >Images
          </FormStep>
          <FormStep
            name="additional_features"
            :elements="[
              'h2-other-features',
              'hr-other-features-1',
              'facilities_distances',
              'hr-other-features-2',
              'custom_fields',
            ]"
            :labels="{
              next: 'Search Engine Optimization >',
              previous: '< Image Uploads',
            }"
            >Other Features
          </FormStep>
          <FormStep
            name="seo"
            :elements="[
              'h2-seo',
              'hr-seo',
              'seo_title',
              'seo_description',
              'seo_image',
              'seo_index',
            ]"
            :labels="{ finish: 'Create Property', previous: '< Other Features' }"
            >Search Engine Optimization
          </FormStep>
        </FormSteps>
      </Card>

      <FormElements>
        <GroupElement
          name="title-section"
          :add-classes="{
            GroupElement: {
              container:
                'rounded-md shadow dark:shadow-gray-700 p-4 bg-white dark:bg-slate-900 h-fit mt-4',
            },
          }"
        >
          <StaticElement
            name="h2-title"
            content="Property Title and Description"
            tag="h4"
          />
          <StaticElement name="hr-title" tag="hr" />
          <GroupElement name="title_group">
            <TextElement name="title" label="Title" :columns="{ default: 12, sm: 6 }" />
            <TextElement name="slug" label="Slug" :columns="{ default: 12, sm: 6 }" />
          </GroupElement>
          <TextareaElement name="short_description" label="Short description" />
          <TEditorElement name="description" label="Description" />
          <TextareaElement
            name="private_notes"
            label="Private notes"
            description="Private notes will be visible only to owner. It won't be shown on the frontend."
          />
        </GroupElement>

        <GroupElement
          name="address-section"
          :columns="{ default: 12, xl: 6 }"
          :add-classes="{
            GroupElement: {
              container:
                'rounded-md shadow dark:shadow-gray-700 p-4 bg-white dark:bg-slate-900  mt-4',
            },
          }"
        >
          <StaticElement name="h2-details" content="Property Details" tag="h5" top="1" />
          <StaticElement name="hr-details" tag="hr" />
          <GroupElement name="address_group">
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
              autocomplete="off"
              :items="usePage().props.states"
              :columns="{ default: 12, sm: 6 }"
            />
            <SelectElement
              name="city"
              :search="true"
              :native="false"
              label="City"
              autocomplete="off"
              :items="usePage().props.cities"
              :columns="{ default: 12, sm: 6 }"
            />

            <TextElement
              name="building_no"
              label="Building No"
              :columns="{ default: 12, sm: 6 }"
            />
            <TextElement
              name="zip_code"
              label="Zip Code"
              :columns="{ default: 12, sm: 6 }"
            />
            <TextElement
              name="latitude"
              label="Latitude"
              :columns="{ default: 12, sm: 6 }"
            />
            <TextElement
              name="longitude"
              label="Longitude"
              :columns="{ default: 12, sm: 6 }"
            />
          </GroupElement>
        </GroupElement>

        <GroupElement
          name="details-section"
          :columns="{ default: 12, xl: 6 }"
          :add-classes="{
            GroupElement: {
              container:
                'rounded-md shadow dark:shadow-gray-700 p-4 bg-white dark:bg-slate-900 mt-4',
            },
          }"
        >
          <StaticElement name="hr-details-2" tag="hr" />
          <GroupElement name="rooms_and_area_group">
            <TextElement
              name="beds"
              label="Beds"
              input-type="number"
              :columns="{ default: 12, sm: 6 }"
            />
            <TextElement
              name="baths"
              label="Baths"
              input-type="number"
              :columns="{ default: 12, sm: 6 }"
            />
            <TextElement
              name="floors"
              label="Floors"
              input-type="number"
              :columns="{ default: 12, sm: 6 }"
            />
            <TextElement
              name="area"
              label="Area (m2)"
              input-type="number"
              :columns="{ default: 12, sm: 6 }"
            />
          </GroupElement>
          <GroupElement name="price_group">
            <TextElement
              name="base_price"
              label="Price"
              input-type="number"
              :columns="{ default: 12, sm: 6 }"
            />
            <TextElement
              name="offer_price"
              label="Offer Price"
              input-type="number"
              :columns="{ default: 12, sm: 6 }"
            />
          </GroupElement>
          <TagsElement
            name="categories"
            label="Property category"
            :items="categories"
            label-prop="name"
            value-prop="id"
            :close-on-select="false"
            :search="true"
          />
          <TagsElement
            name="property_features"
            :items="features"
            label="Property Features"
            label-prop="name"
            value-prop="id"
            :close-on-select="false"
            :search="true"
          />
        </GroupElement>

        <!--Multi-imagebox -->
        <StaticElement name="h2-images" content="Property Images" tag="h4" top="1" />
        <StaticElement name="hr-images" tag="hr" />
        <FileElement :drop="true" name="hero_image" label="Cover Image" />
        <MultifileElement :drop="true" name="images" label="Property Gallery" />

        <!-- Features and others -->
        <StaticElement
          name="h2-other-features"
          content="Other Features"
          tag="h4"
          top="1"
        />
        <StaticElement name="hr-other-features-1" tag="hr" />
        <ListElement
          name="facilities_distances"
          :initial="1"
          :min="1"
          add-text="Add facility"
          label="Nearest facility distance from the property"
        >
          <template #default="{ index }">
            <ObjectElement :name="index">
              <SelectElement
                name="facility"
                placeholder="Select facility"
                :floating="false"
                :native="false"
                :items="facilities"
                :search="true"
                label-prop="name"
                value-prop="id"
                :columns="{ container: 6 }"
              />
              <TextElement
                name="distance"
                placeholder="Distance"
                :floating="false"
                :columns="{ container: 4 }"
              />
              <SelectElement
                name="unit"
                placeholder="Select Unit"
                :floating="false"
                :native="false"
                :items="['Meters', 'Feet']"
                :columns="{ container: 2 }"
              />
            </ObjectElement>
          </template>
        </ListElement>
        <StaticElement name="hr-other-features-2" tag="hr" />
        <ListElement
          name="custom_fields"
          :min="1"
          add-text="Add Field"
          label="Custom Fields"
        >
          <template #default="{ index }">
            <ObjectElement :name="index">
              <TextElement
                name="field_title"
                placeholder="Title"
                :columns="{ container: 6 }"
              />
              <TextElement
                name="field_value"
                placeholder="Value"
                :columns="{ container: 6 }"
              />
            </ObjectElement>
          </template>
        </ListElement>

        <!-- SEO -->
        <StaticElement name="h2-seo" content="Property Images" tag="h4" top="1" />
        <StaticElement name="hr-seo" tag="hr" />
        <TextElement name="seo_title" label="SEO Title" />
        <TextareaElement name="seo_description" label="SEO Description" />
        <FileElement name="seo_image" label="SEO Image" :drop="true" view="gallery" />
        <ToggleElement name="seo_index">Index</ToggleElement>
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
import { ref, computed } from "vue";
import Card from "@backend-components/ui/card.vue";
import BackendLayout from "@/layouts/backend-layout.vue";
import BreadcrumbAndPageTitle from "@backend-components/ui/breadcrumb-and-page-title.vue";
import { usePage } from "@inertiajs/vue3";

const selectedFeatures = ref([]);

const breadcrumbs = ref([{ name: "Property", route: "admin.properties.index" }]);

const props = defineProps({
  features: Array,
  categories: Array,
  facilities: Array,
});

const formattedFeatures = computed(() => {
  return props.features.map((feature) => ({
    value: feature.id,
    label: feature.name,
  }));
});
</script>

<script>
export default {
  layout: BackendLayout,
};
</script>

<style lang="scss" scoped></style>
