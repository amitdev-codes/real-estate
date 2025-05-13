<template>
    <!-- :href="route('frontend.')" -->
    <nav id="topnav" class="defaultscroll is-sticky z-20">
        <div class="relative" :class="container">
            <!-- Logo container-->
            <Link
                v-if="logoLight"
                class="logo"
                :href="route('frontend.index-one')"
            >
                <span class="inline-block dark:hidden">
                    <img
                        src="@frontend-assets/images/logo-dark.png"
                        class="l-dark is-mobile"
                        height="24"
                        alt=""
                    />
                    <img
                        src="@frontend-assets/images/logo-dark.png"
                        class="l-light"
                        height="24"
                        alt=""
                    />
                </span>
                <img
                    src="@frontend-assets/images/logo-dark.png"
                    height="24"
                    class="l-light toggle-image hidden dark:inline-block"
                    alt=""
                />
            </Link>

            <Link v-else class="logo" :href="route('frontend.index-one')">
                <img
                    src="@frontend-assets/images/logo-dark.png"
                    class="l-dark inline-block dark:hidden"
                    alt=""
                />
                <img
                    src="@frontend-assets/images/logo-light.png"
                    class="l-light hidden dark:inline-block"
                    alt=""
                />
            </Link>
            <!-- End Logo container-->

            <!-- Start Mobile Toggle -->
            <div class="menu-extras" @click="handler">
                <div class="menu-item">
                    <a
                        class="navbar-toggle"
                        id="isToggle"
                        :class="toggle === false ? '' : 'open'"
                    >
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                </div>
            </div>
            <!-- End Mobile Toggle -->

            <!--Login button Start-->
            <ul class="buy-button list-none mt-3">
                <!-- Unauthenticated State -->
                <template v-if="!$page.props.auth.user">
                    <li class="inline mb-0">
                        <Link
                            href="/login"
                            class="btn btn-icon bg-green-600 hover:bg-green-700 border-green-600 dark:border-green-600 text-white rounded-full"
                        >
                            <i
                                data-feather="user"
                                class="size-4 stroke-[3]"
                            ></i>
                        </Link>
                    </li>
                    <li class="sm:inline ps-1 mb-0 hidden">
                        <Link
                            href="/register"
                            class="btn bg-green-600 hover:bg-green-700 border-green-600 dark:border-green-600 text-white rounded-full"
                        >
                            Signup
                        </Link>
                    </li>
                </template>

                <!-- Authenticated State -->
                <template v-else>
                    <li class="inline mb-0 relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <li class="inline mb-0">
                                    <img
                                        :src="usePage().props.auth.user?.media?.[0]?.url"
                                        :alt="$page.props.auth.user.name"
                                        class="btn btn-icon bg-green-600 hover:bg-green-700 border-green-600 dark:border-green-600 text-white rounded-full"
                                    />
                                </li>
                            </template>

                            <template #content>
                                <DropdownLink
                                    :href="
                                        route('frontend.userProfile.show', {
                                            id: $page.props.auth.user.id,
                                        })
                                    "
                                >
                                    Profile
                                </DropdownLink>
                                <DropdownLink
                                    :href="route('frontend.shortlist.index')"
                                >
                                    My ShortList
                                </DropdownLink>
                                <DropdownLink
                                    :href="route('frontend.user.profile')"
                                >
                                    Property Preferences
                                </DropdownLink>
                                <DropdownLink
                                    :href="
                                        route(
                                            'frontend.userProfile.changePassword'
                                        )
                                    "
                                >
                                    Account Security
                                </DropdownLink>

                                <div class="border-t border-gray-200"></div>
                                <DropdownLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Logout
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </li>
                </template>
            </ul>
            <!--Login button End-->

            <div id="navigation" :class="toggle === false ? 'none' : 'block'">
                <!-- Navigation Menu-->
                <ul class="navigation-menu" :class="navLight">
                    <li
                        class="has-submenu parent-menu-item"
                        :class="
                            [
                                '/home',
                                '/',
                                '/index-two',
                                '/index-three',
                                '/index-four',
                                '/index-five',
                                '/index-six',
                                '/index-seven',
                                '/index-eight',
                            ].includes(activeIndex)
                                ? 'active'
                                : ''
                        "
                    >
                        <Link
                            href=""
                            @click="
                                submenu(openMenu === '/home' ? '' : '/home')
                            "
                            >Home</Link
                        >
                        <span class="menu-arrow"></span>
                        <ul
                            class="submenu"
                            :class="
                                [
                                    '/home',
                                    '/',
                                    '/index-two',
                                    '/index-three',
                                    '/index-four',
                                    '/index-five',
                                    '/index-six',
                                    '/index-seven',
                                    '/index-eight',
                                ].includes(openMenu)
                                    ? 'open'
                                    : ''
                            "
                        >
                            <li :class="activeIndex === '/' ? 'active' : ''">
                                <Link
                                    :href="route('frontend.index-one')"
                                    class="sub-menu-item"
                                    >Hero One</Link
                                >
                            </li>
                            <li
                                :class="
                                    activeIndex === '/index-two' ? 'active' : ''
                                "
                            >
                                <Link
                                    :href="route('frontend.index-two')"
                                    class="sub-menu-item"
                                    >Hero Two</Link
                                >
                            </li>
                            <li
                                :class="
                                    activeIndex === '/index-three'
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    :href="route('frontend.index-three')"
                                    class="sub-menu-item"
                                    >Hero Three</Link
                                >
                            </li>
                            <li
                                :class="
                                    activeIndex === '/index-four'
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    :href="route('frontend.index-four')"
                                    class="sub-menu-item"
                                    >Hero Four</Link
                                >
                            </li>
                            <li
                                :class="
                                    activeIndex === '/index-five'
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    :href="route('frontend.index-five')"
                                    class="sub-menu-item"
                                    >Hero Five</Link
                                >
                            </li>
                            <li
                                :class="
                                    activeIndex === '/index-six' ? 'active' : ''
                                "
                            >
                                <Link
                                    :href="route('frontend.index-six')"
                                    class="sub-menu-item"
                                    >Hero Six</Link
                                >
                            </li>
                            <li
                                :class="
                                    activeIndex === '/index-seven'
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    :href="route('frontend.index-seven')"
                                    class="sub-menu-item"
                                    >Hero Seven</Link
                                >
                            </li>
                            <li
                                :class="
                                    activeIndex === '/index-eight'
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    :href="route('frontend.index-eight')"
                                    class="sub-menu-item"
                                    >Hero Eight</Link
                                >
                            </li>
                        </ul>
                    </li>

                    <li :class="activeIndex === '/buy' ? 'active' : ''">
                        <Link
                            :href="route('frontend.buy')"
                            class="sub-menu-item"
                            >Buy</Link
                        >
                    </li>
                    <li :class="activeIndex === '/sell' ? 'active' : ''">
                        <Link
                            :href="route('frontend.sell')"
                            class="sub-menu-item"
                            >Sell</Link
                        >
                    </li>

                    <li
                        class="has-submenu parent-parent-menu-item"
                        :class="
                            [
                                '/listing',
                                '/gridview',
                                '/grid',
                                '/grid-sidebar',
                                '/grid-map',
                                '/listview',
                                '/list',
                                '/list-sidebar',
                                '/list-map',
                                '/property',
                                '/property-detail',
                                '/property-detail-two',
                            ].includes(activeIndex)
                                ? 'active'
                                : ''
                        "
                    >
                        <Link
                            href=""
                            @click="
                                submenu(
                                    openMenu === '/listing' ? '' : '/listing'
                                )
                            "
                            >Listing</Link
                        >
                        <span class="menu-arrow"></span>

                        <ul
                            class="submenu"
                            :class="
                                [
                                    '/listing',
                                    '/gridview',
                                    '/listview',
                                    '/property',
                                ].includes(openMenu)
                                    ? 'open'
                                    : ''
                            "
                        >
                            <li
                                class="has-submenu parent-menu-item"
                                :class="
                                    [
                                        '/gridview',
                                        '/grid',
                                        '/grid-sidebar',
                                        '/grid-map',
                                    ].includes(activeIndex)
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    href=""
                                    @click="
                                        submenu(
                                            openMenu === '/gridview'
                                                ? ''
                                                : '/gridview'
                                        )
                                    "
                                    >Grid View</Link
                                >
                                <span class="submenu-arrow"></span>
                                <ul
                                    class="submenu"
                                    :class="
                                        [
                                            '/gridview',
                                            '/grid',
                                            '/grid-sidebar',
                                            '/grid-map',
                                        ].includes(openMenu)
                                            ? 'open'
                                            : ''
                                    "
                                >
                                    <li
                                        :class="
                                            activeIndex === '/grid'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="route('frontend.grid')"
                                            class="sub-menu-item"
                                            >Grid Listing</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex === '/grid-sidebar'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="
                                                route('frontend.grid-sidebar')
                                            "
                                            class="sub-menu-item"
                                            >Grid Sidebar</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex === '/grid-map'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="route('frontend.grid-map')"
                                            class="sub-menu-item"
                                            >Grid With Map</Link
                                        >
                                    </li>
                                </ul>
                            </li>

                            <li
                                class="has-submenu parent-menu-item"
                                :class="
                                    [
                                        '/listview',
                                        '/list',
                                        '/list-sidebar',
                                        '/list-map',
                                    ].includes(activeIndex)
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    href=""
                                    @click="
                                        submenu(
                                            openMenu === '/listview'
                                                ? ''
                                                : '/listview'
                                        )
                                    "
                                    >List View</Link
                                >
                                <span class="submenu-arrow"></span>
                                <ul
                                    class="submenu"
                                    :class="
                                        [
                                            '/listview',
                                            '/list',
                                            '/list-sidebar',
                                            '/list-map',
                                        ].includes(openMenu)
                                            ? 'open'
                                            : ''
                                    "
                                >
                                    <li
                                        :class="
                                            activeIndex === '/list'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="route('frontend.list')"
                                            class="sub-menu-item"
                                            >List Listing</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex === '/list-sidebar'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="
                                                route('frontend.list-sidebar')
                                            "
                                            class="sub-menu-item"
                                            >List Sidebar</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex === '/list-map'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="route('frontend.list-map')"
                                            class="sub-menu-item"
                                            >List With Map</Link
                                        >
                                    </li>
                                </ul>
                            </li>

                            <li
                                class="has-submenu parent-menu-item"
                                :class="
                                    [
                                        '/property',
                                        '/property-detail-one',
                                        '/property-detail-two',
                                    ].includes(activeIndex)
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    href=""
                                    @click="
                                        submenu(
                                            openMenu === '/property'
                                                ? ''
                                                : '/property'
                                        )
                                    "
                                    >Property Detail</Link
                                >
                                <span class="submenu-arrow"></span>
                                <ul
                                    class="submenu"
                                    :class="
                                        [
                                            '/property',
                                            '/property-detail-one',
                                            '/property-detail-two',
                                        ].includes(openMenu)
                                            ? 'open'
                                            : ''
                                    "
                                >
                                    <li
                                        :class="
                                            activeIndex ===
                                            '/property-detail-one'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'frontend.property-detail-one'
                                                )
                                            "
                                            class="sub-menu-item"
                                            >Property Detail</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex ===
                                            '/property-detail-two'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'frontend.property-detail-two'
                                                )
                                            "
                                            class="sub-menu-item"
                                            >Property Detail Two</Link
                                        >
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li
                        class="has-submenu parent-parent-menu-item"
                        :class="
                            [
                                '/pages',
                                '/about-us',
                                '/features',
                                '/pricing',
                                '/faqs',
                                '/agent',
                                '/agents',
                                '/agent-profile',
                                '/agency',
                                '/agencies',
                                '/agency-profile',
                                '/authpages',
                                '/login',
                                '/register',
                                '/auth-re-password',
                                '/utility',
                                '/terms',
                                '/privacy',
                                '/blog',
                                '/blogs',
                                '/blog-sidebar',
                                '/blog-detail',
                                '/special',
                                '/comingsoon',
                                '/maintenance',
                                '/404',
                            ].includes(activeIndex)
                                ? 'active'
                                : ''
                        "
                    >
                        <Link
                            href=""
                            @click="
                                submenu(openMenu === '/pages' ? '' : '/pages')
                            "
                            >Pages</Link
                        >
                        <span class="menu-arrow"></span>
                        <ul
                            class="submenu"
                            :class="
                                [
                                    '/pages',
                                    '/about-us',
                                    '/features',
                                    '/pricing',
                                    '/faqs',
                                    '/agent',
                                    '/agency',
                                    '/authpages',
                                    '/utility',
                                    '/blog',
                                    '/special',
                                ].includes(openMenu)
                                    ? 'open'
                                    : ''
                            "
                        >
                            <li
                                :class="
                                    activeIndex === '/about-us' ? 'active' : ''
                                "
                            >
                                <Link
                                    :href="route('frontend.about-us')"
                                    class="sub-menu-item"
                                    >About Us</Link
                                >
                            </li>
                            <li
                                :class="
                                    activeIndex === '/features' ? 'active' : ''
                                "
                            >
                                <Link
                                    :href="route('frontend.features')"
                                    class="sub-menu-item"
                                    >Featues</Link
                                >
                            </li>
                            <li
                                :class="
                                    activeIndex === '/pricing' ? 'active' : ''
                                "
                            >
                                <Link
                                    :href="route('frontend.pricing')"
                                    class="sub-menu-item"
                                    >Pricing</Link
                                >
                            </li>
                            <li
                                :class="activeIndex === '/faqs' ? 'active' : ''"
                            >
                                <Link
                                    :href="route('frontend.faqs')"
                                    class="sub-menu-item"
                                    >Faqs</Link
                                >
                            </li>

                            <li
                                class="has-submenu parent-menu-item"
                                :class="
                                    [
                                        '/agent',
                                        '/agents',
                                        '/agent-profile',
                                    ].includes(activeIndex)
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    href=""
                                    @click="
                                        submenu(
                                            openMenu === '/agent'
                                                ? ''
                                                : '/agent'
                                        )
                                    "
                                    >Agents</Link
                                >
                                <span class="submenu-arrow"></span>
                                <ul
                                    class="submenu"
                                    :class="
                                        [
                                            '/agent',
                                            '/agents',
                                            '/agent-profile',
                                        ].includes(openMenu)
                                            ? 'open'
                                            : ''
                                    "
                                >
                                    <li
                                        :class="
                                            activeIndex === '/agents'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="route('frontend.agents')"
                                            class="sub-menu-item"
                                            >Agents</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex === '/agent-profile'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="
                                                route('frontend.agent-profile')
                                            "
                                            class="sub-menu-item"
                                            >Agent Profile</Link
                                        >
                                    </li>
                                </ul>
                            </li>

                            <li
                                class="has-submenu parent-menu-item"
                                :class="
                                    [
                                        '/agency',
                                        '/agencies',
                                        '/agency-profile',
                                    ].includes(activeIndex)
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    href=""
                                    @click="
                                        submenu(
                                            openMenu === '/agency'
                                                ? ''
                                                : '/agency'
                                        )
                                    "
                                    >Agencies</Link
                                >
                                <span class="submenu-arrow"></span>
                                <ul
                                    class="submenu"
                                    :class="
                                        [
                                            '/agency',
                                            '/agencies',
                                            '/agency-profile',
                                        ].includes(openMenu)
                                            ? 'open'
                                            : ''
                                    "
                                >
                                    <li
                                        :class="
                                            activeIndex === '/agencies'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="route('frontend.agencies')"
                                            class="sub-menu-item"
                                            >Agencies</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex === '/agency-profile'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="
                                                route('frontend.agency-profile')
                                            "
                                            class="sub-menu-item"
                                            >Agency Profile</Link
                                        >
                                    </li>
                                </ul>
                            </li>

                            <li
                                class="has-submenu parent-menu-item"
                                :class="
                                    [
                                        '/authpages',
                                        '/login',
                                        '/register',
                                        '/auth-reset-password',
                                    ].includes(activeIndex)
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    href=""
                                    @click="
                                        submenu(
                                            openMenu === '/authpages'
                                                ? ''
                                                : '/authpages'
                                        )
                                    "
                                    >Auth Pages</Link
                                >
                                <span class="submenu-arrow"></span>
                                <ul
                                    class="submenu"
                                    :class="
                                        [
                                            '/authpages',
                                            '/login',
                                            '/register',
                                            '/auth-reset-password',
                                        ].includes(openMenu)
                                            ? 'open'
                                            : ''
                                    "
                                >
                                    <li
                                        :class="
                                            activeIndex === '/login'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="route('login')"
                                            class="sub-menu-item"
                                            >Login</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex === '/register'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="route('register')"
                                            class="sub-menu-item"
                                            >Signup</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex ===
                                            '/auth-reset-password'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="
                                                route(
                                                    'frontend.auth-reset-password'
                                                )
                                            "
                                            class="sub-menu-item"
                                            >Reset Password</Link
                                        >
                                    </li>
                                </ul>
                            </li>

                            <li
                                class="has-submenu parent-menu-item"
                                :class="
                                    ['/utility', '/terms', '/privacy'].includes(
                                        activeIndex
                                    )
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    href=""
                                    @click="
                                        submenu(
                                            openMenu === '/utility'
                                                ? ''
                                                : '/utility'
                                        )
                                    "
                                    >Utility</Link
                                >
                                <span class="submenu-arrow"></span>
                                <ul
                                    class="submenu"
                                    :class="
                                        [
                                            '/utility',
                                            '/terms',
                                            '/privacy',
                                        ].includes(openMenu)
                                            ? 'open'
                                            : ''
                                    "
                                >
                                    <li
                                        :class="
                                            activeIndex === '/terms'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="route('frontend.terms')"
                                            class="sub-menu-item"
                                            >Terms of Services</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex === '/privacy'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="route('frontend.privacy')"
                                            class="sub-menu-item"
                                            >Privacy Policy</Link
                                        >
                                    </li>
                                </ul>
                            </li>

                            <li
                                class="has-submenu parent-menu-item"
                                :class="
                                    [
                                        '/blog',
                                        '/blogs',
                                        '/blog-sidebar',
                                        '/blog-detail',
                                    ].includes(activeIndex)
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    href=""
                                    @click="
                                        submenu(
                                            openMenu === '/blog' ? '' : '/blog'
                                        )
                                    "
                                    >Blog</Link
                                >
                                <span class="submenu-arrow"></span>
                                <ul
                                    class="submenu"
                                    :class="
                                        [
                                            '/blog',
                                            '/blogs',
                                            '/blog-sidebar',
                                            '/blog-detail',
                                        ].includes(openMenu)
                                            ? 'open'
                                            : ''
                                    "
                                >
                                    <li
                                        :class="
                                            activeIndex === '/blogs'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="route('frontend.blogs')"
                                            class="sub-menu-item"
                                        >
                                            Blogs</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex === '/blog-sidebar'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="
                                                route('frontend.blog-sidebar')
                                            "
                                            class="sub-menu-item"
                                        >
                                            Blog Sidebar</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex === '/blog-detail'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="
                                                route('frontend.blog-detail')
                                            "
                                            class="sub-menu-item"
                                        >
                                            Blog Detail</Link
                                        >
                                    </li>
                                </ul>
                            </li>

                            <li
                                class="has-submenu parent-menu-item"
                                :class="
                                    [
                                        '/special',
                                        '/coming-soon',
                                        '/maintenance',
                                        '/404',
                                    ].includes(activeIndex)
                                        ? 'active'
                                        : ''
                                "
                            >
                                <Link
                                    href=""
                                    @click="
                                        submenu(
                                            openMenu === '/special'
                                                ? ''
                                                : '/special'
                                        )
                                    "
                                >
                                    Special </Link
                                ><span class="submenu-arrow"></span>
                                <ul
                                    class="submenu"
                                    :class="
                                        [
                                            '/special',
                                            '/coming-soon',
                                            '/maintenance',
                                            '/404',
                                        ].includes(openMenu)
                                            ? 'open'
                                            : ''
                                    "
                                >
                                    <li
                                        :class="
                                            activeIndex === '/coming-soon'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="
                                                route('frontend.coming-soon')
                                            "
                                            class="sub-menu-item"
                                            >Comingsoon</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex === '/maintenance'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="
                                                route('frontend.maintenance')
                                            "
                                            class="sub-menu-item"
                                            >Maintenance</Link
                                        >
                                    </li>
                                    <li
                                        :class="
                                            activeIndex === '/404'
                                                ? 'active'
                                                : ''
                                        "
                                    >
                                        <Link
                                            :href="route('frontend.404')"
                                            class="sub-menu-item"
                                            >404! Error</Link
                                        >
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li :class="activeIndex === '/contact' ? 'active' : ''">
                        <Link
                            :href="route('frontend.contact')"
                            class="sub-menu-item"
                            >Contact</Link
                        >
                    </li>
                </ul>
                <!--end navigation menu-->
            </div>
            <!--end navigation-->
        </div>
        <!--end container-->
    </nav>
    <!--end header-->
    <!-- End Navbar -->
