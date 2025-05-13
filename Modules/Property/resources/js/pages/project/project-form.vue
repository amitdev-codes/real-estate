<template>
  <div>
    <BreadcrumbAndPageTitle
      :pageTitle="props.project ? 'Edit Project' : 'Add Project'"
      :breadcrumbs="breadcrumbs"
    />
    <Vueform
      :endpoint="submitForm"
      ref="vueFormRef"
      :scroll-to-invalid="true"
      validate-on="step"
      size="sm"
    >
      <template #empty>
        <Card>
          <FormSteps>
            <FormStep
              name="project_description"
              :elements="['title_section']"
              :labels="{ next: 'Project Details >' }"
              >Description
            </FormStep>
            <!-- <FormStep name="project_description"
                        :elements="['h2_title', 'hr_title', 'name', 'slug', 'project_status_id', 'short_description', 'description', 'is_featured']"
                        :labels="{'next': 'Project Details >'}">Description
                    </FormStep> -->
            <FormStep
              name="project_details"
              :elements="[
                'category_and_features',
                'details_section',
                'dates_section',
              ]"
              :labels="{
                next: 'Category and Features >',
                previous: '< Project Description',
              }"
              >Details
            </FormStep>
            <FormStep
              name="images_uploads"
              :elements="['images_section']"
              :labels="{
                next: 'Developer Information >',
                previous: '< Project Details',
              }"
              >Images
            </FormStep>
            <FormStep
              name="developer_information"
              :elements="[
                'developer',
                'developer_details',
                'developer_address',
              ]"
              :labels="{
                next: 'Search Engine Optimization >',
                previous: '< Images',
              }"
              >Developer Information
            </FormStep>
            <FormStep
              name="seo_section"
              :elements="['seo_details', 'publish_section']"
              :labels="{
                finish: props.project ? 'Update Project' : 'Create Project',
                previous: '< Developer Information',
              }"
              >Search Engine Optimization
            </FormStep>
          </FormSteps>
        </Card>

        <FormElements>
          <GroupElement name="title_section" class="group-element-container">
            <StaticElement
              name="h2_title"
              content="Project Title and Description"
              tag="h5"
              class="text-gray-500"
            />
            <StaticElement name="hr_title" tag="hr" />
            <TextElement
              name="name"
              label="Name"
              :columns="{ default: 12, sm: 6 }"
              @input="updateSlug"
              rules="required|min:5"
            />
            <TextElement
              name="slug"
              label="Slug"
              :columns="{ default: 12, sm: 6 }"
              rules="required|min:5"
            />
            <TextareaElement
              name="short_description"
              label="Short description"
              rules="required|max:1000|min:50"
            />
            <EditorElement
              name="description"
              label="Description"
              rules="required|max:10000|min:50"
            />
          </GroupElement>

          <!--Purpose and Status -->
          <GroupElement
            name="category_and_features"
            class="group-element-container"
          >
            <StaticElement
              name="h2_category_and_features"
              content="Category and Features"
              tag="h5"
              class="text-gray-500"
            />
            <StaticElement
              name="hr_category_and_features"
              tag="hr"
              class="mb-1"
            />
            <TagsElement
              name="property_types"
              label="Property Type"
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

            <SelectElement
              name="construction_type"
              label="New/Established Property"
              :native="false"
              :items="['New Construction', 'Established Property']"
              default="Established Property"
              :columns="{ container: 6 }"
            />
            <SelectElement
              name="project_status_id"
              label="Select status"
              :native="false"
              :columns="{ default: 12, sm: 6 }"
              :items="projectStatus"
              label-prop="name"
              value-prop="id"
              rules="required"
            />
          </GroupElement>

          <!--Property Details -->
          <GroupElement
            name="details_section"
            :columns="{ default: 12, xl: 8 }"
            class="group-element-container"
          >
            <StaticElement
              name="h2_rooms_and_area_group"
              content="Area and Price Information"
              tag="h5"
              class="text-gray-500"
            />
            <StaticElement name="hr_rooms_and_area_group" tag="hr" />
            <TextElement
              name="total_blocks"
              label="Number of Blocks"
              input-type="number"
              :columns="{ default: 12, sm: 6 }"
              rules="required|integer"
            />
            <TextElement
              name="total_buildings"
              label="Number of Buildings"
              input-type="number"
              :columns="{ default: 12, sm: 6 }"
              rules="required|integer"
            />
            <TextElement
              name="total_floors"
              label="Total Floors"
              input-type="number"
              :columns="{ default: 12, sm: 6 }"
              rules="required|integer"
            />
            <TextElement
              name="total_flats"
              label="Total Apartments"
              input-type="number"
              :columns="{ default: 12, sm: 6 }"
              rules="required|integer"
            />
            <TextElement
              name="total_area"
              label="Total Area"
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
              name="lowest_price"
              label="Min Price"
              input-type="number"
              :columns="{ default: 12, sm: 6 }"
              rules="nullable|numeric|gte:details_section.lowest_price"
            />
            <TextElement
              name="max_price"
              label="Max Price"
              input-type="number"
              :columns="{ default: 12, sm: 6 }"
              rules="nullable|numeric|lte:details_section.max_price"
            />
          </GroupElement>

          <GroupElement
            name="dates_section"
            class="group-element-container"
            :columns="{ default: 12, xl: 4 }"
          >
            <StaticElement
              name="h2_dates"
              content="Project Timeline"
              tag="h5"
              class="text-gray-500"
            />
            <StaticElement name="hr_dates" tag="hr" />
            <DateElement
              name="project_start_date"
              label="Project Start Date"
              label-prop="name"
              native="false"
              :date="true"
              rules="required|date"
            />
            <DateElement
              name="project_finish_date"
              label="Project Completion Date"
              rules="nullable|date|after:dates_section.project_start_date"
            />
            <DateElement
              name="project_sale_start_date"
              label="Sales Start Date"
              rules="nullable|date|after:dates_section.project_start_date"
            />
            <DateElement
              name="property_availability_date"
              label="Property Availability Date"
              :conditions="
                rentingStatusId
                  ? [
                      [
                        'category_and_features.project_status_id',
                        rentingStatusId,
                      ],
                    ]
                  : []
              "
              rules="nullable|date"
            />
          </GroupElement>

          <!-- Developer Details -->

          <GroupElement name="developer" class="group-element-container">
            <StaticElement
              name="h2_developer"
              content="Property Developer/Agencies"
              tag="h5"
              class="text-gray-500"
            />
            <StaticElement name="hr_developer" tag="hr" />
            <SelectElement
              name="developer_id"
              label="Select Developer"
              :native="false"
              :columns="{ default: 12, lg: 6 }"
              :items="propertyDevelopers"
              label-prop="name"
              value-prop="id"
              @change="handleDeveloperChange"
            />
            <SelectElement
              name="agency_id"
              label="Select Agency"
              :native="false"
              :columns="{ default: 12, lg: 6 }"
              :items="agencies"
              label-prop="name"
              value-prop="id"
            />
          </GroupElement>

          <GroupElement
            name="developer_details"
            class="group-element-container"
            :columns="{ default: 12, lg: 6 }"
          >
            <StaticElement
              name="h2_developer_details"
              content="Developer Information"
              tag="h5"
              class="text-gray-500"
            />
            <StaticElement
              name="hr_developer_details"
              tag="hr"
              :disabled="isDeveloperSelected"
            />
            <TextElement
              name="developer_name"
              label="Name"
              :disabled="isDeveloperSelected"
            />
            <TextElement
              name="developer_email"
              label="Email"
              :disabled="isDeveloperSelected"
            />
            <!-- <TextElement name="developer_phone" label="Phone" mask="+1 (000)-000-0000"/> -->
            <!-- <TextElement name="developer_phone" label="Phone" :mask="{ mask: '+1 (000)-000-0000', placeholder: false }" :disabled="isDeveloperSelected"/> -->

            <PhoneElement
              name="phone"
              allow-incomplete
              unmask
              :inlcude="['au']"
            />
            <TextElement
              name="developer_website"
              label="Website"
              :disabled="isDeveloperSelected"
            />
          </GroupElement>

          <!-- Developer Address -->
          <GroupElement
            name="developer_address"
            class="group-element-container"
            :columns="{ default: 12, lg: 6 }"
          >
            <StaticElement
              name="h2_developer_address"
              content="Developer Address"
              tag="h5"
              class="text-gray-500"
            />
            <StaticElement name="hr_developer_address" tag="hr" />
            <TextElement
              name="country"
              label="Country"
              :disabled="isDeveloperSelected"
            />
            <TextElement
              name="state"
              label="State"
              :disabled="isDeveloperSelected"
            />
            <TextElement
              name="city"
              label="City"
              :disabled="isDeveloperSelected"
            />
            <TextElement
              name="street"
              label="Street"
              :disabled="isDeveloperSelected"
            />
            <TextElement
              name="building_number"
              label="Building Number"
              :disabled="isDeveloperSelected"
            />
            <TextElement
              name="postal_code"
              label="Postal Code"
              input-type="number"
              :disabled="isDeveloperSelected"
            />
            <TextElement
              name="latitude"
              label="Latitude"
              input-type="number"
              :disabled="isDeveloperSelected"
            />
            <TextElement
              name="longitude"
              label="Longitude"
              input-type="number"
              :disabled="isDeveloperSelected"
            />
          </GroupElement>

          <!--Image Uploads -->
          <GroupElement name="images_section" class="group-element-container">
            <StaticElement
              name="h2_images"
              content="Project Images"
              tag="h5"
              class="text-gray-500"
            />
            <StaticElement name="hr_images" tag="hr" />
            <FileElement
              name="hero_image"
              label="Cover Image"
              accept=".jpg,.png,.gif"
              :drop="true"
              :url="false"
              view="gallery"
              :columns="{ container: 6 }"
            />
            <FileElement
              name="image_360"
              label="360 Image"
              accept=".jpg,.png,.gif"
              :drop="true"
              :url="false"
              view="gallery"
              :columns="{ container: 6 }"
            />
            <StaticElement name="hr_images" tag="hr" />
            <MultifileElement
              name="floor_plan_images"
              label="Project Floor Plan"
              :drop="true"
              :url="false"
              view="gallery"
              accept=".jpg,.png,.gif"
              :columns="{ container: 6 }"
            />
            <MultifileElement
              name="project_gallery"
              label="Project Gallery"
              :drop="true"
              :url="false"
              view="gallery"
              accept=".jpg,.png,.gif"
              :columns="{ container: 6 }"
            />
            <StaticElement name="hr_images" tag="hr" />
            <TextElement
              name="video_link"
              label="Video Link"
              :columns="{ container: 6 }"
              rules="nullable|url"
            />
          </GroupElement>

          <!-- SEO -->
          <GroupElement
            name="seo_details"
            class="group-element-container"
            :columns="{ default: 12, lg: 6 }"
          >
            <StaticElement
              name="h2_seo"
              content="SEO Details"
              tag="h5"
              class="text-gray-500"
            />
            <StaticElement name="hr_seo" tag="hr" />
            <TextElement name="seo_title" label="SEO Title" />
            <TextareaElement name="seo_description" label="SEO Description" />
            <FileElement
              name="seo_image"
              placeholder="SEO Image"
              view="gallery"
            />
            <ToggleElement
              name="seo_indexing"
              text="Indexing"
              :labels="{ on: 'ON', off: 'OFF' }"
              :true-value="1"
              :false-value="0"
              width="w-full"
              size="md"
              class="mt-2"
            />
          </GroupElement>

          <GroupElement
            name="publish_section"
            class="group-element-container"
            :columns="{ default: 12, xl: 6 }"
          >
            <StaticElement
              name="h2_seo"
              content="Publish Dates and Status"
              tag="h5"
              class="text-gray-500"
            />
            <StaticElement name="hr_seo" tag="hr" />

            <DateElement
              name="publish_start_date"
              label="Publish Start Date"
              rules="required|date"
            />
            <DateElement
              name="publish_end_date"
              label="Publish End Date"
              abcdrules="after:publish_start_date"
              rules="required|date|after:publish_section.publish_start_date"
            />
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
  </div>
