import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";

export const useDelete = () => {
    const deleteRow = (routeName, id, onSuccess, onError) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                // Assuming you're using Vue Router's router.delete or a similar method
                router.delete(route(routeName, { id }), {
                    onSuccess: (response) => {
                        if (onSuccess) onSuccess(response);
                        Swal.fire(
                            "Deleted!",
                            "Your record has been deleted.",
                            "success"
                        );
                    },
                    onError: (errors) => {
                        if (onError) onError(errors);
                        Swal.fire(
                            "Error!",
                            "Failed to delete record. Please try again.",
                            "error"
                        );
                    },
                });
            }
        });
    };

    const bulkDelete = (
        routeName,
        modelName,
        selectedRows,
        onSuccess,
        onError
    ) => {
        if (selectedRows.length === 0) {
            Swal.fire(
                "No records selected",
                "Please select at least one record to delete.",
                "warning"
            );
            return;
        }

        Swal.fire({
            title: "Are you sure?",
            text: `You are about to delete ${selectedRows.length} records. This action cannot be undone.`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete them!",
        }).then((result) => {
            if (result.isConfirmed) {
                router.delete(route(routeName, { model: modelName }), {
                    data: { ids: selectedRows.map((data) => data.id) },
                    onSuccess: () => {
                        if (onSuccess) onSuccess();
                        Swal.fire(
                            "Deleted!",
                            "Your records have been deleted.",
                            "success"
                        );
                    },
                    onError: (errors) => {
                        if (onError) onError(errors);
                        Swal.fire(
                            "Error!",
                            "Failed to delete records. Please try again.",
                            "error"
                        );
                    },
                });
            }
        });
    };

    return { deleteRow, bulkDelete };
};
