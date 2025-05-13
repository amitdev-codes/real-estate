<template>
  <section
    class="h-screen flex items-center justify-center relative overflow-hidden bg-[url('@backend-assets/images/01.jpg')] bg-no-repeat bg-left-bottom bg-cover"
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
            <h5 class="my-6 text-xl font-semibold">Reset Your Password</h5>
            <div class="grid grid-cols-1">
              <form class="text-start" @submit.prevent="submit">
                <div class="grid grid-cols-1">
                  <div class="mb-4">
                    <label class="font-medium" for="LoginEmail">Email Address:</label>
                    <input
                      id="LoginEmail"
                      type="email"
                      class="form-input mt-3"
                      v-model="form.email"
                      required
                      placeholder="username"
                    />

                    <label class="font-medium" for="password">Password</label>
                    <input
                      id="password"
                      type="password"
                      class="form-input mt-3"
                      v-model="form.password"
                      required
                      autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />

                    <label class="font-medium" for="password">Confirm Password</label>
                    <input
                      id="password_confirmation"
                      type="password"
                      class="form-input mt-3"
                      v-model="form.password_confirmation"
                      required
                      autocomplete="new-password"
                    />
                    <InputError
                      class="mt-2"
                      :message="form.errors.password_confirmation"
                    />
                  </div>

                  <div class="mb-4">
                    <SuccessButton
                      :class="{ 'opacity-25': form.processing }"
                      :disabled="form.processing"
                    >
                      Reset Password
                    </SuccessButton>
                  </div>

                  <div class="text-center">
                    <span class="text-slate-400 me-2">Remember your password ? </span>
                    <Link
                      :href="route('login')"
                      class="text-black dark:text-white font-medium"
                      >Sign in
                    </Link>
                  </div>
                </div>
              </form>
            </div>
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
import { Link, useForm } from "@inertiajs/vue3";
import SuccessButton from "@/Components/SuccessButton.vue";
import InputError from "@/Components/InputError.vue";
const date = new Date().getFullYear();
const props = defineProps({
  email: {
    type: String,
    // required: true,
  },
  token: {
    type: String,
    // required: true,
  },
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("password.store"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<script>
export default {
  layout: EmptyLayout,
};
</script>
<style lang="scss" scoped></style>
