export const menuConfig = [
    //Dashboard
    {
        name: "Dashboard",
        icon: "mdi mdi-chart-bell-curve-cumulative",
        route: (prefix) => `${prefix}.dashboard`,
        permission: null,
    },
    {
        name: "Profile Overview",
        icon: "mdi mdi-account-check",
        // route: "agent.profileOverview",
        route: (prefix) => `${prefix}.profileOverview`,
        permission: "view profileOverview",
        showFor: ["agent","agency"],// Only show for agent role if needed add other roles
    },
    {
        name: "Agents",
        icon: "mdi mdi-account-check",
        route: "agency.agents.index",
        permission: "view agentsProfile",
        showFor: ["agency"],// Only show for agency role if needed add other roles
    },
    //Properties
    {
        name: 'Real Estate',
        icon: 'mdi mdi-home-city-outline',
        permission: ['view properties'],
        showFor: ["admin", "superadmin", "agent", "agency"], // Show for these roles
        submenu: [
            {
                name: 'Properties',
                icon: 'mdi mdi-home-group',
                route: (prefix) => `${prefix}.properties.index`,
                permission: 'view properties'
            },
            {
                name: 'Projects',
                icon: 'mdi mdi-office-building-cog-outline',
                route: 'admin.projects.index',
                permission: 'view projects',
                showFor: ["admin", "superadmin"],
            },
            {
                name: 'Property Category',
                icon: 'mdi mdi-home-floor-a',
                route: 'admin.property-categories.index',
                // route: (prefix) => `${prefix}.property-categories.index`,
                permission: 'view property categories',
                showFor: ["admin", "superadmin"],
            },
            {
                name: 'Property Types',
                icon: 'mdi mdi-home-assistant',
                route: 'admin.property-types.index',
                permission: 'view property types',
                showFor: ["admin", "superadmin"],
            },
            {
                name: 'Facilities',
                icon: 'mdi mdi-hospital-building',
                route: 'admin.nearby-facilities.index',
                permission: 'view nearby facilities',
                showFor: ["admin", "superadmin"],
            },
            {
                name: 'Property Features',
                icon: 'mdi mdi-cart-arrow-up',
                route: 'admin.property-features.index',
                permission: 'view property features',
                showFor: ["admin", "superadmin"],
            },
        ]
      },
    //user management
    {
        name: "User Management",
        icon: "mdi mdi-account-edit",
        permission: ["view users", "view roles", "view permissions"],
        showFor: ["admin", "superadmin"],
        submenu: [
            {
                name: "Users",
                icon: "mdi mdi-account-group",
                route: "admin.users.index",
                permission: "view users",
            },
            {
                name: "Roles",
                icon: "mdi mdi-shield-account",
                route: "admin.roles.index",
                permission: "view roles",
            },
            {
                name: "Permissions",
                icon: "mdi mdi-key-variant",
                route: "admin.permissions.index",
                permission: "view permissions",
            },
        ],
    },

    //Locations
    {
        name: "Locations",
        icon: "mdi mdi-earth",
        permission: [
            "view countries",
            "view states",
            "view cities",
            "view locationImporter",
            "view locationExporter",
        ],
        submenu: [
            {
                name: "Countries",
                icon: "mdi mdi-cog-outline",
                route: "admin.countries.index",
                permission: "view countries",
            },
            {
                name: "States",
                icon: "mdi mdi-cog-outline",
                route: "admin.states.index",
                permission: "view states",
            },
            {
                name: "Cities",
                icon: "mdi mdi-cog-outline",
                route: "admin.cities.index",
                permission: "view cities",
            },
            {
                name: "Location Importer",
                icon: "mdi mdi-cog-outline",
                route: "admin.add-property",
                permission: "view locationImporter",
            },
            {
                name: "Location Exporter",
                icon: "mdi mdi-cog-outline",
                route: "admin.add-property",
                permission: "view locationExporter",
            },
        ],
        showFor: ["admin","superadmin"],
    },
    // Log Management
    {
        name: "Log Management",
        icon: "mdi mdi-folder-lock me-2",
        permission: ["view activityLogs", "view systemLogs"],
        showFor: ["admin", "superadmin"],
        submenu: [
              {
                name: 'Activity Logs',
                icon: 'mdi mdi-resistor',
                route: 'admin.activityLogs.index',
                permission: 'view activityLogs'
              },
              {
                name: 'System Logs',
                icon: 'mdi mdi-file-lock me-2',
                route: 'admin.systemLogs.index',
                permission: 'view systemLogs'
              },
        ],
    },
];
