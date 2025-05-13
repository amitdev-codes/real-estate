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
          class="max-w-[500px] w-full m-auto p-6 bg-white dark:bg-slate-900 shadow-md dark:shadow-gray-700 rounded-md"
        >
          <Link :href="route('frontend.index-one')">
            <img src="@frontend-assets/images/logo-icon-64.png" class="mx-auto" alt="" />
          </Link>
          <h5 class="my-6 text-xl font-semibold">Signup</h5>
          <Vueform :endpoint="handleSubmit" @success="handleSuccess" @error="handleError">
            <TextElement
              name="name"
              label="Your Name"
              rules="required"
              v-model="form.name"
              size="sm"
              :error="form.errors.name"
            />
            <PhoneElement
              default="+61"
              name="mobile_no"
              label="Mobile Number"
              :allow-incomplete="true"
              :unmask="true"
              :include="['Au', 'us', 'gb', 'de', 'np']"
              rules="required"
              v-model="form.mobile_no"
              size="sm"
              :error="form.errors.mobile_no"
            />
            <SelectElement
              label="Role"
              name="role"
              :native="false"
              :items="formattedRoles"
              v-model="form.role"
              @change="handleRoleChange"
              size="sm"
              :error="form.errors.role"
            />
            <TextElement
              :conditions="[['role', '==', '3']]"
              name="license_number"
              label="License Number"
              rules="required"
              v-model="form.license_number"
              size="sm"
            />
            <TextElement
              :conditions="[['role', '==', '4']]"
              name="agency_id"
              label="Agency ID"
              rules="required|max:255"
              :debounce="300"
              v-model="form.agency_id"
              size="sm"
            />
            <TextElement
              name="email"
              label="Email"
              rules="required|email|max:255"
              :debounce="300"
              v-model="form.email"
              size="sm"
              :error="form.errors.email"
            />
            <TextElement
              label="Password"
              name="password"
              input-type="password"
              :rules="[
                'required',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/',
                'confirmed',
              ]"
              :debounce="300"
              v-model="form.password"
              size="sm"
              :messages="{
                regex:
                  'The Password must at least 8 characters long and contain at least one number, one uppercase and one lowercase character.',
              }"
              :error="form.errors.password"
            />
            <TextElement
              label="Confirm Password"
              name="password_confirmation"
              input-type="password"
              rules="required"
              v-model="form.password_confirmation"
              size="sm"
            />
            <CheckboxElement
              name="terms"
              rules="required"
              v-model="form.terms"
              :messages="{
                required: 'You must accept the terms and conditions to continue',
              }"
              :error="form.errors.terms"
            >
              I accept the <a href="#" class="text-primary">Terms of Service</a> and
              <a href="#" class="text-primary">Privacy Policy</a>
            </CheckboxElement>

            <ButtonElement
              name="register"
              :submits="true"
              button-label="Create account"
              :loading="form.processing"
              :full="true"
              size="lg"
            />
          </Vueform>
          <div class="text-center">
            <span class="text-slate-400 me-2">Already have an account ? </span>
            <Link :href="route('login')" class="text-black dark:text-white font-bold"
              >Sign in</Link
            >
          </div>
        </div>
      </div>
    </div>
  </section>
  <Switcher :back="true" />
</template>

<script setup>
import EmptyLayout from "@/layouts/empty-layout.vue";
import Switcher from "@/frontend/components/switcher.vue";
import { Link, useForm, usePage, router } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
  role: "",
  license_number: "",
  agency_id: "",
  mobile_no: "",
  remember_me: false,
  terms: false,
});

const handleRoleChange = (value) => {
  form.license_number = "";
  form.agency_id = "";
};

const roles = usePage().props.roles;
const formattedRoles = roles.map((role) => ({
  value: role.id.toString(),
  label: role.name,
}));

const handleSubmit = (vueformData, form$) => {
  const requestData = form$.requestData;
  // Submit using Inertia
  router.post(route("register"), requestData, {
    preserveScroll: true,
    onSuccess: () => {
      toast.success("Registration successful!");
      form.reset();
    },
    onError: (errors) => {
      //   toast.error("Registration failed. Please check your inputs.");
      if (form.errors.email) {
        toast.error(form.errors.email);
      }
      if (form.errors.mobile_no) {
        toast.error(form.errors.mobile_no);
      }
    },
  });
};
</script>

<script>
export default {
  layout: EmptyLayout,
};
</script>
