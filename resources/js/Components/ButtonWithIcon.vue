<template>
  <button
    :name="name"
    :type="type"
    :id="id"
    :class="[
      'btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white searchbtn submit-btn !h-12',
      customClass,
    ]"
    @click="handleClick"
  >
    <i v-if="icon" :class="icon"></i>
    <span>{{ text }}</span>
  </button>
</template>

  <script setup>
const props = defineProps({
    name: {
    type: String,
    default: null,
  },
  id: {
    type: String,
    default: null,
  },
  type: {
    type: String,
    default: "button",
  },
  customClass: {
    type: String,
    default: "",
  },
  text: {
    type: String,
    required: true,
  },
  icon: {
    type: String,
    default: null,
  },
});

const emit = defineEmits(["click"]);

function handleClick() {
  emit("click");
}
</script>

<style scoped>

</style>
