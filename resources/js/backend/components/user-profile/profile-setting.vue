<template>
    <!-- Start Content -->
    <div class="grid grid-cols-1">
        <div
            class="profile-banner relative text-transparent rounded-md shadow dark:shadow-gray-700 overflow-hidden"
        >
            <input
                id="pro-banner"
                name="profile-banner"
                type="file"
                class="hidden"
                @change="loadFile"
            />
            <div class="relative shrink-0">
                <img
                    :src="form.banner_image || imageSrc"
                    class="h-80 w-full object-cover"
                    id="profile-banner"
                    alt=""
                />
                <div class="absolute inset-0 bg-black/70"></div>
                <label
                    class="absolute inset-0 cursor-pointer"
                    for="pro-banner"
                ></label>
            </div>
        </div>
    </div>

    <div class="grid md:grid-cols-12 grid-cols-1 gap-6 mt-6">
        <div class="xl:col-span-3 lg:col-span-4 md:col-span-4">
            <div
                class="p-6 relative rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
            >
                <div class="profile-pic text-center">
                    <input
                        id="pro-img"
                        name="profile-image"
                        type="file"
                        class="hidden"
                        @change="loadFile2"
                    />
                    <div>
                        <div class="relative h-24 w-24 mx-auto">
                            <ProfileImage
                                containerClass="relative h-24 w-24 mx-auto"
                                imageClass="rounded-full shadow dark:shadow-gray-700 ring-4 ring-slate-50 dark:ring-slate-800"
                                showLabel
                            />
                        </div>
                        <div class="mt-4">
                            <h5 class="text-lg font-semibold">
                                {{ form.name || user.name }}
                            </h5>
                            <p class="text-slate-400">
                                {{ form.email || user.email }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:col-span-9 lg:col-span-8 md:col-span-8">
            <div class="grid grid-cols-1 gap-6">
                <div
                    class="p-6 relative rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
                >
                    <h5 class="text-lg font-semibold mb-4">
                        Personal Detail :
                    </h5>
                    <form @submit.prevent="updateProfile">
                        <div class="grid lg:grid-cols-2 grid-cols-1 gap-5">
                            <div>
                                <label class="form-label font-medium"
                                    >First Name :
                                    <span class="text-red-600">*</span></label
                                >
                                <div class="form-icon relative mt-2">
                                    <i
                                        data-feather="user"
                                        class="w-4 h-4 absolute top-3 start-4"
                                    ></i>
                                    <input
                                        v-model="form.first_name"
                                        type="text"
                                        class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
                                        placeholder="First Name:"
                                        required
                                    />
                                    <InputError
                                        :message="form.errors.first_name"
                                        class="mt-2"
                                    />
                                </div>
                            </div>
                            <div>
                                <label class="form-label font-medium"
                                    >Last Name :
                                    <span class="text-red-600">*</span></label
                                >
                                <div class="form-icon relative mt-2">
                                    <i
                                        data-feather="user-check"
                                        class="w-4 h-4 absolute top-3 start-4"
                                    ></i>
                                    <input
                                        v-model="form.last_name"
                                        type="text"
                                        class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
                                        placeholder="Last Name:"
                                        required
                                    />
                                    <InputError
                                        :message="form.errors.last_name"
                                        class="mt-2"
                                    />
                                </div>
                            </div>
                            <div>
                                <label class="form-label font-medium"
                                    >Your Email :
                                    <span class="text-red-600">*</span></label
                                >
                                <div class="form-icon relative mt-2">
                                    <i
                                        data-feather="mail"
                                        class="w-4 h-4 absolute top-3 start-4"
                                    ></i>
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
                                        placeholder="Email"
                                        required
                                    />
                                    <InputError
                                        :message="form.errors.email"
                                        class="mt-2"
                                    />
                                </div>
                            </div>
                            <div>
                                <label class="form-label font-medium"
                                    >Occupation :</label
                                >
                                <div class="form-icon relative mt-2">
                                    <i
                                        data-feather="bookmark"
                                        class="w-4 h-4 absolute top-3 start-4"
                                    ></i>
                                    <input
                                        v-model="form.occupation"
                                        type="text"
                                        class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
                                        placeholder="Occupation :"
                                    />
                                    <InputError
                                        :message="form.errors.occupation"
                                        class="mt-2"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1">
                            <div class="mt-5">
                                <label class="form-label font-medium"
                                    >Description :</label
                                >
                                <div class="form-icon relative mt-2">
                                    <i
                                        data-feather="message-circle"
                                        class="w-4 h-4 absolute top-3 start-4"
                                    ></i>
                                    <textarea
                                        v-model="form.description"
                                        class="form-input ps-11 w-full py-2 px-3 h-28 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
                                        placeholder="Message :"
                                    ></textarea>
                                    <InputError
                                        :message="form.errors.description"
                                        class="mt-2"
                                    />
                                </div>
                            </div>
                        </div>

                        <h5 class="text-lg font-semibold mb-4 mt-6">
                            Contact Info :
                        </h5>
                        <div class="grid lg:grid-cols-2 grid-cols-1 gap-5">
                            <div>
                                <label class="form-label font-medium"
                                    >Phone No. :</label
                                >
                                <div class="form-icon relative mt-2">
                                    <i
                                        data-feather="phone"
                                        class="w-4 h-4 absolute top-3 start-4"
                                    ></i>
                                    <input
                                        v-model="form.phone"
                                        type="text"
                                        class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
                                        placeholder="Phone :"
                                    />
                                    <InputError
                                        :message="form.errors.phone"
                                        class="mt-2"
                                    />
                                </div>
                            </div>
                            <div>
                                <label class="form-label font-medium"
                                    >Website :</label
                                >
                                <div class="form-icon relative mt-2">
                                    <i
                                        data-feather="globe"
                                        class="w-4 h-4 absolute top-3 start-4"
                                    ></i>
                                    <input
                                        v-model="form.website"
                                        type="url"
                                        class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
                                        placeholder="Url :"
                                    />
                                    <InputError
                                        :message="form.errors.website"
                                        class="mt-2"
                                    />
                                </div>
                            </div>
                        </div>

                        <h5 class="text-lg font-semibold mb-4 mt-6">
                            Change Password :
                        </h5>
                        <div class="grid grid-cols-1 gap-5">
                            <div>
                                <label class="form-label font-medium"
                                    >Old Password :</label
                                >
                                <div class="form-icon relative mt-2">
                                    <i
                                        data-feather="key"
                                        class="w-4 h-4 absolute top-3 start-4"
                                    ></i>
                                    <input
                                        v-model="form.current_password"
                                        type="password"
                                        class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
                                        placeholder="Old password"
                                    />
                                    <InputError
                                        :message="form.errors.current_password"
                                        class="mt-2"
                                    />
                                </div>
                            </div>
                            <div>
                                <label class="form-label font-medium"
                                    >New Password :</label
                                >
                                <div class="form-icon relative mt-2">
                                    <i
                                        data-feather="key"
                                        class="w-4 h-4 absolute top-3 start-4"
                                    ></i>
                                    <input
                                        v-model="form.password"
                                        type="password"
                                        class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
                                        placeholder="New password"
                                    />
                                    <InputError
                                        :message="form.errors.password"
                                        class="mt-2"
                                    />
                                </div>
                            </div>
                            <div>
                                <label class="form-label font-medium"
                                    >Re-type New Password :</label
                                >
                                <div class="form-icon relative mt-2">
                                    <i
                                        data-feather="key"
                                        class="w-4 h-4 absolute top-3 start-4"
                                    ></i>
                                    <input
                                        v-model="form.password_confirmation"
                                        type="password"
                                        class="form-input ps-12 w-full py-2 px-3 h-10 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-200 focus:border-green-600 dark:border-gray-800 dark:focus:border-green-600 focus:ring-0"
                                        placeholder="Re-type New password"
                                    />
                                    <InputError
                                        :message="
                                            form.errors.password_confirmation
                                        "
                                        class="mt-2"
                                    />
                                </div>
                            </div>
                        </div>

                        <button
                            type="submit"
                            class="btn bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md mt-5"
                            :disabled="form.processing"
                        >
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import InputError from "@/Components/InputError.vue";
import image from "@backend-assets/images/bg.jpg";
import image3 from "@backend-assets/images/client/07.jpg";
import { useForm, usePage } from "@inertiajs/vue3";
import ProfileImage from '@backend-components/ProfileImage.vue';

const { props } = usePage();
const user = props.userdata;
const address = props.address;
const personalInformation = props.personalInformation;

const imageSrc = ref(image);
const imageSrc2 = ref(image3);

console.log(personalInformation);

const form = useForm({
    // Users table
    name: user.name || "",
    email: user.email || "",
    current_password: "",
    password: "",
    password_confirmation: "",
    banner_image: null,
    profile_image: null,

    // PersonalInformation table
    first_name: personalInformation?.first_name || "",
    last_name: personalInformation?.last_name || "",
    occupation: personalInformation?.occupation || "",
    description: personalInformation?.bio || "",

    // Address table
    phone: personalInformation?.business_phone_number || "",
    website: personalInformation?.website || "",
});

function loadFile(event) {
    form.banner_image = event.target.files[0];
    imageSrc.value = URL.createObjectURL(form.banner_image);
}

function loadFile2(event) {
    form.profile_image = event.target.files[0];
    imageSrc2.value = URL.createObjectURL(form.profile_image);
}

const updateProfile = () => {
    form.post(route("profile.update"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset("current_password", "password", "password_confirmation");
        },
        onError: () => {
            // Focus on fields with errors if needed
        },
    });
};
</script>

<style lang="scss" scoped></style>
