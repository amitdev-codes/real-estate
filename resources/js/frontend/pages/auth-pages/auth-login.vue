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
          <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
          </div>
          <Link :href="route('frontend.index-one')"
            ><img src="@frontend-assets/images/logo-icon-64.png" class="mx-auto" alt=""
          /></Link>
          <h5 class="my-6 text-xl font-semibold">Login</h5>

          <form class="text-start" @submit.prevent="submit">
            <div class="grid grid-cols-1">
              <div class="mb-4">
                <label class="font-medium" for="LoginEmail">Email Address:</label>
                <input
                  id="LoginEmail"
                  type="email"
                  class="form-input mt-3"
                  placeholder="name@example.com"
                  v-model="form.email"
                />
                <InputError class="mt-2" :message="form.errors.email" />
              </div>

              <div class="mb-4">
                <label class="font-medium" for="LoginPassword">Password:</label>
                <input
                  id="LoginPassword"
                  type="password"
                  class="form-input mt-3"
                  placeholder="Password:"
                  v-model="form.password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
              </div>

              <div class="flex justify-between mb-4">
                <div class="flex items-center mb-0">
                  <input
                    class="form-checkbox rounded border-gray-200 dark:border-gray-800 text-green-600 focus:border-green-300 focus:ring focus:ring-offset-0 focus:ring-green-200 focus:ring-opacity-50 me-2"
                    type="checkbox"
                    value=""
                    id="RememberMe"
                  />
                  <label class="form-checkbox-label text-slate-400" for="RememberMe"
                    >Remember me</label
                  >
                </div>
                <p class="text-slate-400 mb-0">
                  <Link :href="route('password.request')" class="text-slate-400"
                    >Forgot password ?</Link
                  >
                </p>
              </div>

              <div class="mb-4">
                <SuccessButton
                  :class="{ 'opacity-25': form.processing }"
                  :disabled="form.processing"
                >
                  Log in
                </SuccessButton>
              </div>

              <div class="text-center">
                <span class="text-slate-400 me-2">Don't have an account ?</span>
                <Link
                  :href="route('register')"
                  class="text-black dark:text-white font-bold"
                  >Sign Up</Link
                >
              </div>
            </div>
          </form>
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
import { Head, Link, useForm } from "@inertiajs/vue3";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputError from "@/Components/InputError.vue";

defineProps({
  canResetPassword: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  email: "",
  password: "",
  remember: true,
});
const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};
</script>

<script>
export default {
  layout: EmptyLayout,
};
</script>

<style lang="scss" scoped></style>
