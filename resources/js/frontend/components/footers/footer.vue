<template>
  <footer class="relative bg-slate-900 dark:bg-slate-800 mt-24">
    <!-- <div class="container relative"> -->
    <div class="container relative">
      <div class="grid grid-cols-1">
        <div class="relative py-16">
          <div class="relative w-full">
            <div
              class="relative -top-40 bg-white dark:bg-slate-900 lg:px-8 px-6 py-10 shadow-lg dark:shadow-gray-700 overflow-hidden"
            >
              <!-- coming soon -->
              <section class="bg-gray-100 py-10 mt-10">
                <div
                  class="container mx-auto flex flex-col md:flex-row items-center"
                >
                  <!-- Mobile Mockup Image -->
                  <div class="md:w-1/2 flex justify-center md:justify-start">
                    <img
                      src="@frontend-assets/images/de.png"
                      alt="Mobile App Mockup"
                      class="max-w-xs md:max-w-md"
                    />
                  </div>

                  <!-- Text Content -->
                  <div class="md:w-1/2 text-center md:text-left px-6">
                    <h2
                      class="text-2xl md:text-3xl font-semibold text-gray-800"
                    >
                      Our Mobile App is Coming Soon!
                    </h2>
                    <p class="text-gray-600 mt-3">
                      Buy, sell, and rent properties on the go. Stay tuned for
                      our mobile app launch!
                    </p>

                    <!-- App Store & Play Store Buttons -->
                    <div
                      class="mt-6 flex justify-center md:justify-start gap-4"
                    >
                      <a
                        href="#"
                        class=" text-white px-5 py-3 flex items-center gap-2"
                      >
                        <img
                          src="@frontend-assets/images/app_store.png"
                          alt="App Store"
                          class="h-20"
                        />
                        <!-- <span>Coming Soon</span> -->
                      </a>
                      <a
                        href="#"
                        class=" text-white px-5 py-3 flex items-center gap-2"
                      >
                        <img
                          src="@frontend-assets/images/play_store.png"
                          alt="Play Store"
                          class="h-14"
                        />
                        <!-- <span>Coming Soon</span> -->
                      </a>
                    </div>
                  </div>
                </div>
              </section>

              <!-- end coming soon -->
              <!-- <div
                                class="grid md:grid-cols-2 grid-cols-1 items-center gap-[30px]"
                            >
                                <div class="md:text-start text-center z-1">
                                    <h3
                                        class="md:text-3xl text-2xl md:leading-normal leading-normal font-medium text-black dark:text-white"
                                    >
                                        Subscribe to Newsletter!
                                    </h3>
                                    <p class="text-slate-400 max-w-xl mx-auto">
                                        Subscribe to get latest updates and
                                        information.
                                    </p>
                                </div>

                                <div class="subcribe-form z-1">
                                    <form class="relative max-w-lg md:ms-auto">
                                        <input
                                            type="email"
                                            id="subcribe"
                                            name="email"
                                            class="rounded-full bg-white dark:bg-slate-900 shadow dark:shadow-gray-700"
                                            placeholder="Enter your email :"
                                        />
                                        <button
                                            type="submit"
                                            class="btn bg-yellow-600 hover:bg-yellow-700 text-white rounded-full"
                                        >
                                            Subscribe
                                        </button>
                                    </form>

                                    <button
                                        @click="
                                            openEnquiryModal(
                                                'Enquiry About This Property'
                                            )
                                        "
                                    >
                                        Make Enquiry
                                    </button>
                                    <NotificationModal
                                        ref="enquiryModal"
                                        :notificationGroupId="1"
                                        :notificationSubGroups="
                                            NotificationSubGroups
                                        "
                                    />

                                </div>
                            </div> -->

              <!-- <div class="absolute -top-5 -start-5">
                <div
                  class="uil uil-envelope lg:text-[150px] text-7xl text-black/5 dark:text-white/5 ltr:-rotate-45 rtl:rotate-45"
                ></div>
              </div> -->

              <!-- <div class="absolute -bottom-5 -end-5">
                <div
                  class="uil uil-pen lg:text-[150px] text-7xl text-black/5 dark:text-white/5 rtl:-rotate-90"
                ></div>
              </div> -->
            </div>

            <div class="grid md:grid-cols-12 grid-cols-1 gap-[30px] -mt-24">
              <div class="lg:col-span-4 md:col-span-12">
                <a href="#" class="text-[22px] focus:outline-none">
                  <img
                    src="@frontend-assets/images/logo-light.png"
                    alt="Dreamstate"
                  />
                </a>
                <p class="mt-6 text-gray-300">
                  A great plateform to buy, sell and rent your properties
                  without any agent or commisions.
                </p>
              </div>
              <!--end col-->

              <div class="lg:col-span-2 md:col-span-4">
                <h5 class="tracking-[1px] text-gray-100 font-semibold">
                  Company
                </h5>
                <ul class="list-none footer-list mt-6">
                  <li
                    v-for="item in company"
                    :key="item"
                    class="mt-[10px] first:mt-0"
                  >
                    <Link
                      :href="route(item.link)"
                      class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out"
                    >
                      <i class="uil uil-angle-right-b me-1"></i>
                      {{ item.name }}
                    </Link>
                  </li>
                </ul>
              </div>

              <div class="lg:col-span-3 md:col-span-4">
                <h5 class="tracking-[1px] text-gray-100 font-semibold">
                  Usefull Links
                </h5>
                <ul class="list-none footer-list mt-6">
                  <li
                    v-for="item in usefulls"
                    :key="item"
                    class="mt-[10px] first:mt-0"
                  >
                    <Link
                      :href="route(item.link)"
                      class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out"
                    >
                      <i class="uil uil-angle-right-b me-1"></i>
                      {{ item.name }}
                    </Link>
                  </li>
                </ul>
              </div>

              <div class="lg:col-span-3 md:col-span-4">
                <h5 class="tracking-[1px] text-gray-100 font-semibold">
                  Contact Details
                </h5>

                <div class="flex mt-6">
                  <i
                    data-feather="map-pin"
                    class="size-5 text-yellow-600 me-3"
                  ></i>
                  <div class="">
                    <h6 class="text-gray-300 mb-2">
                      C/54 Northwest Freeway, <br />
                      Suite 558, <br />
                      Houston, USA 485
                    </h6>
                    <a
                      href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d39206.002432144705!2d-95.4973981212445!3d29.709510002925988!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8640c16de81f3ca5%3A0xf43e0b60ae539ac9!2sGerald+D.+Hines+Waterwall+Park!5e0!3m2!1sen!2sin!4v1566305861440!5m2!1sen!2sin"
                      data-type="iframe"
                      class="text-yellow-600 hover:text-yellow-700 duration-500 ease-in-out lightbox"
                      >View on Google map</a
                    >
                  </div>
                </div>

                <div class="flex mt-6">
                  <i
                    data-feather="mail"
                    class="size-5 text-yellow-600 me-3"
                  ></i>
                  <div class="">
                    <a
                      href="mailto:contact@example.com"
                      class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out"
                      >contact@example.com</a
                    >
                  </div>
                </div>

                <div class="flex mt-6">
                  <i
                    data-feather="phone"
                    class="size-5 text-yellow-600 me-3"
                  ></i>
                  <div class="">
                    <a
                      href="tel:+152534-468-854"
                      class="text-slate-300 hover:text-slate-400 duration-500 ease-in-out"
                      >+152 534-468-854</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="py-[30px] px-0 border-t border-gray-800 dark:border-gray-700">
      <div class="container relative text-center">
        <div class="grid md:grid-cols-2 items-center gap-6">
          <div class="md:text-start text-center">
            <p class="mb-0 text-gray-300">
              © {{ date }}
              <a :href="appUrl" target="_blank" class="text-reset"
                >dreamestate.com.au</a
              >
            </p>
          </div>

          <ul class="list-none md:text-end text-center">
            <li v-for="item in social" :key="item" class="inline me-1">
              <a
                :href="item.link"
                target="_blank"
                class="btn btn-icon btn-sm text-gray-400 hover:text-white border border-gray-800 dark:border-gray-700 rounded-md hover:border-yellow-600 dark:hover:border-yellow-600 hover:bg-yellow-600 dark:hover:bg-yellow-600"
              >
                <i :data-feather="item.icon" :class="item.class"></i>
              </a>
            </li>
          </ul>
          <!--end icon-->
        </div>
        <!--end grid-->
      </div>
      <!--end container-->
    </div>
  </footer>
