<template>
  <!-- Start Content -->
  <div class="flex justify-between items-center">
    <div>
      <h5 class="text-xl font-semibold">Hello, Calvin</h5>
      <h6 class="text-slate-400">Welcome back!</h6>
    </div>
  </div>

  <div class="grid xl:grid-cols-5 md:grid-cols-3 grid-cols-1 mt-6 gap-6">
    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Total Revenue</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium flex"
              >$
              <count-up class="counter-value ms-1" :end-val="45890"
                >42205</count-up
              ></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-currency-usd text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->

    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Total Visitor</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium"
              ><count-up class="counter-value" :end-val="2456"
                >1857</count-up
              ></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-account-group-outline text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->

    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Total Properties</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium"
              ><count-up class="counter-value" :end-val="358"
                >54</count-up
              ></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-home-city-outline text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->

    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Properties for Sell</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium"
              ><count-up class="counter-value" :end-val="243"
                >60</count-up
              ></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-home-lightning-bolt-outline text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->

    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Properties for Rent</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium"
              ><count-up class="counter-value" :end-val="115"
                >45</count-up
              ></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-home-clock-outline text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->
  </div>

  <div class="grid lg:grid-cols-12 grid-cols-1 mt-6 gap-6">
    <div class="lg:col-span-8">
      <div
        class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
      >
        <div
          class="p-6 flex items-center justify-between border-b border-gray-100 dark:border-gray-800"
        >
          <h6 class="text-lg font-semibold">Revenue Analytics</h6>

          <div class="position-relative">
            <select
              class="form-select form-input w-full py-2 h-10 bg-white dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 focus:border-gray-200 dark:border-gray-800 dark:focus:border-gray-700 focus:ring-0"
              id="yearchart"
            >
              <option value="Y" selected>Yearly</option>
              <option value="M">Monthly</option>
              <option value="W">Weekly</option>
              <option value="T">Today</option>
            </select>
          </div>
        </div>
        <RevenueChart />
      </div>
    </div>

    <div class="lg:col-span-4">
      <div
        class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
      >
        <div
          class="p-6 flex items-center justify-between border-b border-gray-100 dark:border-gray-800"
        >
          <h6 class="text-lg font-semibold">Sales Data</h6>

          <div class="position-relative">
            <select
              class="form-select form-input w-full py-2 h-10 bg-white dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 focus:border-gray-200 dark:border-gray-800 dark:focus:border-gray-700 focus:ring-0"
              id="yearchart"
            >
              <option value="Y" selected>Yearly</option>
              <option value="M">Monthly</option>
              <option value="W">Weekly</option>
              <option value="T">Today</option>
            </select>
          </div>
        </div>

        <div class="p-6">
          <div v-for="item in sales" :key="item" class="mt-5 first:mt-0">
            <div class="flex justify-between mb-2">
              <span class="text-slate-400">{{ item.name }}</span>
              <span class="text-slate-400">{{ item.percentage }}</span>
            </div>
            <div
              class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-[6px]"
            >
              <div
                class="bg-green-600 h-[6px] rounded-full"
                :style="item.width"
              ></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="grid lg:grid-cols-12 grid-cols-1 mt-6 gap-6">
    <AreaMap />
    <div class="xl:col-span-6 lg:col-span-12 xl:order-2 order-3">
      <div
        class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
      >
        <div
          class="p-6 flex items-center justify-between border-b border-gray-100 dark:border-gray-800"
        >
          <h6 class="text-lg font-semibold">Recent Transections</h6>

          <a
            href=""
            class="btn btn-link font-normal text-slate-400 hover:text-green-600 after:bg-green-600 transition duration-500"
            >View orders <i class="mdi mdi-arrow-right ms-1"></i
          ></a>
        </div>

        <div
          class="relative overflow-x-auto block w-full xl:max-h-[284px] max-h-[350px]"
          data-simplebar
        >
          <table class="w-full text-start">
            <thead class="text-base">
              <tr>
                <th class="text-start font-semibold text-[15px] px-4 py-3"></th>
                <th
                  class="text-start font-semibold text-[15px] px-4 py-3 min-w-[140px]"
                >
                  Date
                </th>
                <th
                  class="text-start font-semibold text-[15px] px-4 py-3 min-w-[120px]"
                >
                  Name
                </th>
                <th class="text-start font-semibold text-[15px] px-4 py-3">
                  Price
                </th>
                <th
                  class="text-start font-semibold text-[15px] px-4 py-3 min-w-[40px]"
                >
                  Type
                </th>
                <th
                  class="text-end font-semibold text-[15px] px-4 py-3 min-w-[70px]"
                >
                  Status
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in transection" :key="item">
                <th
                  class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3 font-semibold"
                >
                  <div class="relative md:shrink-0">
                    <img
                      :src="item.image"
                      class="object-cover w-12 h-12 min-w-[48px] rounded-md shadow dark:shadow-gray-700"
                      alt=""
                    />
                  </div>
                </th>
                <td
                  class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3"
                >
                  <span class="text-slate-400">{{ item.date }}</span>
                </td>
                <th
                  class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3 font-semibold"
                >
                  {{ item.name }}
                </th>
                <td
                  class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3"
                >
                  <span class="text-slate-400">{{ item.price }}</span>
                </td>
                <th
                  class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3 font-semibold"
                >
                  {{ item.type }}
                </th>
                <td
                  class="text-end border-t border-gray-100 dark:border-gray-800 px-4 py-3"
                >
                  <span
                    v-if="item.status === 'Paid'"
                    class="bg-emerald-600/10 dark:bg-emerald-600/20 border border-emerald-600/10 dark:border-emerald-600/20 text-emerald-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1"
                    >Paid</span
                  >
                  <span
                    v-if="item.status === 'Unpaid'"
                    class="bg-red-600/10 dark:bg-red-600/20 border border-red-600/10 dark:border-red-600/20 text-red-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1"
                    >Unpaid</span
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="xl:col-span-3 lg:col-span-6 xl:order-3 order-2">
      <div
        class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
      >
        <div
          class="p-6 flex items-center justify-between border-b border-gray-100 dark:border-gray-800"
        >
          <h6 class="text-lg font-semibold">Top Properties</h6>

          <a
            href=""
            class="btn btn-link font-normal text-slate-400 hover:text-green-600 after:bg-green-600 transition duration-500"
            >See More <i class="mdi mdi-arrow-right ms-1"></i
          ></a>
        </div>

        <div
          class="relative overflow-x-auto block w-full max-h-[284px] p-6"
          data-simplebar
        >
          <div
            v-for="item in properties"
            :key="item"
            class="flex justify-between items-center mt-4 first:mt-0"
          >
            <div class="flex items-center">
              <div class="relative md:shrink-0">
                <img
                  :src="item.image"
                  class="object-cover w-14 h-14 min-w-[56px] rounded-md shadow dark:shadow-gray-700"
                  alt=""
                />
              </div>

              <div class="ms-2">
                <a
                  href=""
                  class="font-medium hover:text-green-600 block text-lg"
                  >{{ item.name }}</a
                >
                <span class="text-slate-400">{{ item.location }}</span>
              </div>
            </div>

            <span v-if="item.show === false" class="w-20 text-red-600 text-end"
              ><i class="mdi mdi-arrow-bottom-right"></i>
              {{ item.percentage }}</span
            >
            <span
              v-if="item.show === true"
              class="w-20 text-emerald-600 text-end"
              ><i class="mdi mdi-arrow-top-right"></i>
              {{ item.percentage }}</span
            >
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Content -->

  <div class="grid xl:grid-cols-5 md:grid-cols-3 grid-cols-1 mt-6 gap-6">
    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Total Revenue</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium flex"
              >$
              <count-up class="counter-value ms-1" :end-val="45890"
                >42205</count-up
              ></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-currency-usd text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->

    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Total Visitor</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium"
              ><count-up class="counter-value" :end-val="2456"
                >1857</count-up
              ></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-account-group-outline text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->

    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Total Properties</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium"
              ><count-up class="counter-value" :end-val="358"
                >54</count-up
              ></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-home-city-outline text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->

    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Properties for Sell</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium"
              ><count-up class="counter-value" :end-val="243"
                >60</count-up
              ></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-home-lightning-bolt-outline text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->

    <div
      class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
    >
      <div class="p-5 flex items-center justify-between">
        <span class="me-3">
          <span class="text-slate-400 block">Properties for Rent</span>
          <span class="flex items-center justify-between mt-1">
            <span class="text-2xl font-medium"
              ><count-up class="counter-value" :end-val="115"
                >45</count-up
              ></span
            >
          </span>
        </span>

        <span
          class="flex justify-center items-center rounded-md h-12 w-12 min-w-[48px] bg-slate-50 dark:bg-slate-800 shadow shadow-gray-100 dark:shadow-gray-700 text-green-600"
        >
          <i class="mdi mdi-home-clock-outline text-[28px]"></i>
        </span>
      </div>
    </div>
    <!--end-->
  </div>

  <div class="grid lg:grid-cols-12 grid-cols-1 mt-6 gap-6">
    <div class="lg:col-span-8">
      <div
        class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
      >
        <div
          class="p-6 flex items-center justify-between border-b border-gray-100 dark:border-gray-800"
        >
          <h6 class="text-lg font-semibold">Revenue Analytics</h6>

          <div class="position-relative">
            <select
              class="form-select form-input w-full py-2 h-10 bg-white dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 focus:border-gray-200 dark:border-gray-800 dark:focus:border-gray-700 focus:ring-0"
              id="yearchart"
            >
              <option value="Y" selected>Yearly</option>
              <option value="M">Monthly</option>
              <option value="W">Weekly</option>
              <option value="T">Today</option>
            </select>
          </div>
        </div>
        <revenuechart />
      </div>
    </div>

    <div class="lg:col-span-4">
      <div
        class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
      >
        <div
          class="p-6 flex items-center justify-between border-b border-gray-100 dark:border-gray-800"
        >
          <h6 class="text-lg font-semibold">Sales Data</h6>

          <div class="position-relative">
            <select
              class="form-select form-input w-full py-2 h-10 bg-white dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 focus:border-gray-200 dark:border-gray-800 dark:focus:border-gray-700 focus:ring-0"
              id="yearchart"
            >
              <option value="Y" selected>Yearly</option>
              <option value="M">Monthly</option>
              <option value="W">Weekly</option>
              <option value="T">Today</option>
            </select>
          </div>
        </div>

        <div class="p-6">
          <div v-for="item in sales" :key="item" class="mt-5 first:mt-0">
            <div class="flex justify-between mb-2">
              <span class="text-slate-400">{{ item.name }}</span>
              <span class="text-slate-400">{{ item.percentage }}</span>
            </div>
            <div
              class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-[6px]"
            >
              <div
                class="bg-green-600 h-[6px] rounded-full"
                :style="item.width"
              ></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="grid lg:grid-cols-12 grid-cols-1 mt-6 gap-6">
    <areamap />
    <div class="xl:col-span-6 lg:col-span-12 xl:order-2 order-3">
      <div
        class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
      >
        <div
          class="p-6 flex items-center justify-between border-b border-gray-100 dark:border-gray-800"
        >
          <h6 class="text-lg font-semibold">Recent Transections</h6>

          <a
            href=""
            class="btn btn-link font-normal text-slate-400 hover:text-green-600 after:bg-green-600 transition duration-500"
            >View orders <i class="mdi mdi-arrow-right ms-1"></i
          ></a>
        </div>

        <div
          class="relative overflow-x-auto block w-full xl:max-h-[284px] max-h-[350px]"
          data-simplebar
        >
          <table class="w-full text-start">
            <thead class="text-base">
              <tr>
                <th class="text-start font-semibold text-[15px] px-4 py-3"></th>
                <th
                  class="text-start font-semibold text-[15px] px-4 py-3 min-w-[140px]"
                >
                  Date
                </th>
                <th
                  class="text-start font-semibold text-[15px] px-4 py-3 min-w-[120px]"
                >
                  Name
                </th>
                <th class="text-start font-semibold text-[15px] px-4 py-3">
                  Price
                </th>
                <th
                  class="text-start font-semibold text-[15px] px-4 py-3 min-w-[40px]"
                >
                  Type
                </th>
                <th
                  class="text-end font-semibold text-[15px] px-4 py-3 min-w-[70px]"
                >
                  Status
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="item in transection" :key="item">
                <th
                  class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3 font-semibold"
                >
                  <div class="relative md:shrink-0">
                    <img
                      :src="item.image"
                      class="object-cover w-12 h-12 min-w-[48px] rounded-md shadow dark:shadow-gray-700"
                      alt=""
                    />
                  </div>
                </th>
                <td
                  class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3"
                >
                  <span class="text-slate-400">{{ item.date }}</span>
                </td>
                <th
                  class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3 font-semibold"
                >
                  {{ item.name }}
                </th>
                <td
                  class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3"
                >
                  <span class="text-slate-400">{{ item.price }}</span>
                </td>
                <th
                  class="text-start border-t border-gray-100 dark:border-gray-800 px-4 py-3 font-semibold"
                >
                  {{ item.type }}
                </th>
                <td
                  class="text-end border-t border-gray-100 dark:border-gray-800 px-4 py-3"
                >
                  <span
                    v-if="item.status === 'Paid'"
                    class="bg-emerald-600/10 dark:bg-emerald-600/20 border border-emerald-600/10 dark:border-emerald-600/20 text-emerald-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1"
                    >Paid</span
                  >
                  <span
                    v-if="item.status === 'Unpaid'"
                    class="bg-red-600/10 dark:bg-red-600/20 border border-red-600/10 dark:border-red-600/20 text-red-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1"
                    >Unpaid</span
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="xl:col-span-3 lg:col-span-6 xl:order-3 order-2">
      <div
        class="relative overflow-hidden rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900"
      >
        <div
          class="p-6 flex items-center justify-between border-b border-gray-100 dark:border-gray-800"
        >
          <h6 class="text-lg font-semibold">Top Properties</h6>

          <a
            href=""
            class="btn btn-link font-normal text-slate-400 hover:text-green-600 after:bg-green-600 transition duration-500"
            >See More <i class="mdi mdi-arrow-right ms-1"></i
          ></a>
        </div>

        <div
          class="relative overflow-x-auto block w-full max-h-[284px] p-6"
          data-simplebar
        >
          <div
            v-for="item in properties"
            :key="item"
            class="flex justify-between items-center mt-4 first:mt-0"
          >
            <div class="flex items-center">
              <div class="relative md:shrink-0">
                <img
                  :src="item.image"
                  class="object-cover w-14 h-14 min-w-[56px] rounded-md shadow dark:shadow-gray-700"
                  alt=""
                />
              </div>

              <div class="ms-2">
                <a
                  href=""
                  class="font-medium hover:text-green-600 block text-lg"
                  >{{ item.name }}</a
                >
                <span class="text-slate-400">{{ item.location }}</span>
              </div>
            </div>

            <span v-if="item.show === false" class="w-20 text-red-600 text-end"
              ><i class="mdi mdi-arrow-bottom-right"></i>
              {{ item.percentage }}</span
            >
            <span
              v-if="item.show === true"
              class="w-20 text-emerald-600 text-end"
              ><i class="mdi mdi-arrow-top-right"></i>
              {{ item.percentage }}</span
            >
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import CountUp from "vue-countup-v3";
import RevenueChart from "@/backend/components/apexchart/revenue-chart.vue";
import AreaMap from "@/backend/components/apexchart/area-map.vue";

