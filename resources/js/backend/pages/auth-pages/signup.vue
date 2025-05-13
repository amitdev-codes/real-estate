<template>
  <section
    class="h-screen flex items-center justify-center relative overflow-hidden bg-[url('@backend-assets/images/01.jpg')] bg-no-repeat bg-center bg-cover"
  >
    <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black"></div>
    <div class="container">
      <div class="grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1">
        <div
          class="relative overflow-hidden bg-white dark:bg-slate-900 shadow-md dark:shadow-gray-800 rounded-md"
        >
          <div class="p-6">
            <a href="">
              <img
                src="@backend-assets/images/logo-dark.png"
                class="mx-auto block dark:hidden"
                alt=""
              />
              <img
                src="@backend-assets/images/logo-light.png"
                class="mx-auto dark:block hidden"
                alt=""
              />
            </a>
            <h5 class="my-6 text-xl font-semibold">Signup</h5>
            <form class="text-start" @submit.prevent="submit">
              <div class="grid grid-cols-1">
                <div class="mb-4">
                  <label class="font-semibold" for="RegisterName">Your Name:</label>
                  <input
                    id="RegisterName"
                    v-model="form.name"
                    required
                    type="text"
                    class="form-input mt-3"
                    placeholder="Harry"
                  />
                  <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mb-4">
                  <label class="font-semibold" for="LoginEmail">Email Address:</label>
                  <input
                    id="LoginEmail"
                    v-model="form.email"
                    type="email"
                    class="form-input mt-3"
                    placeholder="name@example.com"
                  />
                  <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mb-4">
                  <label class="font-semibold" for="LoginPassword">Password:</label>
                  <input
                    id="LoginPassword"
                    v-model="form.password"
                    type="password"
                    class="form-input mt-3"
                    placeholder="Password:"
                  />
                  <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mb-4">
                  <label class="font-semibold" for="password_confirmation"
                    >Confirm Password:</label
                  >
                  <input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="form-input mt-3"
                    placeholder="new-password:"
                  />
                  <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="mb-4">
                  <div class="flex items-center mb-0">
                    <input
                      class="form-checkbox rounded border-gray-200 dark:border-gray-800 text-green-600 focus:border-green-300 focus:ring focus:ring-offset-0 focus:ring-green-200 focus:ring-opacity-50 me-2"
                      type="checkbox"
                      value=""
                      id="AcceptT&C"
                    />
                    <label class="form-check-label text-slate-400" for="AcceptT&C"
                      >I Accept
                      <a href="" class="text-green-600">Terms And Condition</a></label
                    >
                  </div>
                </div>

                <div class="mb-4">
                  <SuccessButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                  >
                    Register
                  </SuccessButton>
                </div>

                <div class="text-center">
                  <span class="text-slate-400 me-2">Already have an account ? </span>
                  <Link
                    :href="route('login')"
                    class="text-black dark:text-white font-medium"
                    >Sign in</Link
                  >
                </div>
              </div>
            </form>
          </div>

          <div class="px-6 py-2 bg-slate-50 dark:bg-slate-800 text-center">
            <p class="mb-0 text-slate-400">
              © {{ date }} Hously. Designed by
              <a href="https://shreethemes.in/" target="_blank" class="text-reset"
                >Shreethemes</a
              >.
            </p>
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
import Switcher from "@/backend/components/switcher.vue";
import InputError from "@/Components/InputError.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import SuccessButton from "@/Components/SuccessButton.vue";
const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});
const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};

const date = new Date().getFullYear();
</script>

<script>
export default {
  layout: EmptyLayout,
};
</script>
<style lang="scss" scoped></style>
