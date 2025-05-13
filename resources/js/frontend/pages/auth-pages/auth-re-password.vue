<template>
  <section
    class="md:h-screen py-36 flex items-center relative overflow-hidden zoom-image"
  >
    <div
      class="absolute inset-0 image-wrap z-1 bg-[url('@frontend-assets/images/bg/01.jpg')] bg-no-repeat bg-center bg-cover"
    ></div>
    <div
      class="absolute inset-0 bg-gradient-to-b from-transparent to-black z-2"
      id="particles-snow"
    ></div>
    <div class="container relative z-3">
      <div class="flex justify-center">
        <div
          class="max-w-[400px] w-full m-auto p-6 bg-white dark:bg-slate-900 shadow-md dark:shadow-gray-700 rounded-md"
        >
          <Link :href="route('frontend.index-one')"
            ><img src="@frontend-assets/images/logo-icon-64.png" class="mx-auto" alt=""
          /></Link>
          <h5 class="my-6 text-xl font-semibold">Reset Your Password</h5>
          <div class="grid grid-cols-1">
            <p class="text-slate-400 mb-6">
              Please enter your email address. You will receive a link to create a new
              password via email.
            </p>
            <form @submit.prevent="submit">
              <div class="grid grid-cols-1">
                <div class="mb-4">
                  <label class="font-medium" for="LoginEmail">Email Address:</label>
                  <input
                    id="LoginEmail"
                    type="email"
                    v-model="form.email"
                    class="form-input mt-3"
                    placeholder="name@example.com"
                  />
                  <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mb-4">
                  <SuccessButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                  >
                    Send
                  </SuccessButton>
                </div>

                <div class="text-center">
                  <span class="text-slate-400 me-2">Remember your password ? </span>
                  <Link
                    :href="route('login')"
                    class="text-black dark:text-white font-bold"
                    >Sign in</Link
                  >
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--end section -->
  <Switcher :back="true" />
</template>

<script setup>
import EmptyLayout from "@/layouts/empty-layout.vue";
import Switcher from "@/frontend/components/switcher.vue";
import { useForm } from "@inertiajs/vue3";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputError from "@/Components/InputError.vue";

defineProps({
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
});
const submit = () => {
  form.post(route("password.email"));
};
</script>

<script>
export default {
  layout: EmptyLayout,
};
</script>

<style lang="scss" scoped></style>