const sales = [
  {
    name: "Via Website",
    percentage: "50%",
    width: "width: 50%",
  },
  {
    name: "Via Team Member",
    percentage: "12%",
    width: "width: 12%",
  },
  {
    name: "Via Agents",
    percentage: "6%",
    width: "width: 6%",
  },
  {
    name: "Via Social Media",
    percentage: "15%",
    width: "width: 15%",
  },
  {
    name: "Via Digital Marketing",
    percentage: "12%",
    width: "width: 12%",
  },
  {
    name: "Via Others",
    percentage: "5%",
    width: "width: 5%",
  },
];

// adding import instead of image: require('xxx') because its not working with vite alias @backend-assets
import image1 from "@backend-assets/images/property/1.jpg";
import image2 from "@backend-assets/images/property/2.jpg";
import image3 from "@backend-assets/images/property/3.jpg";
import image4 from "@backend-assets/images/property/4.jpg";
import image5 from "@backend-assets/images/property/5.jpg";

const transection = [
  {
    // image: require('@backend-assets/images/property/1.jpg'),
    image: image1,
    date: "10th Aug 2023",
    name: " Mr. Rocky",
    price: "$1245/M",
    type: "Rent",
    status: "Paid",
  },
  {
    // image: require('@backend-assets/images/property/2.jpg'),
    image: image2,
    date: "10th Aug 2023",
    name: "Mr. Cristino",
    price: "$12450",
    type: "Sell",
    status: "Unpaid",
  },
  {
    // image: require('@backend-assets/images/property/3.jpg'),
    image: image3,
    date: "10th Aug 2023",
    name: "Mr. Jack",
    price: "$12450",
    type: "Sell",
    status: "Paid",
  },
  {
    // image: require('@backend-assets/images/property/4.jpg'),
    image: image4,
    date: "10th Aug 2023",
    name: " Ms. Cally",
    price: "$12450",
    type: "Sell",
    status: "Unpaid",
  },
  {
    // image: require('@backend-assets/images/property/5.jpg'),
    image: image5,
    date: "10th Aug 2023",
    name: " Ms. Cristina",
    price: "$1245/M",
    type: "Rent",
    status: "Unpaid",
  },
];

const properties = [
  {
    // image: require('@backend-assets/images/property/1.jpg'),
    image: image1,
    name: "House",
    location: "Baton Rouge, USA",
    percentage: "11%",
    show: false,
  },
  {
    // image: require('@backend-assets/images/property/2.jpg'),
    image: image2,
    name: "House",
    location: "Baton Rouge, USA",
    percentage: "20%",
    show: true,
  },
  {
    // image: require('@backend-assets/images/property/3.jpg'),
    image: image3,
    name: "House",
    location: "Baton Rouge, USA",
    percentage: "24%",
    show: true,
  },
  {
    // image: require('@backend-assets/images/property/4.jpg'),
    image: image4,
    name: "House",
    location: "Baton Rouge, USA",
    percentage: "21%",
    show: true,
  },
  {
    // image: require('@backend-assets/images/property/5.jpg'),
    image: image5,
    name: "House",
    location: "Baton Rouge, USA",
    percentage: "45%",
    show: true,
  },
];
</script>

<style lang="scss" scoped></style>
