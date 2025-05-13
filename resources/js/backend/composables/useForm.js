import { ref, computed, reactive } from "vue";
import { router } from "@inertiajs/vue3";

export function useForm(resourceName, modelName, existingItem = null) {
    const form = reactive({});
    const errors = ref({});
    const isSubmitting = ref(false);

    // Dynamically create form based on existing item
    const initializeForm = () => {
        if (existingItem) {
            Object.keys(existingItem).forEach((key) => {
                form[key] = existingItem[key];
            });
        }
    };

    // Initialize form on creation
    initializeForm();

    const isEditMode = computed(() => !!existingItem?.id);

    const submitForm = async () => {
        isSubmitting.value = true;

        try {
            const method = isEditMode.value ? "put" : "post";
            const url = isEditMode.value
                ? `/${resourceName}/${existingItem.id}`
                : `/${resourceName}`;

            router[method](url, {
                ...form,
                onSuccess: () => {
                    isSubmitting.value = false;
                    emit("formSubmitted");
                },
                onError: (err) => {
                    errors.value = err;
                    emit("formError", err);
                    isSubmitting.value = false;
                },
            });
        } catch (error) {
            console.error("Form submission error:", error);
            isSubmitting.value = false;
        }
    };

    const resetForm = () => {
        Object.keys(form).forEach((key) => {
            form[key] = null;
        });
        errors.value = {};
    };

    return {
        form,
        errors,
        isSubmitting,
        isEditMode,
        submitForm,
        resetForm,
    };
}
