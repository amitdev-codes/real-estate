
import { router } from "@inertiajs/vue3";

export function useFormHandlers(redirectRoute = "dashboard") {
    const handleSuccess = (response, form$) => {
        form$.messageBag.clear();
        form$.messageBag.append("Form submitted successfully", "message");

        // Allow time for the success message to be shown
        setTimeout(() => {
            router.visit(route(redirectRoute));
        }, 200);
    };

    const handleError = (errors, details, form$) => {
        form$.messageBag.clear();
        if (errors.response?.data?.errors) {
            Object.entries(errors.response.data.errors).forEach(
                ([field, messages]) => {
                    let messageBag = form$.el$(field)?.messageBag;
                    if (messageBag) {
                        messageBag.clear();
                        messages.forEach((message) =>
                            messageBag.append(message)
                        );
                    }
                }
            );
        } else {
            // Handle general error
            form$.messageBag.append(
                "An error occurred. Please try again.",
                "error"
            );
        }
    };

    return {
        handleSuccess,
        handleError,
    };
}
