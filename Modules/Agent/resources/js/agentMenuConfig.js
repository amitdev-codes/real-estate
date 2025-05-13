 const agentMenuConfig = [
    //Dashboard
    {
      name: 'Dashboard',
      icon: 'mdi mdi-chart-bell-curve-cumulative',
      route: 'agent.dashboard',
      permission: null
    },
    //Real estate
    {
      name: 'My Properties',
      icon: 'mdi mdi-home-city',
      permission: ['view properties','edit properties', 'view favorite properties', 'add properties','view features','view facilities','view reviews','view categories'],
      submenu: [
        {
          name: 'Listings',
          icon: 'mdi mdi-home',
          route: 'agent.properties',
          permission: 'view properties'
        },
      ]
    },




  ];
  export default agentMenuConfig;
