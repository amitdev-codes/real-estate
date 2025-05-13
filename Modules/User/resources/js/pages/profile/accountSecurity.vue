<template>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-16">
        <div class="card">
            <div class="card-header">
                <h3>Change Password</h3>
            </div>
            <div class="card-body">
                <Vueform
                    size="md"
                    :display-errors="false"
                    :method="POST"
                    :endpoint="handleSubmit"
                    @success="handleSuccess"
                    @error="handleError"
                >
                    <StaticElement name="divider" tag="hr" />
                    <TextElement
                        name="password"
                        label="Password"
                        input-type="password"
                        :rules="[
                            'required',
                            'min:8',
                            'same:password_confirmation',
                        ]"
                        field-name="Password"
                    />
                    <TextElement
                        label="Confirm Password"
                        name="password_confirmation"
                        input-type="password"
                        :rules="['required']"
                        field-name="Password confirmation"
                    />
                    <StaticElement name="divider_1" tag="hr" />
                    <ButtonElement
                        name="register"
                        :submits="true"
                        button-label="Update Password"
                        :full="true"
                    />
                </Vueform>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link, useForm, usePage, router } from "@inertiajs/vue3";
import { toast } from "vue3-toastify";
import "vue3-toastify/dist/index.css";

const handleSubmit = (vueformData, form$) => {
    const requestData = form$.requestData;
    // Submit using Inertia
    router.post(route("frontend.userProfile.updatePassword"), requestData, {
        preserveScroll: true,
        onSuccess: () => {
            toast.success("password changed successful!");
        },
        onError: (errors) => {
            toast.error("Update password failed. Please check your inputs.");
        },
    });
};
</script>

<script>
import FrontendLayout from "@/layouts/frontend-layout.vue";
export default {
    layout: FrontendLayout,
};
</script>

<style scoped>
.card {
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin: 20px;
    padding: 20px;
    background-color: #fff;
}

.card-header {
    margin-bottom: 15px;
}

.card-body {
    padding: 15px;
}
</style>
