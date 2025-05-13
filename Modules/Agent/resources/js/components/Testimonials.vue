<template>
  <div class="space-y-6">
    <h3 class="text-lg font-medium text-gray-900">Agent Testimonials</h3>
    <p class="text-sm text-gray-500">
      Add testimonials from your satisfied clients. These will be displayed on your
      profile.
    </p>

    <MediaModal
      ref="mediaModal"
      model="agent"
      :modelId="props.data.id"
      collection="agent_testimonials"
      title="Agent Testimonials"
      @update:modelValue="handleMediaUpdate"
    />

    <!-- Display existing testimonials -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
      <div
        v-for="testimonial in testimonials"
        :key="testimonial.id"
        class="border rounded-lg p-4 relative"
      >
        <!-- Display testimonial thumbnail -->
        <img
          :src="testimonial.thumb_url"
          :alt="'Testimonial ' + testimonial.id"
          class="w-full h-40 object-cover rounded-md"
        />
        <!-- Display testimonial preview link -->
        <a
          :href="testimonial.preview_url"
          target="_blank"
          class="text-blue-500 underline mt-2"
        >
          View Full Testimonial
        </a>
      </div>
    </div>

    <!-- Add testimonial button -->
    <button
      @click="$refs.mediaModal.openModal()"
      class="flex items-center justify-center w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50"
    >
      <span class="mdi mdi-plus mr-2"></span>
      Add Testimonial
    </button>
  </div>
</template>

<script setup>
import { ref } from "vue";
import MediaModal from "@/backend/components/ui/inputs/MediaModal.vue";
import { usePage } from "@inertiajs/vue3";

const props = defineProps({
  data: {
    type: Object,
    required: true,
  },
});

const testimonials = usePage().props.testimonials;

console.log("testimonials", testimonials);

const handleMediaUpdate = (newMedia) => {
  if (Array.isArray(newMedia)) {
    data.testimonials = newMedia.map((media) => ({
      id: media.id,
      preview_url: media.preview_url,
      thumb_url: media.thumb_url,
    }));
  }
};
</script>
