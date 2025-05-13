<template>
  <NavSearch></NavSearch>
  <!-- Form content -->
  <div class="mt-4 space-y-6">
    <!-- Property Types -->
    <div class="property-types">
      <h4 class="text-lg font-semibold">Property Types</h4>
      <div class="flex space-x-2">
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedType('All') }"
          @click="selectType('All')"
        >
          All
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedType('House') }"
          @click="selectType('House')"
        >
          House
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedType('Apartment') }"
          @click="selectType('Apartment')"
        >
          Apartment
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedType('Townhouse') }"
          @click="selectType('Townhouse')"
        >
          Townhouse
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedType('Land') }"
          @click="selectType('Land')"
        >
          Land
        </button>
      </div>
    </div>

    <!-- Price -->
    <div class="price-filter">
      <h4 class="text-lg font-semibold">Price</h4>
      <input
        type="range"
        v-model="price"
        min="0"
        max="10000000"
        class="w-full mt-2"
      />
      <div class="text-gray-500">Selected Price: {{ formatPrice(price) }}</div>
    </div>

    <!-- Bedrooms -->
    <div class="bedrooms-filter">
      <h4 class="text-lg font-semibold">Bedrooms</h4>
      <div class="flex space-x-2">
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBedrooms('Any') }"
          @click="selectBedrooms('Any')"
        >
          Any
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBedrooms(1) }"
          @click="selectBedrooms(1)"
        >
          1+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBedrooms(2) }"
          @click="selectBedrooms(2)"
        >
          2+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBedrooms(3) }"
          @click="selectBedrooms(3)"
        >
          3+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBedrooms(4) }"
          @click="selectBedrooms(4)"
        >
          4+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBedrooms(5) }"
          @click="selectBedrooms(5)"
        >
          5+
        </button>
      </div>
    </div>

    <!-- Bathrooms, Parking, and more filters can follow the same structure -->
    <!-- Date Available -->
    <div class="date-available">
      <h4 class="text-lg font-semibold">Date Available</h4>
      <div class="flex space-x-4">
        <input
          type="date"
          v-model="availableDate"
          class="form-input w-full bg-gray-50 border border-gray-300 rounded-md"
          placeholder="Choose a date"
        />
      </div>
    </div>

    <!-- Bedrooms -->
    <div class="bedrooms-filter">
      <h4 class="text-lg font-semibold">Bedrooms</h4>
      <div class="flex space-x-2">
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBedrooms('Any') }"
          @click="selectBedrooms('Any')"
        >
          Any
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBedrooms(1) }"
          @click="selectBedrooms(1)"
        >
          1+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBedrooms(2) }"
          @click="selectBedrooms(2)"
        >
          2+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBedrooms(3) }"
          @click="selectBedrooms(3)"
        >
          3+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBedrooms(4) }"
          @click="selectBedrooms(4)"
        >
          4+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBedrooms(5) }"
          @click="selectBedrooms(5)"
        >
          5+
        </button>
      </div>
    </div>

    <!-- Bathrooms -->
    <div class="bathrooms-filter">
      <h4 class="text-lg font-semibold">Bathrooms</h4>
      <div class="flex space-x-2">
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBathrooms('Any') }"
          @click="selectBathrooms('Any')"
        >
          Any
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBathrooms(1) }"
          @click="selectBathrooms(1)"
        >
          1+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBathrooms(2) }"
          @click="selectBathrooms(2)"
        >
          2+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBathrooms(3) }"
          @click="selectBathrooms(3)"
        >
          3+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBathrooms(4) }"
          @click="selectBathrooms(4)"
        >
          4+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedBathrooms(5) }"
          @click="selectBathrooms(5)"
        >
          5+
        </button>
      </div>
    </div>

    <!-- Parking -->
    <div class="parking-filter">
      <h4 class="text-lg font-semibold">Parking</h4>
      <div class="flex space-x-2">
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedParking('Any') }"
          @click="selectParking('Any')"
        >
          Any
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedParking(1) }"
          @click="selectParking(1)"
        >
          1+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedParking(2) }"
          @click="selectParking(2)"
        >
          2+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedParking(3) }"
          @click="selectParking(3)"
        >
          3+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedParking(4) }"
          @click="selectParking(4)"
        >
          4+
        </button>
        <button
          class="btn"
          :class="{ 'bg-green-600 text-white': isSelectedParking(5) }"
          @click="selectParking(5)"
        >
          5+
        </button>
      </div>
    </div>

    <!-- Property Size -->
    <div class="property-size">
      <h4 class="text-lg font-semibold">Property Size</h4>
      <input
        type="range"
        v-model="propertySize"
        min="0"
        max="10000"
        class="w-full mt-2"
      />
      <div class="text-gray-500">Selected Size: {{ propertySize }} m²</div>
    </div>

    <!-- Features -->
    <div class="features-filter">
      <h4 class="text-lg font-semibold">Features</h4>
      <div class="grid grid-cols-2 gap-4">
        <label
          ><input type="checkbox" v-model="features.pets" /> Pets allowed</label
        >
        <label><input type="checkbox" v-model="features.gas" /> Gas</label>
        <label
          ><input type="checkbox" v-model="features.balcony" /> Balcony /
          deck</label
        >
        <label><input type="checkbox" v-model="features.study" /> Study</label>
        <label
          ><input type="checkbox" v-model="features.dishwasher" />
          Dishwasher</label
        >
        <label
          ><input type="checkbox" v-model="features.wardrobes" /> Built in
          wardrobes</label
        >
        <label
          ><input type="checkbox" v-model="features.garden" /> Garden /
          courtyard</label
        >
        <label
          ><input type="checkbox" v-model="features.laundry" /> Internal
          laundry</label
        >
        <label
          ><input type="checkbox" v-model="features.furnished" />
          Furnished</label
        >
      </div>
    </div>

    <!-- New/Established -->
    <div class="new-established-filter">
      <h4 class="text-lg font-semibold">New/Established</h4>
      <select
        v-model="newEstablished"
        class="form-input w-full bg-gray-50 border border-gray-300 rounded-md"
      >
        <option value="Any">Any</option>
        <option value="New">New</option>
        <option value="Established">Established</option>
      </select>
    </div>

    <!-- Keywords -->
    <div class="keywords-filter">
      <h4 class="text-lg font-semibold">Keywords</h4>
      <input
        type="text"
        v-model="keywords"
        class="form-input w-full bg-gray-50 border border-gray-300 rounded-md"
        placeholder="e.g. waterfront, views, street name"
      />
    </div>

    <ul>
      <li v-for="option in filterOptions" :key="option.id">
        {{ option.name }}
      </li>
    </ul>

    <!-- Submit or Cancel buttons -->
    <div class="flex justify-end mt-6">
      <button
        @click="emitClose"
        class="btn bg-gray-600 text-white hover:bg-gray-700 rounded-full px-4 py-2 mr-2"
      >
        Cancel
      </button>
      <button
        @click="applyFilters"
        class="btn bg-green-600 text-white hover:bg-green-700 rounded-full px-4 py-2"
      >
        Apply Filters
      </button>
    </div>
  </div>
