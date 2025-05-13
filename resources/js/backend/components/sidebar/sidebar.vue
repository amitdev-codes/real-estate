<template>
  <nav id="sidebar" class="sidebar-wrapper sidebar-dark">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <Link :href="resolveRoute((prefix) => `${prefix}.dashboard`)">
          <img src="@logo/favicon/02.png" alt="Dream Estate" />
        </Link>
      </div>
      <ul
        class="sidebar-menu border-t border-white/10"
        data-simplebar
        style="height: calc(100% - 70px)"
      >
        <template v-for="item in filteredMenuItems" :key="item.name">
          <li
            :class="{
              'sidebar-dropdown': item.submenu,
              active: isActive(item) || (item.submenu && openSubmenu === item.name),
            }"
          >
            <template v-if="item.submenu">
              <Link href="#" @click.prevent="toggleSubmenu(item.name)">
                <i :class="item.icon + ' me-2'"></i>{{ item.name }}
              </Link>
              <div class="sidebar-submenu" :class="{ block: openSubmenu === item.name }">
                <ul>
                  <li
                    v-for="subitem in filteredSubmenuItems(item)"
                    :key="subitem.name"
                    :class="{ active: isActive(subitem) }"
                  >
                    <Link :href="resolveRoute(subitem.route)">
                      <i :class="subitem.icon + ' me-2'"></i>{{ subitem.name }}
                    </Link>
                  </li>
                </ul>
              </div>
            </template>
            <Link
              v-else
              :href="resolveRoute(item.route)"
              :class="{ active: isActive(item) }"
            >
              <i :class="item.icon + ' me-2'"></i>
              {{ item.name }}
            </Link>
          </li>
        </template>
      </ul>
    </div>
  </nav>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { usePermissions } from "@/backend/composables/usePermissions";
import { menuConfig } from "@/backend/menuConfig";
import { usePage, router, Link } from "@inertiajs/vue3";

const { can } = usePermissions();
const openSubmenu = ref("");
const page = usePage();

// Get user role from auth user
const userRole = computed(() => {
  if (page.props.auth.user && page.props.auth.user.role) {
    return page.props.auth.user.role; // Keep original case for now
  }
  router.post("logout");
  return null; // Return null if no role to avoid undefined issues
});

// Debugging logs
console.log("User Role:", userRole.value);
console.log("Can view profileOverview:", can("view profileOverview"));

// Resolve the route prefix based on role
const resolveRoutePrefix = (role) => {
  if (!role) return "admin"; // Default to admin if no role
  return role === "SuperAdmin" ? "admin" : role.toLowerCase();
};

// Filter menu items based on role and permissions
const filteredMenuItems = computed(() => {
  const items = menuConfig.filter((item) => {
    // If no showFor, include the item
    if (!item.showFor) return true;

    // Normalize role comparison
    const roleMatch = item.showFor.includes(userRole.value?.toLowerCase());

    // Permission check
    const permMatch = Array.isArray(item.permission)
      ? item.permission.some((perm) => can(perm))
      : !item.permission || can(item.permission);

    return roleMatch && permMatch;
  });
  console.log("Filtered Menu Items:", items);
  return items;
});

const resolveRoute = (routeConfig) => {
  if (typeof routeConfig === "function") {
    if (userRole.value) {
      const prefix = resolveRoutePrefix(userRole.value);
      const resolvedRoute = routeConfig(prefix);
      return route(resolvedRoute);
    }
    return "/logout"; // Fallback route
  }
  return route(routeConfig);
};

const isActive = (item) => {
  if (item.submenu) {
    return item.submenu.some((subitem) => {
      const prefix = resolveRoutePrefix(userRole.value);
      const resolvedRoute =
        typeof subitem.route === "function" ? subitem.route(prefix) : subitem.route;
      return route().current(resolvedRoute);
    });
  }
  const prefix = resolveRoutePrefix(userRole.value);
  const resolvedRoute =
    typeof item.route === "function" ? item.route(prefix) : item.route;
  return route().current(resolvedRoute);
};

const filteredSubmenuItems = (item) => {
  if (!item.submenu) return [];

  return item.submenu.filter((subitem) => {
    const showForCondition =
      !subitem.showFor || subitem.showFor.includes(userRole.value?.toLowerCase());
    const permissionCondition = !subitem.permission || can(subitem.permission);
    return showForCondition && permissionCondition;
  });
};

function toggleSubmenu(item) {
  console.log("Toggling submenu:", item);
  openSubmenu.value = openSubmenu.value === item ? "" : item;
}

function setInitialOpenSubmenu() {
  const activeItem = menuConfig.find(
    (item) =>
      item.submenu &&
      item.submenu.some((subitem) => {
        const prefix = resolveRoutePrefix(userRole.value);
        const resolvedRoute =
          typeof subitem.route === "function" ? subitem.route(prefix) : subitem.route;
        return route().current(resolvedRoute);
      })
  );
  if (activeItem) {
    openSubmenu.value = activeItem.name;
  }
}

onMounted(() => {
  setInitialOpenSubmenu();
});
</script>

<style lang="scss" scoped>
.submenu-toggle {
  display: flex;
  align-items: center;
  width: 100%;
  padding: 12px 15px;
  color: inherit;
  text-decoration: none;
  transition: all 0.3s;
}

.sidebar-submenu {
  display: none;
}

.sidebar-submenu.block {
  display: block;
}
</style>