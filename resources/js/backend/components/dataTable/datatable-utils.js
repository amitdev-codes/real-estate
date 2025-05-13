export const createActionHandlers = (
    tableInstance,
    props,
    emit,
    handleView,
    handleDelete,
    dataTableRef
) => {
    if (!tableInstance) {
        console.error("tableInstance is undefined");
        return;
    }
    // Button click handler factory
    const handleButtonClick = (action) => {
        $(dataTableRef.value).on("click", `.btn-${action}`, function () {
            const rowData = tableInstance.row($(this).closest("tr")).data();
            switch (action) {
                case "view":
                    handleView(rowData);
                    break;
                case "edit":
                    emit("edit", rowData);
                    break;
                case "delete":
                    handleDelete(rowData.id);
                    break;
            }
        });
    };
    ["view", "edit", "delete"].forEach((action) => handleButtonClick(action));

    // Method to unbind event handlers (useful for cleanup)
    const unbindActionHandlers = () => {
        ["view", "edit", "delete"].forEach((action) => {
            $(dataTableRef.value).off("click", `.btn-${action}`);
        });
    };
    return {
        tableInstance,
        unbindActionHandlers,
    };
};
