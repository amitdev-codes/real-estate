<template>
    <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 gap-8">
                <!-- Section Title with Filter Options -->
                <div class="mb-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <h3 class="text-2xl leading-normal font-medium">
                            My Shortlists
                        </h3>
                        
                        <!-- Filter Controls -->
                        <div class="flex flex-col md:flex-row items-center gap-3">
                            <div class="relative w-full md:w-auto">
                                <select 
                                    v-model="filters.propertyType" 
                                    class="form-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-600 focus:border-green-600 rounded-md"
                                >
                                    <option value="">All Property Types</option>
                                    <option value="Apartment">Apartment</option>
                                    <option value="House">House</option>
                                    <option value="Commercial">Commercial</option>
                                    <option value="Land">Land</option>
                                </select>
                            </div>
                            
                            <div class="relative w-full md:w-auto">
                                <select 
                                    v-model="filters.agentId" 
                                    class="form-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-600 focus:border-green-600 rounded-md"
                                >
                                    <option value="">All Agents</option>
                                    <option v-for="agent in agents" :key="agent.id" :value="agent.id">
                                        {{ agent.name }}
                                    </option>
                                </select>
                            </div>
                            
                            <div class="relative w-full md:w-auto">
                                <select 
                                    v-model="filters.agencyId" 
                                    class="form-select block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-green-600 focus:border-green-600 rounded-md"
                                >
                                    <option value="">All Agencies</option>
                                    <option v-for="agency in agencies" :key="agency.id" :value="agency.id">
                                        {{ agency.name }}
                                    </option>
                                </select>
                            </div>
                            
                            <button 
                                @click="applyFilters" 
                                class="btn bg-green-600 hover:bg-green-700 text-white rounded-md px-4 py-2 w-full md:w-auto"
                            >
                                Apply Filters
                            </button>
                            
                            <button 
                                v-if="isFiltered" 
                                @click="resetFilters" 
                                class="btn bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md px-4 py-2 w-full md:w-auto"
                            >
                                Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div
                    v-if="!Object.keys(filteredShortlists).length"
                    class="relative overflow-hidden rounded-lg bg-white dark:bg-slate-900 shadow dark:shadow-gray-800 p-8 text-center"
                >
                    <div class="text-gray-500 dark:text-gray-300">
                        {{ isFiltered ? 'No properties match your filter criteria.' : 'Your shortlist is empty.' }}
                    </div>
                </div>

                <!-- Shortlist Groups -->
                <div v-else class="space-y-8">
                    <div
                        v-for="(group, index) in filteredShortlists"
                        :key="index"
                        class="space-y-6"
                    >
                        <!-- Group Title -->
                        <h4 class="text-xl font-medium">{{ group.type }}</h4>

                        <!-- Cards Grid -->
                        <div
                            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                        >
                            <!-- Individual Cards -->
                            <div
                                v-for="shortlist in group.items"
                                :key="shortlist.id"
                                class="group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500"
                            >
                                <div class="relative">
                                    <!-- Property Image -->
                                    <img :src="shortlist.item.image" alt="" />

                                    <!-- Heart Icon (Remove from Shortlist) -->
                                    <div class="absolute top-4 end-4">
                                        <button
                                            @click="
                                                removeFromShortlist(
                                                    shortlist.item.id,
                                                    group.type
                                                )
                                            "
                                            class="btn btn-icon bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 rounded-full text-red-600 hover:text-red-700"
                                        >
                                            <i class="mdi mdi-heart text-[20px]"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Property Details -->
                                <div class="p-6">
                                    <div class="pb-6">
                                        <Link
                                            :href="route('frontend.property-detail-two', { slug: shortlist.item.slug })"
                                            class="text-lg hover:text-green-600 font-medium ease-in-out duration-500"
                                            >{{ shortlist.item.title }}
                                        </Link>
                                    </div>

                                    <!-- Agency & Agent info (if available) -->
                                    <div v-if="shortlist.item.agent || shortlist.item.agency" class="pb-4">
                                        <p v-if="shortlist.item.agent" class="text-sm text-slate-500">
                                            <span class="font-medium">Agent:</span> {{ shortlist.item.agent.first_name }}
                                        </p>
                                        <p v-if="shortlist.item.agency" class="text-sm text-slate-500">
                                            <span class="font-medium">Agency:</span> {{ shortlist.item.agency.name }}
                                        </p>
                                    </div>

                                    <!-- Property Features (SQF, Beds, Baths) -->
                                    <ul
                                        class="py-6 border-y border-slate-100 dark:border-gray-800 flex items-center list-none"
                                    >
                                        <li class="flex items-center me-4">
                                            <i
                                                class="uil uil-compress-arrows text-2xl me-2 text-green-600"
                                            ></i>
                                            <span>{{ shortlist.item.area }}</span>
                                        </li>

                                        <li class="flex items-center me-4">
                                            <i
                                                class="uil uil-bed-double text-2xl me-2 text-green-600"
                                            ></i>
                                            <span>{{ shortlist.item.bedrooms }}</span>
                                        </li>

                                        <li class="flex items-center">
                                            <i
                                                class="uil uil-bath text-2xl me-2 text-green-600"
                                            ></i>
                                            <span>{{ shortlist.item.bathrooms }}</span>
                                        </li>
                                    </ul>

                                    <!-- Price Section -->
                                    <ul class="pt-6 flex justify-between items-center list-none">
                                        <li>
                                            <span class="text-slate-400">Price</span>
                                            <p class="text-lg font-medium">{{ shortlist.item.base_price }}</p>
                                        </li>
                                        
                                        <!-- Notes Button -->
                                        <li>
                                            <button 
                                                @click="openNotesModal(shortlist)" 
                                                class="text-sm text-green-600 hover:text-green-700"
                                            >
                                                {{ shortlist.notes ? 'Edit Notes' : 'Add Notes' }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from "vue";
import { router } from "@inertiajs/vue3";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps({
    groupedShortlists: Object,
    agents: {
        type: Array,
        default: () => []
    },
    agencies: {
        type: Array,
        default: () => []
    }
});

// Filter state
const filters = ref({
    propertyType: '',
    agentId: '',
    agencyId: ''
});

// Notes modal state
const notesModal = ref({
    open: false,
    shortlist: null,
    notes: ''
});

// Computed property to check if filters are applied
const isFiltered = computed(() => {
    return filters.value.propertyType || filters.value.agentId || filters.value.agencyId;
});

// Computed property to filter shortlists based on selected filters
const filteredShortlists = computed(() => {
    if (!isFiltered.value) {
        return props.groupedShortlists;
    }

    const result = {};

    

    // Debugging: Log the groupedShortlists
    // console.log('groupedShortlists:', props.groupedShortlists);

    // Dynamically access the key in groupedShortlists
    const shortlistKey = Object.keys(props.groupedShortlists)[0]; // Get the first key (e.g., "Modules\Property\Models\Property")
    const shortlistGroup = props.groupedShortlists[shortlistKey];

    if (shortlistGroup) {
        const filteredItems = shortlistGroup.items.filter(item => {
            // Debugging: Log the current item
            // Filter by property type if selected
            if (filters.value.propertyType && item.item.property_type !== filters.value.propertyType) {
                console.log('Filtered out by property type:', item.item.property_type);
                return false;
            }

            // Filter by agent if selected
            if (filters.value.agentId && item.item.agent_id != filters.value.agentId) {
                console.log('Filtered out by agent:', item.item.agent_id);
                return false;
            }

            // Filter by agency if selected
            if (filters.value.agencyId && item.item.agency_id != filters.value.agencyId) {
                console.log('Filtered out by agency:', item.item.agency_id);
                return false;
            }

            return true;
        });

        if (filteredItems.length > 0) {
            result[shortlistKey] = {
                type: shortlistGroup.type,
                items: filteredItems,
            };
        }
    }

    // Debugging: Log the filtered result
    // console.log('Filtered result:', result);

    return result;
});

// Function to reset filters
function resetFilters() {
    filters.value.propertyType = '';
    filters.value.agentId = '';
    filters.value.agencyId = '';
}

// Function to remove an item from the shortlist
async function removeFromShortlist(itemId, type) {
    try {
        await axios.post("/shortlist/toggle", {
            shortlistable_id: itemId,
            shortlistable_type: `App\\Models\\${type}`,
        });
        router.reload(); // Reload the page to reflect the changes
    } catch (error) {
        console.error("Error removing from shortlist:", error);
    }
}

// Notes modal functions
function openNotesModal(shortlist) {
    notesModal.value = {
        open: true,
        shortlist,
        notes: shortlist.notes || ''
    };
}

function closeNotesModal() {
    notesModal.value.open = false;
}

async function saveNotes() {
    try {
        await axios.patch(
            `/shortlist/${notesModal.value.shortlist.id}/notes`, 
            { notes: notesModal.value.notes }
        );
        
        // Update the notes in our local data
        notesModal.value.shortlist.notes = notesModal.value.notes;
        closeNotesModal();
    } catch (error) {
        console.error("Error saving notes:", error);
    }
}
</script>

<script>
import FrontendLayout from "@/layouts/frontend-layout.vue";
export default {
    layout: FrontendLayout,
};
</script>