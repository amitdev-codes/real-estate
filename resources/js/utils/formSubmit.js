import { router } from "@inertiajs/vue3";
import { toast } from "@/utils/toast.js";

export const handleSubmit = (
    vueformData,
    form$,
    routeName,
    id = null,
    onSuccessCallback = () => {},
    onErrorCallback = () => {}
) => {
    const formData = form$.requestData;
    const method = id ? "put" : "post";
    const url = id ? route(routeName, id) : route(routeName);

    try {
        router[method](url, formData, {
            preserveScroll: true,
            preserveState: true,
            onSuccess: () => {
                toast.success(id ? "Updated Successfully" : "Created Successfully");
                onSuccessCallback();
            },
            onError: (errors) => {
                console.error("Validation errors:", errors);
                toast.error("Please fix the errors in the form");
                onErrorCallback(errors);
            },
        });
    } catch (error) {
        toast.error("An unexpected error occurred");
        console.error(error);
    }
};