<template>
  <div class="relative lg:mt-24 mt-16">
    <div v-if="show_projects" class="grid grid-cols-1 pb-8 text-center">
      <h3
        class="mb-4 md:text-3xl md:leading-normal text-2xl leading-normal font-semibold"
      >
        Projects
      </h3>
    </div>

    <div v-if="featureds" :class="featuredgrid" class="grid gap-6">
      <div
        v-for="item in p"
        :key="item.id"
        class="group bg-white dark:bg-slate-900 shadow-lg hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500"
      >
        <Link
          :href="route('frontend.project.show', { slug: item.slug })"
          class="text-lg hover:text-green-600 font-medium ease-in-out duration-500"
        >
          <!-- Image Section -->
          <div class="relative">
            <img
              :src="item.hero_image_path"
              :alt="item.title"
              class="w-full h-64 object-cover"
            />

            <!-- Properties Count Badge -->
            <!-- <div class="absolute top-4 left-4 bg-blue-700 text-white text-sm font-medium px-3 py-1 rounded"> -->
            <div
              class="absolute top-4 left-4 text-white bg-green-600 px-3 py-1 text-base font-medium transition-all duration-500 ease-in-out"
            >
              {{ item.properties_count }} Properties
            </div>
            <!-- </div> -->

            <!-- Gradient Overlay -->
            <div
              class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black/100 to-transparent"
            ></div>

            <!-- Content Section -->
            <div
              class="absolute bottom-4 left-1/2 transform -translate-x-1/2 text-center text-white w-80"
            >
              <h3 class="text-white text-lg font-semibold">
                {{ item?.name }}
              </h3>
              <p class="text-sm text-gray-300 mt-1">
                {{
                  item?.developer.address.street
                    ? item.developer.address.street + ", "
                    : ""
                }}
                {{
                  item?.developer.address.city
                    ? item.developer.address.city + ", "
                    : ""
                }}
                {{
                  item?.developer.address.state
                    ? item.developer.address.state + " "
                    : ""
                }}
                {{
                  item?.developer.address.postal_code
                    ? item.developer.address.postal_code
                    : ""
                }}
              </p>
            </div>
          </div>
        </Link>
      </div>
    </div>
  </div>
</template>


<script setup>
import { ref, onMounted } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
  // Displays Fearured Property Heading and description
  // Todo: Make the Whole component visible/hidden based on it's value. Currently shows/hides only title and description
  featured: {
    type: Boolean,
    // required: true,
    default: true,
  },
  // Displays Featured Properties in featuredgrid tailwind css format
  // Todo: Optimize the code so that the content displayed is in a grid format or in a list format
  featureds: {
    type: Boolean,
    // required: true,
    default: true,
  },
  show_projects: {
    type: Boolean,
    default: true,
  },
  // If featureds prop is true then this tailwind class is accepted
  // Todo: This prop might be used for displaying properties either in grid format or list format
  featuredgrid: {
    type: String,
    // required: true,
    default: "grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-[30px]",
  },
  // If featureds prop is true then this tailwind class is accepted, which right now is empty, css class not found on other pages
  // Todo: This prop might be used for displaying properties either in grid format or list format
  grids: {
    type: String,
    // required: true,
    default: "",
  },
  projects_properties: {
    type: Object,
    required: true,
  },
});

const datas = ref(props.featured_properties);
const p = ref(props.projects_properties);

onMounted(() => {
  console.log("PROPERTY DATA >>> ", datas.value);
  console.log("PROJECTS DATA >>> ", p.value);
});

function getImage(fileName) {
  return new URL(
    `/resources/assets/frontend/images/property/${fileName}`,
    import.meta.url
  ).href;
}
</script>

  <style lang="scss" scoped></style>
