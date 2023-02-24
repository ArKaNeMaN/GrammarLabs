<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import PageTitle from "@/Components/PageTitle.vue";
import FormField from "@/Components/Form/FormField.vue";
import NavLink from "@/Components/Navigation/NavLink.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    login: '',
    password: '',
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <page-title title="Вход"/>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <form-field label="Логин">
                <text-input
                    type="text"
                    v-model="form.login"
                    class="w-full"
                    required
                    autofocus
                    autocomplete="username"
                    :error="form.errors.login"
                />
            </form-field>
            <form-field label="Пароль">
                <text-input
                    type="password"
                    v-model="form.password"
                    class="w-full"
                    required
                    autocomplete="current-password"
                    :error="form.errors.password"
                />
            </form-field>

            <div class="flex items-center mt-4">
                <nav-link :href="route('register')">Регистрация</nav-link>
                <div class="flex-grow"/>
                <primary-button
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >Войти
                </primary-button>
            </div>
        </form>
    </GuestLayout>
</template>
