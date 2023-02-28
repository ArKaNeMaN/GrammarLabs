<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/Form/TextInput.vue';
import {useForm} from '@inertiajs/inertia-vue3';
import PageTitle from "@/Components/PageTitle.vue";
import FormField from "@/Components/Form/FormField.vue";
import NavLink from "@/Components/Navigation/NavLink.vue";

const form = useForm({
    name: '',
    group_name: '',
    login: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <guest-layout>
        <page-title title="Регистрация"/>

        <form @submit.prevent="submit">
            <form-field label="Имя">
                <text-input
                    type="text"
                    v-model="form.name"
                    class="w-full"
                    required
                    autofocus
                    autocomplete="name"
                    :error="form.errors.name"
                />
            </form-field>
            <form-field label="Группа">
                <text-input
                    type="text"
                    v-model="form.group_name"
                    class="w-full"
                    required
                    autofocus
                    autocomplete="group"
                    :error="form.errors.group_name"
                    placeholder="Введите название учебной группы"
                />
            </form-field>
            <form-field label="Логин">
                <text-input
                    type="text"
                    v-model="form.login"
                    class="w-full"
                    required
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
                    autocomplete="new-password"
                    :error="form.errors.password"
                />
            </form-field>
            <form-field label="Подтверждение пароля">
                <text-input
                    type="password"
                    v-model="form.password_confirmation"
                    class="w-full"
                    required
                    autocomplete="new-password"
                    :error="form.errors.password_confirmation"
                />
            </form-field>

            <div class="flex items-center mt-4">
                <nav-link :href="route('login')">Вход</nav-link>
                <div class="flex-grow"/>
                <primary-button
                    class="ml-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >Зарегистрироваться
                </primary-button>
            </div>
        </form>
    </guest-layout>
</template>