</template>

<script setup>
import Card from "@backend-components/ui/card.vue";
import BackendLayout from "@/layouts/backend-layout.vue";
import BreadcrumbAndPageTitle from "@backend-components/ui/breadcrumb-and-page-title.vue";

import {
  ref,
  onMounted,
  watch,
  computed,
  defineProps,
  defineEmits,
  reactive,
} from "vue";
import { useForm, usePage } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";

const breadcrumbs = ref([{ name: "Project", route: "admin.projects.index" }]);

const props = defineProps({
  features: Array,
  propertyTypes: Array,
  projectStatus: Array,
  project: Object,
  propertyDevelopers: Array,
  address: Object,
  metaContent: Object,
  areaUnits: Array,
  agencies: Array,
});

const vueFormRef = ref(null);
const formValues = reactive({});
// Populate form values based on project data
const fillValues = () => {
  //   const formValues = {};
  if (props.project) {
    Object.assign(formValues, {
      // Map project fields to the form keys
      agency_id: props.project.agency_id || "",
      name: props.project.name || "",
      slug: props.project.slug || "",
      short_description: props.project.short_description || "",
      description: props.project.description || "",

      // types and property_features
      property_types:
        props.project.property_types?.map((type) => type.id) || [],
      features: props.project.features || [],
      construction_type: props.project.construction_type || null,
      project_status_id: props.project.project_status_id || null,

      // Area and Price Range
      total_blocks: props.project.total_blocks || "",
      total_buildings: props.project.total_buildings || "",
      total_floors: props.project.total_floors || "",
      total_flats: props.project.total_flats || "",
      total_area: props.project.total_area || "",

      unit_id: props.project.unit_id || null,
      lowest_price: props.project.lowest_price || "",
      max_price: props.project.max_price || "",

      // Dates
      project_start_date: props.project.project_start_date || "",
      project_finish_date: props.project.project_finish_date || "",
      project_sale_start_date: props.project.project_sale_start_date || "",
      property_availability_date:
        props.project.property_availability_date || "",

      // Developer section
      developer_id: props.project.developer_id || "",

      // Developer Address section
      developer_name: props.project.developer?.developer_name || "",
      developer_email: props.project.developer?.developer_email || "",
      phone: props.project.developer?.developer_phone || "",
      developer_website: props.project.developer?.developer_website || "",

      country: props.project.developer?.address?.country || "",
      state: props.project.developer?.address?.state || "",
      city: props.project.developer?.address?.city || "",
      street: props.project.developer?.address?.street || "",
      building_number: props.project.developer?.address?.building_number || "",
      postal_code: props.project.developer?.address?.postal_code || "",
      latitude: props.project.developer?.address?.latitude || "",
      longitude: props.project.developer?.address?.longitude || "",

      hero_image: props.project.hero_image_path || null,
      image_360: props.project.image_360_path || null,
      floor_plan_images: props.project.floor_plan_image_path || [],
      project_gallery: props.project.gallery_image_path || [],
      video_link: props.project.video_link || "",

      // SEO
      // console.log(props.project.metaContent),
      seo_title: props.project.meta_content?.seo_title || "",
      seo_description: props.project.meta_content?.seo_description || "",
      seo_indexing: props.project.meta_content?.seo_indexing || 0,
      seo_image: props.project.meta_content?.image_path || null,

      publish_start_date: props.project.publish_start_date || "",
      publish_end_date: props.project.publish_end_date || "",
      is_published: props.project.is_published || 0,
      has_ads: props.project.has_ads || 0,
      is_featured: props.project.is_featured || 0,
      is_active: props.project.is_active || 0,
    });

    if (vueFormRef.value) {
      vueFormRef.value.update(formValues);
    }
  }
};

