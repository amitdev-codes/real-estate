import $ from "jquery";
window.$ = window.jQuery = $;

import "datatables.net-dt/css/dataTables.dataTables.css";
import "datatables.net-select-dt/css/select.dataTables.css";
import "datatables.net-dt";
import "datatables.net-buttons-dt";
import "datatables.net-responsive-dt";
import "datatables.net-select-dt";

import { usePermissions } from "@/backend/composables/usePermissions";

const { can } = usePermissions();

export const initializeDataTable = (
    dataTableRef,
    props,
    emit,
    handleBulkDelete
) => {
    const tableInstance = $(dataTableRef).DataTable({
        processing: true,
        serverSide: true,
        scrollCollapse: true,
        responsive: true,
        ajax: {
            url: props.dataRoute,
            type: "GET",
            data: function (d) {
                d.columns.forEach((column, index) => {
                    if (column.searchable && column.search.value) {
                        d[`columns[${index}][search][value]`] =
                            column.search.value;
                        d[`columns[${index}][searchable]`] = true;
                    }
                });
                return d;
            },
            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    ?.getAttribute("content"),
            },
        },
        columnDefs: [
            {
                targets: 0,
                width: "50px",
                orderable: false,
                className: "select-checkbox",
                render: function (data, type, row) {
                    return "";
                },
            },
            {
                targets: -1,
                data: null,
                title: "Actions",
                render: (row) => {
                    const viewButton = can(`view ${props.abilityName}`)
                        ? `<button class="btn-view text-green-500 hover:text-green-700 text-lg" data-id="${row.id}">
               <span class="mdi mdi-eye"></span>
             </button>`
                        : "";

                    const editButton = can(`edit ${props.abilityName}`)
                        ? `<button class="btn-edit text-blue-500 hover:text-blue-700 text-lg" data-id="${row.id}">
               <span class="mdi mdi-pencil"></span>
             </button>`
                        : "";

                    const deleteButton = can(`delete ${props.abilityName}`)
                        ? `<button class="btn-delete text-red-500 hover:text-red-700 text-lg" data-id="${row.id}">
               <span class="mdi mdi-delete"></span>
             </button>`
                        : "";

                    return `
          <div class="flex space-x-2 justify-center">
            ${viewButton}
            ${editButton}
            ${deleteButton}
          </div>
        `;
                },
                orderable: false,
            },
            {
                targets: 2,
                render: (data) => {
                    const displayText = Array.isArray(data)
                        ? data.join(", ")
                        : typeof data === "string" && data.length > 30
                        ? data.substring(0, 30) + "..."
                        : data;

                    return `
              <div class="relative group">
                <span class="truncate block max-w-[150px]">${displayText}</span>
                <div class="absolute z-10 left-1/2 -translate-x-1/2 bottom-full mb-2 hidden group-hover:block
                  bg-gray-700 text-white text-xs rounded-lg px-2 py-1
                  whitespace-normal break-words max-w-[250px] shadow-lg">
                  ${data}
                </div>
              </div>
            `;
                },
            },
            {
                targets: "_all",
                searchable: true,
                width: "150px",
                render: function (data, type, row) {
                    return type === "filter" ? data : data;
                },
            },
        ],

        columns: [
            {
                data: null,
                orderable: false,
            },
            ...props.columns,
            {
                targets: -1,
                title: "Actions",
                autoWidth: true,
                className:
                    "text-center font-bold text-gray-600 text-sm f dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600",
            },
        ],
        responsive: true,
        colReorder: true,
        dom: `<"flex justify-between gap-2"
         <"flex items-center"<"custom-buttons">>
        <"flex items-center flex justify-end"B>
      >
      rt
      <"flex flex-col md:flex-row justify-between items-center mt-4 gap-4"
        <"flex text-sm text-gray-700"i>
        <"flex-1 flex justify-center"p>
        <"flex items-center gap-2"l>
      >`,

        buttons: [
            {
                text: `<button
                class="flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-medium m-2 py-1 px-2 transition duration-200"
                @click="handleCreate">
                <i class="mdi mdi-plus"></i> Add New
             </button>`,
                action: () => emit("create", { data: null }),
                visible: can(`create ${props.abilityName}`),
            },
            {
                text: `<button
                class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white font-medium m-2 py-1 px-2 transition duration-200"
                @click="handleDeleteSelected">
                <i class="mdi mdi-trash-can"></i> Delete Selected
             </button>`,
                action: () => {
                    const selectedData = tableInstance
                        .rows({ selected: true })
                        .data()
                        .toArray();
                    if (selectedData.length > 0) {
                        handleBulkDelete(selectedData);
                    }
                },
            },
            {
                text: `<button
                class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-medium m-2 py-1 px-2 transition duration-200"
                @click="handleExport">
                <i class="mdi mdi-export"></i> Export
             </button>`,
                action: () => {
                    emit("show-export-modal");
                },
            },
        ].filter((button) => button.visible != false),

        select: {
            style: "multi",
            selector: "td.select-checkbox, td.select-checkbox input",
            blurable: true,
        },

        language: {
            lengthMenu: "_MENU_ per page",
            search: "",
            searchPlaceholder: "Search...",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries to show",
            infoFiltered: "(filtered from _MAX_ total entries)",
            zeroRecords: "No matching records found",
            emptyTable: "No data available in table",
        },

        initComplete: function () {
            const table = this.api();
            $("#select-all-checkbox").on("change", function () {
                if (this.checked) {
                    table.rows().select();
                } else {
                    table.rows().deselect();
                }
            });
        },
    });

    $('.custom-buttons').html(`
        <button id="toggleSearchBtn"  class="dt-button flex items-center gap-2 bg-blue-500 hover:bg-blue-600 text-white font-medium m-2 py-1 px-2 transition duration-200">
               Search <span class="mdi mdi-filter-plus text-lg top-[6px] start-3"></span>
        </button>
      `);

    return tableInstance;
};
