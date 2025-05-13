import { h } from 'vue';
import {Tag} from 'ant-design-vue';


export const agentPropertyColumns = [
    {
      title: 'ID',
      dataIndex: 'id',
      key: 'id',
      sorter: (a, b) => a.id - b.id,
      sortDirections: ['descend', 'ascend'],
      render: (text, record, index) => index + 1,
      responsive: ['lg'],
    },
    {
      title: 'Name',
      dataIndex: 'title',
      key: 'title',
      type: 'text',
      sorter: (a, b) => a.title.localeCompare(b.title),
      sortDirections: ['descend', 'ascend'],
      customFilterDropdown: true,
      onFilter: (value, record) => record.title.toString().toLowerCase().includes(value.toLowerCase()),
      responsive: ['lg'],
    },
    {
      title: 'Visits',
      dataIndex: 'visits',
      key: 'visits',
      type: 'text',
      sorter: (a, b) => a.visits.localeCompare(b.visits),
      sortDirections: ['descend', 'ascend'],
      customFilterDropdown: true,
      onFilter: (value, record) => record.visits.toString().toLowerCase().includes(value.toLowerCase()),
      responsive: ['lg'],
    },
    {
      title: 'Expiry Date',
      dataIndex: 'publish_end_date',
      key: 'publish_end_date',
      type: 'text',
      sortDirections: ['descend', 'ascend'],
      customFilterDropdown: true,
      onFilter: (value, record) => record.publish_end_date.includes(value),
    },
    {
        title: 'Status',
        dataIndex: 'property_status',
        key: 'status',
        customRender: ({ text }) => {
            let className = '';
            let displayText = text;
            console.log('Status value:', displayText);

          switch (displayText.toLowerCase()) {
            case 'pending':
              className = "bg-emerald-600/10 dark:bg-emerald-600/20 border border-emerald-600/10 dark:border-emerald-600/20 text-emerald-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1";
              break;
            case 'rented':
              className = "bg-blue-600/10 dark:bg-blue-600/20 border border-blue-600/10 dark:border-blue-600/20 text-blue-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1";
              break;
            case 'on hold':
              className = "bg-yellow-600/10 dark:bg-yellow-600/20 border border-yellow-600/10 dark:border-yellow-600/20 text-yellow-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1";
              break;
            case 'preparing for sales':
              className = "bg-orange-600/10 dark:bg-orange-600/20 border border-orange-600/10 dark:border-orange-600/20 text-orange-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1";
              break;
            case 'selling':
                className = 'bg-emerald-600/10 dark:bg-emerald-600/20 border border-emerald-600/10 dark:border-emerald-600/20 text-emerald-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1';
              break;
            case 'sold':
              className = "bg-purple-600/10 dark:bg-purple-600/20 border border-purple-600/10 dark:border-purple-600/20 text-purple-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1";
              break;
            case 'not available':
              className = "bg-gray-600/10 dark:bg-gray-600/20 border border-gray-600/10 dark:border-gray-600/20 text-gray-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1";
              break;
            case 'building':
              className = "bg-indigo-600/10 dark:bg-indigo-600/20 border border-indigo-600/10 dark:border-indigo-600/20 text-indigo-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1";
              break;
            default:
              className = "bg-gray-600/10 dark:bg-gray-600/20 border border-gray-600/10 dark:border-gray-600/20 text-gray-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1";
          }
          return h('span', { class: `${className}` }, displayText);
        },
      },

    {
        title: 'Moderation Status',
        dataIndex: 'moderation_status',
        key: 'moderation_status',

        customRender: ({ text }) => {
          let className = '';
          let displayText = text;

          switch (displayText.toLowerCase()) {
            case 'approved':
              className = 'bg-green-100 dark:bg-green-900 border border-green-600 text-green-600 dark:text-green-300 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1';
              break;
            case 'pending':
                className = "bg-emerald-600/10 dark:bg-emerald-600/20 border border-emerald-600/10 dark:border-emerald-600/20 text-emerald-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1";
              break;
            case 'rejected':
                className="bg-red-600/10 dark:bg-red-600/20 border border-red-600/10 dark:border-red-600/20 text-red-600 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1";
              break;
            default:
              className = 'bg-red-700 dark:bg-gray-900 border border-gray-600 text-gray-600 dark:text-gray-300 text-[15px] font-medium px-2.5 py-0.5 rounded h-5 ms-1';
          }

          return h('span', { class: `${className}` }, displayText);
        },
      },

    {
        title: 'Created At',
        dataIndex: 'created_at',
        key: 'created_at',
        sorter: (a, b) => new Date(a.created_at) - new Date(b.created_at),
        sortDirections: ['descend', 'ascend'],
      },
      {
        title: 'Action',
        dataIndex: 'operation',
        key: 'operation',
      },
];
