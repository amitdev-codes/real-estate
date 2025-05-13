<template>
  <Vueform size="md" :display-errors="false">
    <div
      class="bg-white overflow-hidden shadow-xl transform transition-all flex-1 grid grid-cols-12 col-span-12 px-16 py-10"
    >
      <StaticElement
        name="h1"
        tag="h1"
        content="Find your dream house"
        bottom="1"
      />

      <!-- <div>
          <h2>Debug Categories</h2>
          <pre>{{ categories }}</pre>
        </div> -->

      <!-- Debug Output -->
      <!-- <pre>Selected Parent Category: {{ selectedParentCategory }}</pre> -->

      <div>
          <h2>Debug Selected Category From Homepage</h2>
          <pre>{{ selected }}</pre>
        </div>
      <RadiogroupElement
        name="accommodation_type"
        view="tabs"
        :items="Object.keys(categories)"
        :rules="['required']"
        field-name="Accommodation type"
        v-model="selectedParentCategory"
        :default="selectedParentCategory"
        label="Select accommodation type"
        v-if="categories"
        @change="updateFilteredSubcategories"
      />

      <LocationElement name="location" size="lg" />
    </div>
    <!-- <pre>Filtered Subcategories: {{ childCategories }}</pre> -->
    <StaticElement name="h1" tag="h1" content="Property Types" bottom="1" />
    <CheckboxgroupElement
      view="tabs"
      name="property_types"
      :items="filteredSubcategories"
      :columns="{
        container: 6,
      }"
      v-if="filteredSubcategories.length > 0"
    />

    <div class="flex-1 grid grid-cols-12 col-span-12">
      <SliderElement
        @change="handleSliderChange"
        name="price_range"
        :tooltips="false"
        :default="[50000, 13000000]"
        :label="`Price range: ${formattedRange}`"
        :format="{
          prefix: '$',
          decimals: 0,
        }"
        :min="0"
        :max="13000000"
        :extend-options="{
          start: [0, 13000000],
          connect: true,
          range: {
            min: 0,
            '50%': 100000,
            max: 13000000,
          },
        }"
        :step="100"
        before="&nbsp;"
        :rules="['required']"
        :merge="7000"
      />
    </div>

    <StaticElement
      name="divider_24"
      tag="hr"
      :conditions="[['accommodation_type', 'in', ['Rent']]]"
    />
    <StaticElement
      name="h2_13"
      tag="h2"
      content="Availability"
      :conditions="[['accommodation_type', 'in', ['Rent']]]"
    />
    <StaticElement
      name="divider_25"
      tag="hr"
      :conditions="[['accommodation_type', 'in', ['Rent']]]"
    />
    <RadiogroupElement
      name="available_from"
      view="tabs"
      label="Date Available"
      :items="['Any Date', 'Available Now', 'On a specific date']"
      default="Available Now"
      :conditions="[['accommodation_type', 'in', ['Rent']]]"
    />
    <DateElement
      name="available_from_date"
      :date="true"
      :rules="['required']"
      :conditions="[['available_from', 'in', ['Available Now']]]"
      placeholder="Choose a date"
      :floating="false"
      display-format="DD/MM/YYYY"
      value-format="DD/MM/YYYY"
      load-format="DD/MM/YYYY"
      :default="new Date()"
    />
    <StaticElement name="divider_26" tag="hr" bottom="1" top="1" />

    <RadiogroupElement
      name="bedrooms"
      view="tabs"
      :items="['1+', '2+', '3+', '4+', '5+']"
      :rules="['required']"
      field-name="Bedrooms"
      default="1+"
      label="Select Bedrooms"
    />

    <RadiogroupElement
      name="bathrooms"
      view="tabs"
      :items="['1+', '2+', '3+', '4+', '5+']"
      :rules="['required']"
      field-name="Bathrooms"
      default="1+"
      label="Select Bathrooms"
    />

    <RadiogroupElement
      name="bedrooms"
      view="tabs"
      :items="['1+', '2+', '3+', '4+', '5+']"
      :rules="['required']"
      field-name="Bedrooms"
      default="1+"
      label="Select Bedrooms"
    />

    <!-- <DateElement
          name="check_in"
          display-format="MMM DD, YYYY"
          placeholder="Check-in"
          :columns="{
            container: 6,
          }"
          size="lg"
          :rules="['after_or_equal:today']"
        />
        <DateElement
          name="check_out"
          display-format="MMM DD, YYYY"
          placeholder="Check-out"
          :columns="{
            container: 6,
          }"
          size="lg"
          :rules="['after_or_equal:check_in']"
        /> -->
    <!-- <TextElement
          name="adults"
          input-type="number"
          :rules="['min:1', 'integer']"
          autocomplete="off"
          default="1"
          :columns="{
            container: 4,
            label: 12,
            wrapper: 12,
          }"
          placeholder="Adults"
          size="lg"
        />
        <TextElement
          name="kids"
          input-type="number"
          :rules="['nullable', 'min:0', 'integer']"
          autocomplete="off"
          default="0"
          :columns="{
            container: 4,
            label: 12,
            wrapper: 12,
          }"
          placeholder="Kids"
          size="lg"
        />
        <TextElement
          name="rooms"
          input-type="number"
          :rules="['nullable', 'min:0', 'integer']"
          autocomplete="off"
          :columns="{
            container: 4,
            label: 12,
            wrapper: 12,
          }"
          default="1"
          placeholder="Rooms"
          size="lg"
        /> -->
    <!-- <CheckboxElement
          name="is_standalone"
          text="Standalone only"
          :rules="['integer']"
        />
        <CheckboxElement
          name="is_business_trip"
          text="Business trip"
          :rules="['integer']"
        /> -->

    <ToggleElement name="advanced" text="Advanced search" />

    <StaticElement name="divider" tag="hr" />

    <GroupElement name="container" :conditions="[['advanced', '==', true]]">
      <!-- Radio Group for Property Size -->
      <RadiogroupElement
        @change="handlePropertySizeChange"
        name="property_size"
        view="tabs"
        :items="['Metres²', 'Acres', 'Hectares']"
        :rules="['required']"
        field-name="Property Size"
        default="Metres²"
        label="Select Property Size"
      />

      <!-- Slider for Property Size Range -->

      <SliderElement
        :key="sliderKey"
        @change="handlePropertySizeUnitChange"
        name="property_size_range"
        :default="sliderDefault"
        :label="sliderLabel"
        :tooltips="false"
        :max="maxValue"
        :min="minValue"
        :step="step"
        v-model="propertySizeSlider"
        :rules="['required']"
      />

      <StaticElement name="divider" tag="hr" />

      <CheckboxgroupElement
        name="features"
        label="Features"
        :items="[
          'Pets allowed',
          'Gas',
          'Balcony / deck',
          'Study',
          'Air conditioning',
          'Built-in wardrobes',
          'Garden / courtyard',
          'Interal laundry',
          'Swimming pool',
        ]"
        :columns="{
          container: 6,
        }"
      />
      <StaticElement name="divider_2" tag="hr" />

      <SelectElement
        name="property_status"
        :columns="{
          container: 6,
          label: 12,
          wrapper: 12,
        }"
        :items="['Any', 'New constructions', 'Established']"
        label="New/Established"
        default="New constructions"
        :rules="['required']"
      />
      <StaticElement name="divider_2" tag="hr" />

      <TextElement
        name="keywords"
        input-type="text"
        autocomplete="off"
        :columns="{
          container: 12,
        }"
        placeholder="Search your keywords"
        size="lg"
      />
    </GroupElement>

    <ButtonElement
      name="search"
      button-label="Search"
      :submits="true"
      size="lg"
      align="center"
      :full="false"
      :class="{
        'fixed-bottom-visible': isVisible,
        'fixed-bottom-hidden': !isVisible,
      }"
    />
  </Vueform>