onMounted(() => {
  fillValues();
});

const rentingStatusId = computed(() => {
  return props.projectStatus.find(
    (status) => status.name.toLowerCase() === "renting"
  )?.id;
});

// Computed property to get the selected developer ID
const selectedDeveloperId = computed(
  () => props.modelValue?.developer_id ?? null
);

// const isDeveloperSelected = computed(() => !!project.value?.developer_id);
const isDeveloperSelected = computed(() => !!selectedDeveloperId.value);
// const isDeveloperSelected = computed(() => props.project?.developer_id !== null);
console.log("isDeveloperSelected: ", isDeveloperSelected);

const handleDeveloperChange = async (newDeveloperId) => {
  //   const newDeveloperId = event.target.value; // Get selected developer ID
  if (!newDeveloperId) return;

  if (newDeveloperId) {
    console.log("Fetching developers for ID:", newDeveloperId);

    try {
      const response = await axios.get("/admin/project/get-developers", {
        params: { developer_id: newDeveloperId },
      });

      const developer = response.data.developer;
      console.log("Fetched Developer:", developer);

      vueFormRef.value.update({
        developer_name: developer?.developer_name || "",
        developer_email: developer?.developer_email || "",
        phone: developer?.developer_phone || "",
        developer_website: developer?.developer_website || "",
        country: developer?.address?.country || "",
        state: developer?.address?.state || "",
        city: developer?.address?.city || "",
        street: developer?.address?.street || "",
        building_number: developer?.address?.building_number || "",
        postal_code: developer?.address?.postal_code || "",
        latitude: developer?.address?.latitude || "",
        longitude: developer?.address?.longitude || "",
    });

    } catch (error) {
      console.error("Error fetching developers:", error);
    }
  } else {
    console.log("No developers selected");
  }
};

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

const submitForm = async (FormData, form$) => {
  form$.clearMessages();

  const method = props.project?.id ? "put" : "post";

  const routeName = props.project?.id
    ? route("admin.projects.update", props.project.id)
    : route("admin.projects.store");

  const inertiaForm = useForm(form$.requestData);

  inertiaForm.submit(method, routeName, {
    preserveScroll: true,
    onError: (errors) => {
      console.log(errors);
      handleFormErrors(errors, form$);

      toast.error(
        (props.project?.id
          ? "Failed to update project"
          : "Failed to create project.") + " Please fix the errors."
      );
    },
    onSuccess: () => {
      form$.clearMessages();
      if (props.resetOnSuccess) {
        form$.clear();
        form$.reset();
      }
      toast.success(
        props.project?.id
          ? "Project updated successfully"
          : "Project created successfully"
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
        fieldPaths.push(
          ...getFieldPaths(listItems[index].children$, itemBasePath)
        );
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
  @apply rounded-md shadow dark:shadow-gray-700 p-6 bg-white dark:bg-slate-900 h-fit mt-2;
}

.form-step-element-wrapper {
  @apply rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900 px-6 pt-4 pb-0.75 mb-1;
}

.form-step-margin-fix {
  @apply mb-4 !important;
}
</style>