</template>

<script setup>
// import { Link } from '@inertiajs/vue3';
import { ref, onMounted, onUnmounted, computed } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import feather from "feather-icons";
const menu = ref(true);
const current = ref("");
const toggle = ref(false);
const activeIndex = computed(() => window.location.pathname);
const openMenu = ref("");

const props = defineProps({
    logoLight: {
        type: Boolean,
        required: true,
    },
    navLight: {
        type: String,
        required: true,
    },
    container: {
        type: String,
        required: true,
    },
});
const mediaUrl = usePage().props.auth.user?.media?.[0]?.url;
const thumbUrl = usePage().props.auth.user?.media?.[0]?.thumb_url;
const previewUrl = usePage().props.auth.user?.media?.[0]?.preview_url;

// console.log(usePage().props.auth.user);
// console.log(thumbUrl);
// console.log(thumbUrl);
// console.log(mediaUrl);

const profilePhotoUrl = computed(() => {
    const user = usePage().props.auth.user;
    return user.profile_photo_url || "/default-avatar.png";
});

console.log(usePage().props.auth.user);

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
    window.addEventListener("scroll", onscroll);
    scrollToTop();
    feather.replace();
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
    window.removeEventListener("scroll", onscroll);
});

function handler() {
    toggle.value = !toggle.value;
}

function submenu(item) {
    menu.value = !menu.value;
    openMenu.value = item;
}

function handleScroll() {
    const navbar = document.getElementById("topnav");
    if (window.scrollY >= 50) {
        navbar.classList.add("nav-sticky");
    } else {
        navbar.classList.remove("nav-sticky");
    }
}

function onscroll() {
    const sections = document.querySelectorAll("section");
    const navItems = document.querySelectorAll("nav.container.collapse ul li");
    let currentSectionId = ""; // Define a variable to store the current section's id
    sections.forEach((section) => {
        const sectionTop = section.offsetTop;
        if (window.pageYOffset >= sectionTop - 60) {
            currentSectionId = section.getAttribute("id");
        }
    });
    navItems.forEach((li) => {
        if (li.classList.contains(currentSectionId)) {
            li.classList.add("active");
        } else {
            li.classList.remove("active");
        }
    });
    current.value = currentSectionId; // Update the current ref
}

function scrollToTop() {
    window.scrollTo({ top: 0, behavior: "smooth" });
}
</script>

<style scoped>
.l-light,
.l-dark {
    width: 200px !important;
}
</style>
