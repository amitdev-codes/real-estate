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

      <RadiogroupElement
        name="accommodation_type"
        view="tabs"
        :items="['Buy', 'Sold', 'Rent', 'House & Land']"
        :rules="['required']"
        field-name="Accommodation type"
        default="Buy"
        label="Select accommodation type"
      />

      <LocationElement name="location" size="lg" />
    </div>

    <StaticElement name="h1" tag="h1" content="Property Types" bottom="1" />
    <CheckboxgroupElement
      view="tabs"
      name="property_types"
      :items="['House', 'Apartment', 'Condo', 'Townhouse', 'Other']"
      :columns="{
        container: 6,
      }"
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
import { computed, ref, defineEmits } from "vue";

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },
  filterOptions: {
    type: Array,
    default: () => [],
  },
});

const emit = defineEmits(["close"]);

const emitClose = () => {
  emit("close");
};

const applyFilters = () => {
  alert("Search in progress...");
  emit("close");
};

const sliderValue = ref([50000, 13000000]);

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

// Handle slider change event
const handleSliderChange = (value) => {
  sliderValue.value = value;
};
</script>

  <script>
export default {
  data() {
    return {
      sliderKey: 0, // Key to force re-render the slider
      isVisible: true, // Controls visibility
      units: ["Metres²", "Acres", "Hectares"], // Units for Radiogroup
      selectedUnit: "Metres²", // Default unit
      propertySizeSlider: 300, // Default slider value
      minValue: 0, // Minimum slider value
      maxValue: 10000, // Maximum slider value
      step: 100, // Slider step value
      sliderDefault: [300, 10000], // Default slider range (start with some default range)
    };
  },
  computed: {
    sliderLabel() {
      // Dynamically adjust the slider label based on the selected unit
      if (this.selectedUnit === "Metres²") {
        return `${this.propertySizeSlider} metres²`;
      } else if (this.selectedUnit === "Acres") {
        return `${this.propertySizeSlider} ac`;
      } else if (this.selectedUnit === "Hectares") {
        return `${this.propertySizeSlider} ha`;
      }
      return `${this.propertySizeSlider}`;
    },
  },
  methods: {
    handlePropertySizeChange(value) {
      this.selectedUnit = value;

      // Adjust slider settings based on the selected unit
      if (value === "Metres²") {
        this.sliderDefault = [300, 10000];
        this.maxValue = 10000;
        this.step = 100;
        this.propertySizeSlider = this.minValue; // Reset slider value
      } else if (value === "Acres") {
        this.minValue = 0;
        this.sliderDefault = [0, 1000];
        this.maxValue = 1000;
        this.step = 10;
        this.propertySizeSlider = this.minValue; // Reset slider value
      } else if (value === "Hectares") {
        this.sliderDefault = [0, 1000];
        this.minValue = 0;
        this.maxValue = 1000;
        this.step = 10;
        this.propertySizeSlider = this.minValue; // Reset slider value
      }

      // Force the component to re-render
      this.sliderKey++;
      console.log(`${this.selectedUnit}  >>>>>>`, this.sliderDefault);
    },

    handlePropertySizeUnitChange(newUnit) {
      console.log("New Unit:", newUnit);
      this.propertySizeSlider = newUnit; // Ensure the slider value changes
    },

    handleScroll() {
      // Detect the scroll direction
      const currentScroll = window.pageYOffset;
      this.isVisible = currentScroll < 100 || currentScroll < this.lastScroll;
      this.lastScroll = currentScroll;
    },
  },
  mounted() {
    this.lastScroll = 0; // Keep track of the last scroll position
    window.addEventListener("scroll", this.handleScroll);
  },
  beforeDestroy() {
    window.removeEventListener("scroll", this.handleScroll);
  },
};
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

