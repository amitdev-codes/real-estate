import { toast as VueToast } from "vue3-toastify";
class ToastUtility {
    constructor() {
        this.defaultOptions = {
            autoClose: 8000, // Correct option for timeout
            position: "top-right",
            hideProgressBar: false,
            closeOnClick: true,
            pauseOnHover: true,
            draggable: true,
            theme: "colored",
        };
    }

    show(message, type, options = {}) {
        const mergedOptions = {
            ...this.defaultOptions,
            ...options,
            type: type,
        };

        VueToast(message, mergedOptions);
    }

    success(message, options = {}) {
        this.show(message, "success", options);
    }

    error(message, options = {}) {
        this.show(message, "error", options);
    }

    warning(message, options = {}) {
        this.show(message, "warning", options);
    }

    info(message, options = {}) {
        this.show(message, "info", options);
    }
}

export const toast = new ToastUtility();
