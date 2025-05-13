<template>
  <!-- sidebar-wrapper -->
  <nav id="sidebar" class="sidebar-wrapper sidebar-dark">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <!-- <router-link to="/"><img src="@backend-assets/images/logo-light.png" alt=""></router-link> -->
        <Link :href="route('admin.dashboard')"
          ><img src="@backend-assets/images/logo-light.png" alt=""
        /></Link>
      </div>

      <ul
        class="sidebar-menu border-t border-white/10"
        data-simplebar
        style="height: calc(100% - 70px)"
      >
        <li :class="activeIndex === '/' ? 'active' : ''">
          <!-- <router-link to="/"><i class="mdi mdi-chart-bell-curve-cumulative me-2"></i>Dashboard</router-link> -->
          <Link :href="route('admin.dashboard')"
            ><i class="mdi mdi-chart-bell-curve-cumulative me-2"></i>Dashboard</Link
          >
        </li>

        <li
          v-if="can('view users') || can('view roles') || can('view permissions')"
          class="sidebar-dropdown"
          :class="{
            active: [
              'admin.users.index',
              'admin.roles.index',
              'admin.permissions.index',
            ].includes(route().current()),
          }"
        >
          <Link
            @click.prevent="
              submenu(menuOpen === 'user-management' ? '' : 'user-management')
            "
          >
            <i class="mdi mdi-account-edit me-2"></i>User Management
          </Link>
          <div class="sidebar-submenu" :class="{ block: menuOpen === 'user-management' }">
            <ul>
              <li
                v-if="can('view users')"
                :class="{ active: route().current('admin.users.index') }"
              >
                <Link :href="route('admin.users.index')">
                  <i class="mdi mdi-account-group me-2"></i>Users
                </Link>
              </li>
              <li
                v-if="can('view roles')"
                :class="{ active: route().current('admin.roles.index') }"
              >
                <Link :href="route('admin.roles.index')">
                  <i class="mdi mdi-shield-account me-2"></i>Roles
                </Link>
              </li>
              <li
                v-if="can('view permissions')"
                :class="{ active: route().current('admin.permissions.index') }"
              >
                <Link :href="route('admin.permissions.index')">
                  <i class="mdi mdi-key-variant me-2"></i>Permissions
                </Link>
              </li>
            </ul>
          </div>
        </li>

        <li
          v-if="can('view properties')"
          :class="{ active: route().current('admin.explore-property') }"
        >
          <Link :href="route('admin.explore-property')">
            <i class="mdi mdi-home-city me-2"></i>Real Estate
          </Link>
        </li>

        <li
          v-if="can('view favorite properties')"
          :class="{ active: route().current('admin.favorite-property') }"
        >
          <Link :href="route('admin.favorite-property')">
            <i class="mdi mdi-home-heart me-2"></i>Favorite Properties
          </Link>
        </li>

        <li
          v-if="can('add properties')"
          :class="{ active: route().current('admin.add-property') }"
        >
          <Link :href="route('admin.add-property')">
            <i class="mdi mdi-home-plus me-2"></i>Add Properties
          </Link>
        </li>

        <li :class="activeIndex === '/chat' ? 'active' : ''">
          <Link :href="route('admin.chat')"
            ><i class="mdi mdi-chat-outline me-2"></i>Chat</Link
          >
        </li>

        <li
          class="sidebar-dropdown"
          :class="
            ['/userprofile', '/profile', '/profile-setting'].includes(activeIndex)
              ? 'active'
              : ''
          "
        >
          <Link
            @click.prevent="submenu(menuOpen === '/userprofile' ? '' : '/userprofile')"
          >
            <i class="mdi mdi-account-edit me-2"></i>User Profile
          </Link>
          <div
            class="sidebar-submenu"
            :class="
              ['/userprofile', '/profile', '/profile-setting'].includes(menuOpen)
                ? 'block'
                : ''
            "
          >
            <ul>
              <li :class="activeIndex === '/admin/profile' ? 'active' : ''">
                <Link :href="route('admin.user.profile')">Profile</Link>
              </li>
              <li :class="activeIndex === '/admin/profile-setting' ? 'active' : ''">
                <Link :href="route('admin.user.profile-setting')">Profile Settings</Link>
              </li>
            </ul>
          </div>
        </li>

        <li
          class="sidebar-dropdown"
          :class="
            ['/admin/blogs', '/admin/blog', '/admin/blog-detail'].includes(activeIndex)
              ? 'active'
              : ''
          "
        >
          <Link href="" @click="submenu(menuOpen === '/blogs' ? '' : '/blogs')"
            ><i class="mdi mdi-post-outline me-2"></i>Blog</Link
          >
          <div
            class="sidebar-submenu"
            :class="
              ['/admin/blogs', '/admin/blog', '/admin/blog-detail'].includes(menuOpen)
                ? 'block'
                : ''
            "
          >
            <ul>
              <!-- <li :class="activeIndex === '/blog' ? 'active' : ''"><router-link to="/blog">Blogs</router-link></li> -->
              <li :class="activeIndex === '/admin/blog' ? 'active' : ''">
                <Link :href="route('admin.blog')">Blogs</Link>
              </li>
              <!-- <li :class="activeIndex === '/blog-detail' ? 'active' : ''"><router-link to="/blog-detail">Blog Detail</router-link></li> -->
              <li :class="activeIndex === '/admin/blog-detail' ? 'active' : ''">
                <Link :href="route('admin.blog-details')">Blog Detail</Link>
              </li>
            </ul>
          </div>
        </li>

        <li
          class="sidebar-dropdown"
          :class="
            [
              '/pages',
              '/starter',
              '/faqs',
              '/pricing',
              '/review',
              '/privacy',
              '/terms',
            ].includes(activeIndex)
              ? 'active'
              : ''
          "
        >
          <Link href="" @click="submenu(menuOpen === '/pages' ? '' : '/pages')"
            ><i class="mdi mdi-file-document-outline me-2"></i>Pages</Link
          >
          <div
            class="sidebar-submenu"
            :class="
              [
                '/pages',
                '/starter',
                '/faqs',
                '/pricing',
                '/review',
                '/privacy',
                '/terms',
              ].includes(menuOpen)
                ? 'block'
                : ''
            "
          >
            <ul>
              <!-- <li :class="activeIndex === '/starter' ? 'active' : ''"><router-link to="/starter">Starter</router-link></li> -->
              <li :class="activeIndex === 'admin/starter' ? 'active' : ''">
                <Link :href="route('admin.starter')">Starter</Link>
              </li>
              <!-- <li :class="activeIndex === '/faqs' ? 'active' : ''"><router-link to="/faqs">FAQs</router-link></li> -->
              <li :class="activeIndex === 'admin/faqs' ? 'active' : ''">
                <Link :href="route('admin.faqs')">FAQs</Link>
              </li>
              <!-- <li :class="activeIndex === '/pricing' ? 'active' : ''"><router-link to="/pricing">Pricing</router-link></li> -->
              <li :class="activeIndex === 'admin/pricing' ? 'active' : ''">
                <Link :href="route('admin.pricing')">Pricing</Link>
              </li>
              <!-- <li :class="activeIndex === '/review' ? 'active' : ''"><router-link to="/review">Review</router-link></li> -->
              <li :class="activeIndex === 'admin/review' ? 'active' : ''">
                <Link :href="route('admin.review')">Review</Link>
              </li>
              <!-- <li :class="activeIndex === '/privacy' ? 'active' : ''"><router-link to="/privacy">Privacy Policy</router-link></li> -->
              <li :class="activeIndex === 'admin/privacy' ? 'active' : ''">
                <Link :href="route('admin.privacy-policy')">Privacy Policy</Link>
              </li>
              <!-- <li :class="activeIndex === '/terms' ? 'active' : ''"><router-link to="/terms">Term & Condition</router-link></li> -->
              <li :class="activeIndex === 'admin/terms' ? 'active' : ''">
                <Link :href="route('admin.terms-and-condition')">Term and Condition</Link>
              </li>
            </ul>
          </div>
        </li>

        <li
          class="sidebar-dropdown"
          :class="
            [
              '/authentication',
              '/login',
              '/signup',
              '/signup-success',
              '/reset-password',
              '/lock-screen',
            ].includes(activeIndex)
              ? 'active'
              : ''
          "
        >
          <!-- <router-link to="" @click="submenu(menuOpen === '/authentication' ? '' : '/authentication')"><i class="mdi mdi-login me-2"></i>Authentication</router-link> -->
          <Link
            href=""
            @click="submenu(menuOpen === '/authentication' ? '' : '/authentication')"
            ><i class="mdi mdi-login me-2"></i>Authentication</Link
          >
          <div
            class="sidebar-submenu"
            :class="
              [
                '/authentication',
                '/login',
                '/signup',
                '/signup-success',
                '/reset-password',
                '/lock-screen',
              ].includes(menuOpen)
                ? 'block'
                : ''
            "
          >
            <ul>
              <!-- <li :class="activeIndex === '/login' ? 'active' : ''"><router-link to="/login">Login</router-link></li> -->
              <li :class="activeIndex === 'admin/login' ? 'active' : ''">
                <Link :href="route('admin.login')">Login</Link>
              </li>
              <!-- <li :class="activeIndex === '/signup' ? 'active' : ''"><router-link to="/signup">Signup</router-link></li> -->
              <li :class="activeIndex === 'admin/signup' ? 'active' : ''">
                <Link :href="route('admin.backend.signup')">Signup</Link>
              </li>
              <!-- <li :class="activeIndex === '/signup-success' ? 'active' : ''"><router-link to="/signup-success">Signup Success</router-link></li> -->
              <li :class="activeIndex === 'admin/signup-success' ? 'active' : ''">
                <Link :href="route('admin.backend.signup-success')">Signup Success</Link>
              </li>
              <!-- <li :class="activeIndex === '/reset-password' ? 'active' : ''"><router-link to="/reset-password">Reset Password</router-link></li> -->
              <li :class="activeIndex === 'admin/reset-password' ? 'active' : ''">
                <Link :href="route('admin.backend.reset-password')">Reset Password</Link>
              </li>
              <!-- <li :class="activeIndex === '/lock-screen' ? 'active' : ''"><router-link to="/lock-screen">Lockscreen</router-link></li> -->
              <li :class="activeIndex === 'admin/lock-screen' ? 'active' : ''">
                <Link :href="route('admin.backend.lock-screen')">Lockscreen</Link>
              </li>
            </ul>
          </div>
        </li>

        <li
          class="sidebar-dropdown"
          :class="
            [
              '/comingsoon',
              '/maintenance',
              '/error',
              '/thankyou',
              '/miscellaneous',
            ].includes(activeIndex)
              ? 'active'
              : ''
          "
        >
          <!-- <router-link to="" @click="submenu(menuOpen === '/miscellaneous' ? '' : '/miscellaneous')"><i class="mdi mdi-layers me-2"></i>Miscellaneous</router-link> -->
          <Link
            href=""
            @click="submenu(menuOpen === '/miscellaneous' ? '' : '/miscellaneous')"
            ><i class="mdi mdi-layers me-2"></i>Miscellaneous</Link
          >
          <div
            class="sidebar-submenu"
            :class="
              [
                '/comingsoon',
                '/maintenance',
                '/error',
                '/thankyou',
                '/miscellaneous',
              ].includes(menuOpen)
                ? 'block'
                : ''
            "
          >
            <ul>
              <!-- <li :class="activeIndex === '/comingsoon' ? 'active' : ''"><router-link to="/comingsoon">Comingsoon</router-link></li> -->
              <li :class="activeIndex === '/comingsoon' ? 'active' : ''">
                <Link :href="route('admin.comingsoon')">Comingsoon</Link>
              </li>
              <!-- <li :class="activeIndex === '/maintenance' ? 'active' : ''"><router-link to="/maintenance">Maintenance</router-link></li> -->
              <li :class="activeIndex === '/maintenance' ? 'active' : ''">
                <Link :href="route('admin.maintenance')">Maintenance</Link>
              </li>
              <!-- <li :class="activeIndex === '/error' ? 'active' : ''"><router-link to="/error">Error</router-link></li> -->
              <li :class="activeIndex === '/error' ? 'active' : ''">
                <Link :href="route('admin.error')">Error</Link>
              </li>
              <!-- <li :class="activeIndex === '/thankyou' ? 'active' : ''"><router-link to="/thankyou">Thank You</router-link></li> -->
              <li :class="activeIndex === '/thankyou' ? 'active' : ''">
                <Link :href="route('admin.thankyou')">Thank You</Link>
              </li>
            </ul>
          </div>
        </li>

        <li
          v-if="can('view activityLog') || can('view systemLog')"
          class="sidebar-dropdown"
          :class="{
            active: ['admin.activityLogs.index', 'admin.systemLogs.index'].includes(
              route().current()
            ),
          }"
        >
          <Link
            @click.prevent="
              submenu(menuOpen === 'log-management' ? '' : 'log-management')
            "
          >
            <i class="mdi mdi-folder-lock me-2"></i>Log Management
          </Link>
          <div class="sidebar-submenu" :class="{ block: menuOpen === 'log-management' }">
            <ul>
              <li
                v-if="can('view activityLog')"
                :class="{ active: route().current('admin.activityLogs.index') }"
              >
                <Link :href="route('admin.activityLogs.index')">
                  <i class="mdi mdi-resistor"></i>Activity Logs
                </Link>
              </li>
              <li
                v-if="can('view systemLog')"
                :class="{ active: route().current('admin.systemLogs.index') }"
              >
                <Link :href="route('admin.systemLogs.index')">
                  <i class="mdi mdi-file-lock me-2"></i>System Logs
                </Link>
              </li>
            </ul>
          </div>
        </li>
      </ul>

      <!-- sidebar-menu  -->
    </div>
  </nav>
  <!-- sidebar-wrapper  -->
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { usePermissions } from "@/backend/composables/usePermissions";

const { can } = usePermissions();
const menu = ref(true);
const menuOpen = ref("");
// const activeIndex = computed(() => window.location.pathname);

onMounted(() => {
  //menuOpen.value = activeIndex.value;
  menuOpen.value = route().current();
  scrollToTop();
});

function submenu(item) {
  menu.value = !menu.value;
  menuOpen.value = item;
}

function scrollToTop() {
  window.scrollTo({
    top: 0,
    behavior: "smooth",
  });
}
</script>

<style lang="scss" scoped></style>
