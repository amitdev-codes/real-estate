<template>
    <!-- Start Content -->
    <div class="md:flex justify-between items-center">
        <h5 class="text-lg font-semibold">Chatbox</h5>

        <ul class="tracking-[0.5px] inline-block sm:mt-0 mt-3">
            <li
                class="inline-block capitalize text-[16px] font-medium duration-500 dark:text-white/70 hover:text-green-600 dark:hover:text-white">
                <Link :href="route('admin.dashboard')">Hously</Link>
            </li>
            <li
                class="inline-block text-base text-slate-950 dark:text-white/70 mx-0.5 ltr:rotate-0 rtl:rotate-180">
                <i class="mdi mdi-chevron-right"></i>
            </li>
            <li class="inline-block capitalize text-[16px] font-medium text-green-600 dark:text-white"
                aria-current="page">Chat</li>
        </ul>
    </div>

    <div class="grid md:grid-cols-12 grid-cols-1 mt-6 gap-2">
        <div class="xl:col-span-3 lg:col-span-5 md:col-span-5">
            <div class="rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900">
                <div class="text-center p-6 border-b border-gray-100 dark:border-gray-800">
                    <img src="@backend-assets/images/client/07.jpg"
                        class="h-20 w-20 rounded-full shadow dark:shadow-gray-700 mx-auto" alt="">
                    <h5 class="mt-3 font-medium text-xl mb-0">Calvin Carlo</h5>
                    <p class="text-slate-400 mb-0">Property Dealer</p>
                </div>

                <div class="p-2 max-h-[482px]" data-simplebar>
                    <a v-for="item in chat" :key="item" href="#" :class="item.class">
                        <div class="relative">
                            <img :src="item.image" class="h-11 w-11 rounded-full shadow dark:shadow-gray-700"
                                alt="">
                            <span v-if="item.class3 === 'bg-green-600'"
                                class="absolute top-0.5 start-0.5 flex items-center justify-center bg-green-600 text-white text-[10px] font-bold rounded-full w-2 h-2 after:content-[''] after:absolute after:h-2 after:w-2 after:bg-green-600 after:top-0 after:end-0 after:rounded-full after:animate-ping"></span>
                            <span v-if="item.class3 === 'bg-red-600'"
                                class="absolute top-0.5 start-0.5 flex items-center justify-center bg-red-600 text-white text-[10px] font-bold rounded-full w-2 h-2"></span>
                        </div>
                        <div class="overflow-hidden flex-1 ms-2">
                            <div class="flex justify-between">
                                <h6 class="font-semibold">{{ item.name }}</h6>
                                <small class="text-slate-400">{{ item.time }}</small>
                            </div>
                            <div class="flex justify-between">
                                <div :class="item.class2">{{ item.message }}</div>
                                <span v-if="item.message2 === '2'"
                                    class="flex items-center justify-center bg-red-600/20 text-red-600 text-[10px] font-bold rounded-full w-5 max-h-5">{{
                        item.message2 }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="xl:col-span-9 lg:col-span-7 md:col-span-7">
            <div class="rounded-md shadow dark:shadow-gray-700 bg-white dark:bg-slate-900">
                <div
                    class="flex justify-between items-center border-b border-gray-100 dark:border-gray-800 p-4">
                    <div class="flex">
                        <img src="@backend-assets/images/client/01.jpg"
                            class="h-11 w-11 rounded-full shadow dark:shadow-gray-700" alt="">
                        <div class="overflow-hidden ms-3">
                            <a href="#" class="block font-semibold text-truncate">Cristino Murfy</a>
                            <span class="text-slate-400 flex items-center text-sm"><span
                                    class="bg-green-600 text-white text-[10px] font-bold rounded-full w-2 h-2 me-1"></span>
                                Online</span>
                        </div>
                    </div>

                    <div class="dropdown relative">
                        <button ref="dropdownToggle" @click="dropdownOpen = !dropdownOpen" class="dropdown-toggle items-center"
                            type="button">
                            <span
                                class="h-8 w-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-green-600/5 hover:bg-green-600 border-green-600/10 hover:border-green-600 text-green-600 hover:text-white rounded-md"><i
                                    class="mdi mdi-dots-vertical"></i></span>
                        </button>
                        <!-- Dropdown menu -->
                        <div class="dropdown-menu absolute end-0 m-0 mt-4 z-10 w-44 rounded-md overflow-hidden bg-white dark:bg-slate-900 shadow dark:shadow-gray-700"
                        v-show="dropdownOpen">
                            <ul class="py-2 text-start">
                                <li>
                                    <a href="" class="block py-1.5 px-4 hover:text-green-600"><i
                                            class="mdi mdi-account-outline"></i> Profile</a>
                                </li>
                                <li>
                                    <a href="" class="block py-1.5 px-4 hover:text-green-600"><i
                                            class="mdi mdi-cog-outline"></i> Profile Settings</a>
                                </li>
                                <li>
                                    <a href="" class="block py-1.5 px-4 hover:text-green-600"><i
                                            class="mdi mdi-trash-can-outline"></i> Delete</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <ul class="p-4 list-none mb-0 max-h-[548px]" data-simplebar>
                    <li v-for="item in message" :key="item" :class="item.class">
                        <div class="inline-block">
                            <div class="flex mb-3">
                                <div class="relative" :class="item.order">
                                    <img :src="item.image"
                                        class="h-9 w-9 min-w-[36px] rounded-full shadow dark:shadow-gray-700"
                                        alt="">
                                    <span :class="item.class3"
                                        class="absolute top-0.5  flex items-center justify-center bg-green-600 text-white text-[10px] font-bold rounded-full w-2 h-2 after:content-[''] after:absolute after:h-2 after:w-2 after:bg-green-600 after:top-0 after:end-0 after:rounded-full after:animate-ping"></span>
                                </div>
                                <div class="me-2 max-w-lg">
                                    <p
                                        class="bg-white dark:bg-slate-900 text-slate-400 text-[16px] shadow dark:shadow-gray-700 px-3 py-2 rounded mb-1">
                                        {{item.mess}} <a
                                            :href="item.link" target="_blank"
                                            class="text-green-600">{{ item.linkname }}</a></p>
                                    <span class="text-slate-400 text-sm"><i
                                            class="mdi mdi-clock-outline me-1"></i>{{item.time}}</span>
                                </div>
                            </div>
                        </div>
                    </li>

                    <li>
                        <div class="inline-block">
                            <div class="flex items-center mb-3">
                                <div class="relative">
                                    <img src="@backend-assets/images/client/01.jpg"
                                        class="h-9 w-9 min-w-[36px] rounded-full shadow dark:shadow-gray-700"
                                        alt="">
                                    <span
                                        class="absolute top-0.5 start-0.5 flex items-center justify-center bg-green-600 text-white text-[10px] font-bold rounded-full w-2 h-2 after:content-[''] after:absolute after:h-2 after:w-2 after:bg-green-600 after:top-0 after:end-0 after:rounded-full after:animate-ping"></span>
                                </div>

                                <div class="ms-2 max-w-lg">
                                    <p class="text-slate-400 text-sm rounded mb-1">Cristino is typing
                                        <span class="animate-typing ms-1">
                                            <span
                                                class="dot inline-block w-1 h-1 bg-slate-400 -mr-px opacity-60 rounded-full me-1"></span>
                                            <span
                                                class="dot inline-block w-1 h-1 bg-slate-400 -mr-px opacity-60 rounded-full me-1"></span>
                                            <span
                                                class="dot inline-block w-1 h-1 bg-slate-400 -mr-px opacity-60 rounded-full"></span>
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </li> 
                </ul>

                <div class="p-2 border-t border-gray-100 dark:border-gray-800">
                    <div class="flex ">
                        <input type="text"
                            class="form-input w-full py-2 px-3 h-9 bg-transparent dark:bg-slate-900 dark:text-slate-200 rounded outline-none border border-gray-100 dark:border-gray-800 focus:ring-0"
                            placeholder="Enter Message...">

                        <div class="min-w-[125px] text-end">
                            <a href="#"
                                class="h-9 w-9 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[16px] text-center bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md me-1"><i
                                    class="mdi mdi-send"></i></a>
                            <a href="#"
                                class="h-9 w-9 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[16px] text-center bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md me-1"><i
                                    class="mdi mdi-emoticon-happy-outline"></i></a>
                            <a href="#"
                                class="h-9 w-9 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[16px] text-center bg-green-600 hover:bg-green-700 border-green-600 hover:border-green-700 text-white rounded-md"><i
                                    class="mdi mdi-paperclip"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Content -->    
</template>

<script>
import vClickOutside from 'v-click-outside';

export default {
    directives: {
        clickOutside: vClickOutside.directive,
    },
    data() {
        return {
            dropdownOpen: false,
            chat: [
                {
                    image: this.getImage('09.jpg'),
                    name: 'Christopher',
                    class: 'flex items-center p-2 rounded-md relative bg-gray-50 dark:bg-slate-800',
                    time: '10 Min',
                    message: 'Hello',
                    message2: '',
                    class2: 'text-slate-400 truncate',
                    class3: 'bg-green-600'
                },
                {
                    image: this.getImage('01.jpg'),
                    name: 'Dr. Cristino',
                    class: 'flex items-center p-2 rounded-md relative hover:bg-gray-50 dark:hover:bg-slate-800 mt-1.5',
                    time: '20 Min',
                    message: 'Hi, How are you?',
                    message2: '2',
                    class2: 'text-slate-900 dark:text-white font-medium truncate',
                    class3: 'bg-red-600'
                },
                {
                    image: this.getImage('03.jpg'),
                    name: 'Faye',
                    class: 'flex items-center p-2 rounded-md relative hover:bg-gray-50 dark:hover:bg-slate-800 mt-1.5',
                    time: '30 Min',
                    message: 'Heyy',
                    message2: '',
                    class2: 'text-slate-400 truncate',
                    class3: 'bg-red-600'
                },
                {
                    image: this.getImage('04.jpg'),
                    name: 'Ronald',
                    class: 'flex items-center p-2 rounded-md relative hover:bg-gray-50 dark:hover:bg-slate-800 mt-1.5',
                    time: '2 Hours',
                    message: 'Hey, How are you sir?',
                    message2: '',
                    class2: 'text-slate-400 truncate',
                    class3: 'bg-red-600'
                },
                {
                    image: this.getImage('11.jpg'),
                    name: 'Melissa',
                    class: 'flex items-center p-2 rounded-md relative hover:bg-gray-50 dark:hover:bg-slate-800 mt-1.5',
                    time: '3 Hours',
                    message: 'Good Afternoon',
                    message2: '',
                    class2: 'text-slate-400 truncate',
                    class3: 'bg-green-600'
                },
                {
                    image: this.getImage('12.jpg'),
                    name: 'Elsie',
                    class: 'flex items-center p-2 rounded-md relative hover:bg-gray-50 dark:hover:bg-slate-800 mt-1.5',
                    time: '10 Hours',
                    message: 'Good Morning sir, how can i help you?',
                    message2: '',
                    class2: 'text-slate-400 truncate',
                    class3: 'bg-green-600'
                },
                {
                    image: this.getImage('07.jpg'),
                    name: 'Jerry',
                    class: 'flex items-center p-2 rounded-md relative hover:bg-gray-50 dark:hover:bg-slate-800 mt-1.5',
                    time: '16 Hours',
                    message: 'Please give me appointment',
                    message2: '',
                    class2: 'text-slate-400 truncate',
                    class3: 'bg-green-600'
                },
                {
                    image: this.getImage('13.jpg'),
                    name: 'Louis',
                    class: 'flex items-center p-2 rounded-md relative hover:bg-gray-50 dark:hover:bg-slate-800 mt-1.5',
                    time: '1 Days',
                    message: 'Hii',
                    message2: '',
                    class2: 'text-slate-400 truncate',
                    class3: 'bg-red-600'
                },
                {
                    image: this.getImage('06.jpg'),
                    name: 'Randall',
                    class: 'flex items-center p-2 rounded-md relative hover:bg-gray-50 dark:hover:bg-slate-800 mt-1.5',
                    time: '2 Days',
                    message: 'Hello Sir',
                    message2: '',
                    class2: 'text-slate-400 truncate',
                    class3: 'bg-red-600'
                },
                {
                    image: this.getImage('10.jpg'),
                    name: 'Mary',
                    class: 'flex items-center p-2 rounded-md relative hover:bg-gray-50 dark:hover:bg-slate-800 mt-1.5',
                    time: '3 Days',
                    message: 'How are you sir?',
                    message2: '',
                    class2: 'text-slate-400 truncate',
                    class3: 'bg-red-600'
                },
                {
                    image: this.getImage('08.jpg'),
                    name: 'Lester',
                    class: 'flex items-center p-2 rounded-md relative hover:bg-gray-50 dark:hover:bg-slate-800 mt-1.5',
                    time: '4 Days',
                    message: 'Hello please give me answer.',
                    message2: '',
                    class2: 'text-slate-400 truncate',
                    class3: 'bg-green-600'
                },
            ],
            message : [
                {
                    image: this.getImage('01.jpg'),
                    mess: 'Hey Calvin',
                    time : '59 min ago',
                    class3: 'start-0.5',
                    order: 'me-2'
                },
                {
                    image: this.getImage('07.jpg'),
                    mess: 'Hello Cristino',
                    class: 'text-end',
                    order : 'order-2',
                    time : '45 min ago',
                    class3: 'end-0.5'
                },
                {
                    image: this.getImage('07.jpg'),
                    mess: 'How can i help you?',
                    class: 'text-end',
                    order : 'order-2',
                    time : '44 min ago',
                    class3: 'end-0.5'
                },
                {
                    image: this.getImage('01.jpg'),
                    mess: 'Nice to meet you',
                    time : '42 min ago',
                    class3: 'start-0.5',
                    order: 'me-2'
                },
                {
                    image: this.getImage('01.jpg'),
                    mess: 'Hope you are doing fine?',
                    time : '40 min ago',
                    class3: 'start-0.5',
                    order: 'me-2'
                },
                {
                    image: this.getImage('07.jpg'),
                    mess: "I'm good thanks for asking",
                    class: 'text-end',
                    order : 'order-2',
                    time : '38 min ago',
                    class3: 'end-0.5'
                },
                {
                    image: this.getImage('01.jpg'),
                    mess: 'I am intrested to know more about your prices and services you offer',
                    time : '35 min ago',
                    class3: 'start-0.5',
                    order: 'me-2'
                },
                {
                    image: this.getImage('07.jpg'),
                    mess: "Sure please check below link to find more useful information",
                    class: 'text-end',
                    order : 'order-2',
                    time : '29 min ago',
                    link: 'https://shreethemes.in/hously_vue',
                    linkname: 'https://shreethemes.in/hously_vue',
                    class3: 'end-0.5'
                },
                {
                    image: this.getImage('01.jpg'),
                    mess: 'Thank you 😊',
                    time : '26 min ago',
                    class3: 'start-0.5',
                    order: 'me-2'
                },
                {
                    image: this.getImage('07.jpg'),
                    mess: "Welcome",
                    class: 'text-end',
                    order : 'order-2',
                    time : '15 min ago',
                    class3: 'end-0.5'
                },
                
            ]
        }
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside);
    },
    unmounted() {
        document.removeEventListener('click', this.handleClickOutside);
    },
    methods: {
        handleClickOutside(event) {
            if (!this.$refs.dropdownToggle.contains(event.target)) {
                this.dropdownOpen = false;
            }
        },
        getImage(fileName){
            return new URL(`/resources/assets/backend/images/client/${fileName}`, import.meta.url).href;
        },
    }

}

</script>

<style lang="scss" scoped></style>