</template>

<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";

const date = ref(new Date().getFullYear());
const appUrl = window.App.url;
import NotificationModal from "@notifications/components/NotificationModal.vue";

const enquiryModal = ref(null);
const notificationGroupTypes = usePage().props.notificationGroupTypes;
const notificationSubGroupTypes = usePage().props.notificationSubGroupTypes;

const openEnquiryModal = (title) => {
  enquiryModal.value.openModal(title);
};

const NotificationSubGroups = notificationSubGroupTypes
  .filter(
    (notificationSubGroupType) =>
      notificationSubGroupType.notification_group_id === 1
  )
  .map((notificationSubGroupType) => ({
    value: notificationSubGroupType.id.toString(),
    label: notificationSubGroupType.name,
  }));
const social = ref([
  {
    class: "size-4",
    icon: "shopping-cart",
    link: "https://1.envato.market/hously-vue",
  },
  {
    class: "size-4",
    icon: "dribbble",
    link: "https://dribbble.com/shreethemes",
  },
  {
    class: "uil uil-behance align-baseline",
    link: "https://www.behance.net/shreethemes",
  },
  {
    class: "size-4",
    icon: "linkedin",
    link: "http://linkedin.com/company/shreethemes",
  },
  {
    class: "size-4",
    icon: "facebook",
    link: "https://www.facebook.com/shreethemes",
  },
  {
    class: "size-4",
    icon: "instagram",
    link: "https://www.instagram.com/shreethemes/",
  },
  {
    class: "size-4",
    icon: "twitter",
    link: "https://twitter.com/shreethemes",
  },
  {
    class: "size-4",
    icon: "mail",
    link: "mailto:support@shreethemes.in",
  },
  {
    class: "size-4",
    icon: "file-text",
    link: "https://forms.gle/QkTueCikDGqJnbky9",
  },
]);

const company = ref([
  {
    link: "frontend.about-us",
    name: "About us",
  },
  {
    link: "frontend.features",
    name: "Services",
  },
  {
    link: "frontend.pricing",
    name: "Pricing",
  },
  {
    link: "frontend.blogs",
    name: "Blog",
  },
  {
    link: "login",
    name: "Login",
  },
]);

const usefulls = ref([
  {
    link: "frontend.terms",
    name: "Terms of Services",
  },
  {
    link: "frontend.privacy",
    name: "Privacy Policy",
  },
  {
    link: "frontend.list",
    name: "Listing",
  },
  {
    link: "frontend.contact",
    name: "Contact",
  },
]);
</script>

<style lang="scss" scoped></style>