</template>

<script setup>
import NavSearch from "@/Components/NavSearch.vue";
import { ref, defineEmits } from "vue";

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

// Filter data
const selectedType = ref("All");
const availableDate = ref("");
const selectedBedrooms = ref("Any");
const selectedBathrooms = ref("Any");
const selectedParking = ref("Any");
const propertySize = ref(1000);
const price = ref(0);
const features = ref({
  pets: false,
  gas: false,
  balcony: false,
  study: false,
  dishwasher: false,
  wardrobes: false,
  garden: false,
  laundry: false,
  furnished: false,
});
const newEstablished = ref("Any");
const keywords = ref("");

function selectType(type) {
  selectedType.value = type;
}

function isSelectedType(type) {
  return selectedType.value === type;
}

function selectBedrooms(count) {
  selectedBedrooms.value = count;
}

function isSelectedBedrooms(count) {
  return selectedBedrooms.value === count;
}

function formatPrice(value) {
  return new Intl.NumberFormat("en-US", {
    style: "currency",
    currency: "USD",
  }).format(value);
}

const selectBathrooms = (bathrooms) => (selectedBathrooms.value = bathrooms);
const isSelectedBathrooms = (bathrooms) =>
  selectedBathrooms.value === bathrooms;

const selectParking = (parking) => (selectedParking.value = parking);
const isSelectedParking = (parking) => selectedParking.value === parking;

const emit = defineEmits(['close']);

const emitClose = () => {
  emit('close');
};

const applyFilters = () => {
  alert('Search in progress...');
  emit('close');
};

</script>

<style scoped>
</style>