</template>

<script setup>

import { ref, computed, onMounted, onUnmounted, watch, defineEmits } from "vue";
import axios from "axios";

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },
  filterOptions: {
    type: Array,
    default: () => [],
  },
  categories: {
    type: Object,
    required: true,
  },
  selected: {
    type: String,
    required: true,
  },
});

// Emits
const emit = defineEmits(["close"]);

// Reactive Data Eta hai
const categories = ref([]);
const selected = ref(props.selected);
const selectedParentCategory = ref(props.selected);
const sliderValue = ref([50000, 13000000]);
console.log("Categories : ", categories);

const sliderKey = ref(0);
const isVisible = ref(true);
const units = ref(["Metres²", "Acres", "Hectares"]);
const selectedUnit = ref("Metres²");
const propertySizeSlider = ref(300);
const minValue = ref(0);
const maxValue = ref(10000);
const step = ref(100);
const sliderDefault = ref([300, 10000]);
const lastScroll = ref(0);

const emitClose = () => {
  emit("close");
};

const applyFilters = () => {
  alert("Search in progress...");
  emit("close");
};

// ########## Computed Properties #################################
// Computed property for formatted range
const formattedRange = computed(() =>
  sliderValue.value
    .map((value) => {
      if (value >= 1000000) {
        return `${(value / 1000000).toFixed()}m`;
      } else if (value >= 1000) {
        return `${(value / 1000).toFixed()}k`;
      } else {
        return `${value}`;
      }
    })
    .join(" - ")
);

