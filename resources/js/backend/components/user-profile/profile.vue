<template>
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
                    :src="imageSrc"
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

    <div class="grid md:grid-cols-12 grid-cols-1">
        <div class="xl:col-span-3 lg:col-span-4 md:col-span-4 mx-6">
            <div
                class="p-6 relative rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900 -mt-48"
            >
                <div class="profile-pic text-center mb-5">
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
                                {{ user.name }}
                            </h5>
                            <p class="text-slate-400">{{ user.email }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 dark:border-gray-700">
                    <h5 class="text-xl font-semibold mt-4">
                        Personal Details :
                    </h5>
                    <div class="mt-4">
                        <div class="flex items-center">
                            <i
                                data-feather="mail"
                                class="fea icon-ex-md text-slate-400 me-3"
                            ></i>
                            <div class="flex-1">
                                <h6
                                    class="text-green-600 dark:text-white font-medium mb-0"
                                >
                                    Email :
                                </h6>
                                <a href="" class="text-slate-400">{{
                                    user.email
                                }}</a>
                            </div>
                        </div>

                        <div class="flex items-center mt-3">
                            <i
                                data-feather="globe"
                                class="fea icon-ex-md text-slate-400 me-3"
                            ></i>
                            <div class="flex-1">
                                <h6
                                    class="text-green-600 dark:text-white font-medium mb-0"
                                >
                                    Website :
                                </h6>
                                <a href="#" class="text-slate-400"
                                    >{{personalInformation.website}}</a
                                >
                            </div>
                        </div>

                        <div class="flex items-center mt-3">
                            <i
                                data-feather="gift"
                                class="fea icon-ex-md text-slate-400 me-3"
                            ></i>
                            <div class="flex-1">
                                <h6
                                    class="text-green-600 dark:text-white font-medium mb-0"
                                >
                                    Birthday :
                                </h6>
                                <p class="text-slate-400 mb-0">
                                    {{props.formattedDateOfBirth}}
                                
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center mt-3">
                            <i
                                data-feather="map-pin"
                                class="fea icon-ex-md text-slate-400 me-3"
                            ></i>
                            <div class="flex-1">
                                <h6
                                    class="text-green-600 dark:text-white font-medium mb-0"
                                >
                                    Location:
                                </h6>

                                <a href="#" class="text-slate-400">
                                    {{
                                        address && address.country
                                            ? address.country
                                            : "Location not available"
                                    }}
                                </a>
                            </div>
                        </div>

                        <div class="flex items-center mt-3">
                            <i
                                data-feather="phone"
                                class="fea icon-ex-md text-slate-400 me-3"
                            ></i>
                            <div class="flex-1">
                                <h6
                                    class="text-green-600 dark:text-white font-medium mb-0"
                                >
                                    Cell No :
                                </h6>
                                <a href="" class="text-slate-400">{{
                                    user.mobile_no
                                }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="xl:col-span-9 lg:col-span-8 md:col-span-8 mt-6">
            <div class="grid grid-cols-1 gap-6">
                <div
                    class="p-6 relative rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
                >
                    <h5 class="text-xl font-semibold">{{ user.name }}</h5>

                    <p class="text-slate-400 mt-3">
                {{personalInformation.bio}}
                    </p>
                </div>

                <div
                    class="p-6 relative rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
                >
                    <h5 class="text-xl font-semibold">My Property :</h5>

                    <Property :properties="props.properties" />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref ,computed} from "vue";
import image from "@backend-assets/images/bg.jpg";
import image3 from "@backend-assets/images/client/07.jpg";
import Property from "@/backend/components/explore-property.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import ProfileImage from '@backend-components/ProfileImage.vue';

const props=defineProps({
  userdata: Object,
  address: Object,
  personalInformation: Object,
  formattedDateOfBirth: Object,
  properties:Array

});


const imageSrc = ref(image);
const imageSrc2 = ref(image3);
const images = ref("");
const image2 = ref("");

console.log(props.bio);

function loadFile(event) {
    images.value = document.getElementById(event.target.name);
    imageSrc.value = URL.createObjectURL(event.target.files[0]);
}

function loadFile2(event) {
    image2.value = document.getElementById(event.target.name);
    imageSrc2.value = URL.createObjectURL(event.target.files[0]);
}
const user = computed(() => props.userdata);
const address = computed(() => props.address);
const personalInformation = computed(() => props.personalInformation);

</script>

<style lang="scss" scoped></style>
