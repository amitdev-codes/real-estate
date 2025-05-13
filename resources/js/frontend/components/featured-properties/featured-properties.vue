<template>
    <div v-if="featured" class="grid grid-cols-1 pb-8 text-center">
      <h3
        class="mb-4 md:text-3xl md:leading-normal text-2xl leading-normal font-semibold"
      >
        Featured Properties
      </h3>

      <p class="text-slate-400 max-w-xl mx-auto">
        A great plateform to buy, sell and rent your properties without any agent
        or commisions.
      </p>
    </div>
    <!--end grid-->

    <div v-if="featureds" :class="featuredgrid" class="grid gap-6">
      <div
        v-for="item in datas"
        :key="item.id"
        class="group bg-white dark:bg-slate-900 shadow-lg hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500"
      >
        <!-- Image Section -->
        <div class="relative">
          <img
            :src="item.hero_image_path"
            :alt="item.title"
            class="w-full h-64 object-cover"
          />

          <!-- Properties Count Badge -->
          <div class="absolute top-4 left-4 text-white bg-green-600 px-3 py-1 text-base font-medium transition-all duration-500 ease-in-out">
                        {{ item.title }} Properties
                    </div>
          <!-- </div> -->

          <!-- Gradient Overlay -->
          <div
            class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-black/100 to-transparent"
          ></div>

          <!-- Content Section -->
          <div class="absolute bottom-4 left-4 text-white">
            <h3 class="text-white text-lg font-semibold">
              {{ item.project?.name }}
            </h3>
          </div>
        </div>

        <!-- Content Section -->
        <div class="p-4">
          <ul
            class="border-slate-100 dark:border-gray-800 flex items-center list-none"
          >
            <li class="flex items-center me-4">
              <!-- <i class="uil uil-compress-arrows text-2xl me-2 text-green-600"></i> -->
              <i class="uil uil-car text-2xl me-2 text-green-600"></i>
              <span>{{ item.parkings }}</span>
            </li>

            <li class="flex items-center me-4">
              <i class="uil uil-bed-double text-2xl me-2 text-green-600"></i>
              <span>{{ item.bedrooms }}</span>
            </li>

            <li class="flex items-center">
              <i class="uil uil-bath text-2xl me-2 text-green-600"></i>
              <span>{{ item.bathrooms }}</span>
            </li>
          </ul>

          <ul class="pt-1 flex justify-between items-center list-none">
            <li>
              <!-- <span class="text-slate-400">Price</span> -->
              <a href="" class="text-slate-400">{{ item.address.street }}</a>
              <!-- <p class="text-lg font-medium">{{ item.price }}</p> -->
            </li>

            <!-- <li>
                                <span class="text-slate-400">Rating</span>
                                <ul class="text-lg font-medium text-amber-400 list-none">
                                    <li v-for="star in item.star" :key="star" class="inline me-1"><i :class="star"></i></li>
                                    <li class="inline text-black dark:text-white">{{ item.rating }}</li>
                                </ul>
                            </li> -->
          </ul>

          <!-- <p class="text-black text-sm">{{ item.address.street }}</p> -->
        </div>
      </div>
    </div>

    <!--en grid-->

    <div v-else :class="grids">
      <div
        v-for="item in datas"
        :key="item"
        class="group rounded-xl bg-white dark:bg-slate-900 shadow hover:shadow-xl dark:hover:shadow-xl dark:shadow-gray-700 dark:hover:shadow-gray-700 overflow-hidden ease-in-out duration-500"
      >
        <div class="relative">
          <img :src="item.image" alt="" />

          <!-- <div class="absolute top-4 end-4">
                            <a href="javascript:void(0)"
                                class="btn btn-icon bg-white dark:bg-slate-900 shadow dark:shadow-gray-700 rounded-full text-slate-100 dark:text-slate-700 focus:text-red-600 dark:focus:text-red-600 hover:text-red-600 dark:hover:text-red-600"><i
                                    class="mdi mdi-heart text-[20px]"></i>
                            </a>
                        </div> -->
        </div>

        <div class="p-6">
          <div class="pb-6">
            <!-- <Link href="{name: 'property-detail', params: {id: item.id}}" -->
            <Link
              :href="route('frontend.property-detail-two')"
              class="text-lg hover:text-green-600 font-medium ease-in-out duration-500"
              >{{ item.title }}
            </Link>
          </div>

          <ul
            class="py-6 border-y border-slate-100 dark:border-gray-800 flex items-center list-none"
          >
            <li class="flex items-center me-4">
              <i class="uil uil-compress-arrows text-2xl me-2 text-green-600"></i>
              <span>{{ item.sqf }}</span>
            </li>

            <li class="flex items-center me-4">
              <i class="uil uil-bed-double text-2xl me-2 text-green-600"></i>
              <span>{{ item.beds }}</span>
            </li>

            <li class="flex items-center">
              <i class="uil uil-bath text-2xl me-2 text-green-600"></i>
              <span>{{ item.baths }}</span>
            </li>
          </ul>

          <ul class="pt-6 flex justify-between items-center list-none">
            <li>
              <span class="text-slate-400">Price</span>
              <p class="text-lg font-medium">{{ item.price }}</p>
            </li>

            <li>
              <span class="text-slate-400">Rating</span>
              <ul class="text-lg font-medium text-amber-400 list-none">
                <li v-for="star in item.star" :key="star" class="inline me-1">
                  <i :class="star"></i>
                </li>
                <li class="inline text-black dark:text-white">
                  {{ item.rating }}
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <!--end property content-->
    </div>
    <!--en grid-->

  </template>

    <script setup>
  import { ref, onMounted } from "vue";
  import { Link } from "@inertiajs/vue3";

  const props = defineProps({
    // Displays Fearured Property Heading and description
    // Todo: Make the Whole component visible/hidden based on it's value. Currently shows/hides only title and description
    featured: {
      type: Boolean,
      // required: true,
      default: true,
    },
    // Displays Featured Properties in featuredgrid tailwind css format
    // Todo: Optimize the code so that the content displayed is in a grid format or in a list format
    featureds: {
      type: Boolean,
      // required: true,
      default: true,
    },
    show_projects: {
      type: Boolean,
      default: true,
    },
    // If featureds prop is true then this tailwind class is accepted
    // Todo: This prop might be used for displaying properties either in grid format or list format
    featuredgrid: {
      type: String,
      // required: true,
      default: "grid lg:grid-cols-3 md:grid-cols-2 grid-cols-1 mt-8 gap-[30px]",
    },
    // If featureds prop is true then this tailwind class is accepted, which right now is empty, css class not found on other pages
    // Todo: This prop might be used for displaying properties either in grid format or list format
    grids: {
      type: String,
    // required: true,
      default: "",
    },
    featured_properties: {
      type: Object,
      required: true,
    },
  });

  const datas = ref(props.featured_properties);

  onMounted(() => {
    console.log("PROPERTY DATA >>> ", datas.value);
  });

  // const datas = ref([
  //     {
  //         id: 1,
  //         image: getImage('1.jpg'),
  //         name: '10765 Hillshire Ave, Baton Rouge, LA 70810, USA',
  //         sqf: '8000sqf',
  //         beds: '4 Beds',
  //         baths: '4 Baths',
  //         price: '$5000',
  //         rating: '5.0(30)',
  //         star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
  //     },
  //     {
  //         id: 2,
  //         image: getImage('2.jpg'),
  //         name: '59345 STONEWALL DR, Plaquemine, LA 70764, USA',
  //         sqf: '8000sqf',
  //         beds: '4 Beds',
  //         baths: '4 Baths',
  //         price: '$5000',
  //         rating: '5.0(30)',
  //         star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
  //     },
  //     {
  //         id: 3,
  //         image: getImage('3.jpg'),
  //         name: '3723 SANDBAR DR, Addis, LA 70710, USA',
  //         sqf: '8000sqf',
  //         beds: '4 Beds',
  //         baths: '4 Baths',
  //         price: '$5000',
  //         rating: '5.0(30)',
  //         star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
  //     },
  //     {
  //         id: 4,
  //         image: getImage('4.jpg'),
  //         name: 'Lot 21 ROYAL OAK DR, Prairieville, LA 70769, USA',
  //         sqf: '8000sqf',
  //         beds: '4 Beds',
  //         baths: '4 Baths',
  //         price: '$5000',
  //         rating: '5.0(30)',
  //         star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
  //     },
  //     {
  //         id: 5,
  //         image: getImage('5.jpg'),
  //         name: '710 BOYD DR, Unit #1102, Baton Rouge, LA 70808, USA',
  //         sqf: '8000sqf',
  //         beds: '4 Beds',
  //         baths: '4 Baths',
  //         price: '$5000',
  //         rating: '5.0(30)',
  //         star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
  //     },
  //     {
  //         id: 6,
  //         image: getImage('6.jpg'),
  //         name: '5133 MCLAIN WAY, Baton Rouge, LA 70809, USA',
  //         sqf: '8000sqf',
  //         beds: '4 Beds',
  //         baths: '4 Baths',
  //         price: '$5000',
  //         rating: '5.0(30)',
  //         star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
  //     },
  //     {
  //         id: 7,
  //         image: getImage('7.jpg'),
  //         name: '2141 Fiero Street, Baton Rouge, LA 70808',
  //         sqf: '8000sqf',
  //         beds: '4 Beds',
  //         baths: '4 Baths',
  //         price: '$5000',
  //         rating: '5.0(30)',
  //         star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
  //     },
  //     {
  //         id: 8,
  //         image: getImage('8.jpg'),
  //         name: '9714 Inniswold Estates Ave, Baton Rouge, LA 70809',
  //         sqf: '8000sqf',
  //         beds: '4 Beds',
  //         baths: '4 Baths',
  //         price: '$5000',
  //         rating: '5.0(30)',
  //         star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
  //     },
  //     {
  //         id: 9,
  //         image: getImage('9.jpg'),
  //         name: '1433 Beckenham Dr, Baton Rouge, LA 70808, USA',
  //         sqf: '8000sqf',
  //         beds: '4 Beds',
  //         baths: '4 Baths',
  //         price: '$5000',
  //         rating: '5.0(30)',
  //         star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
  //     },
  //     {
  //         id: 10,
  //         image: getImage('10.jpg'),
  //         name: '1574 Sharlo Ave, Baton Rouge, LA 70820, USA',
  //         sqf: '8000sqf',
  //         beds: '4 Beds',
  //         baths: '4 Baths',
  //         price: '$5000',
  //         rating: '5.0(30)',
  //         star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
  //     },
  //     {
  //         id: 11,
  //         image: getImage('11.jpg'),
  //         name: '2528 BOCAGE LAKE DR, Baton Rouge, LA 70809, USA',
  //         sqf: '8000sqf',
  //         beds: '4 Beds',
  //         baths: '4 Baths',
  //         price: '$5000',
  //         rating: '5.0(30)',
  //         star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
  //     },
  //     {
  //         id: 12,
  //         image: getImage('12.jpg'),
  //         name: '1533 NICHOLSON DR, Baton Rouge, LA 70802, USA',
  //         sqf: '8000sqf',
  //         beds: '4 Beds',
  //         baths: '4 Baths',
  //         price: '$5000',
  //         rating: '5.0(30)',
  //         star: ['mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star', 'mdi mdi-star']
  //     },
  // ])

  function getImage(fileName) {
    return new URL(
      `/resources/assets/frontend/images/property/${fileName}`,
      import.meta.url
    ).href;
  }
  </script>

    <style lang="scss" scoped></style>