const sliderLabel = computed(() => {
  if (selectedUnit.value === "Metres²") {
    return `${propertySizeSlider.value} metres²`;
  } else if (selectedUnit.value === "Acres") {
    return `${propertySizeSlider.value} ac`;
  } else if (selectedUnit.value === "Hectares") {
    return `${propertySizeSlider.value} ha`;
  }
  return `${propertySizeSlider.value}`;
});

// Handle slider change event
const handleSliderChange = (value) => {
  sliderValue.value = value;
};

const filteredSubcategories = ref([]);

// Function to update filtered subcategories based on the selected parent category
const updateFilteredSubcategories = (parentCategory) => {
  console.log("Parent category selected >>> ", parentCategory);
  filteredSubcategories.value = categories.value[parentCategory] ?? [];
  selected.value = parentCategory;
};

// Update filteredSubcategories on change
watch(selectedParentCategory, (newValue) => {
  console.log("Parent category changed to:", newValue);
  updateFilteredSubcategories(newValue);
});

//############ Methods #########################
// Fetch categories from the server
const fetchCategories = async () => {
  try {
    const response = await axios.get("search/categories");
    categories.value = response.data;
    console.log("Fetched categories:", categories.value);
  } catch (error) {
    console.error("Failed to fetch categories:", error);
  }
};

const handlePropertySizeChange = (value) => {
  selectedUnit = value;

  // Adjust slider settings based on the selected unit
  if (value === "Metres²") {
    sliderDefault = [300, 10000];
    maxValue = 10000;
    step = 100;
    propertySizeSlider = minValue; // Reset slider value
  } else if (value === "Acres") {
    minValue = 0;
    sliderDefault = [0, 1000];
    maxValue = 1000;
    step = 10;
    propertySizeSlider = minValue; // Reset slider value
  } else if (value === "Hectares") {
    sliderDefault = [0, 1000];
    minValue = 0;
    maxValue = 1000;
    step = 10;
    propertySizeSlider = minValue; // Reset slider value
  }

  // Force the component to re-render
  this.sliderKey++;
  console.log(`${this.selectedUnit}  >>>>>>`, this.sliderDefault);
};

const handlePropertySizeUnitChange = (newUnit) => {
  console.log("New Unit:", newUnit);
  propertySizeSlider = newUnit; // Ensure the slider value changes
};

const handleScroll = () => {
  // Detect the scroll direction
  const currentScroll = window.pageYOffset;
  isVisible.value = currentScroll < 100 || currentScroll < lastScroll.value;
  lastScroll.value = currentScroll;
};

// Lifecycle Hooks
onMounted(async () => {

  console.log("this is from homepage category selected >>> ", selected.value);

  await fetchCategories();
  console.log("Categories after fetch: ", categories.value);

  // Once categories are populated, then access selected category
  if (selected.value && categories.value && categories.value[selectedParentCategory.value]) {
    console.log(
      "Subcategories for Buy: ",
      categories.value[selectedParentCategory.value]
    );
  } else {
    console.log("No categories found for ", selectedParentCategory.value);
  }

  filteredSubcategories.value = categories.value[selectedParentCategory.value] ?? [];

  lastScroll.value = 0; // Keep track of the last scroll position
  window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
  window.removeEventListener("scroll", handleScroll);
});

</script>


    <style scoped>
.fixed {
  position: fixed;
  bottom: 0;
  width: 100%;
  display: flex;
  justify-content: center;
  z-index: 1000;
}
</style>

