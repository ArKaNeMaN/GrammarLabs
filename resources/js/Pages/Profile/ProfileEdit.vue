<template>
    <page-title title="Редактирование профиля"/>

    <authenticated-layout header="Редактирование профиля">
        <card-block class="mt-4">
            <form @submit.prevent="onSubmit" class="md:w-[50%]">
                <form-field label="Имя">
                    <text-input
                        v-model="form.name"
                        placeholder="Введите новое имя"
                        :error="form.errors.name"
                        class="w-full"
                        autofocus
                        autocomplete="name"
                    />
                </form-field>
                <form-field label="Группа">
                    <text-input
                        v-model="form.group_name"
                        placeholder="Введите новое название группы"
                        :error="form.errors.group_name"
                        class="w-full"
                        autocomplete="group"
                    />
                </form-field>

                <form-field label="Пароль" class="mt-4">
                    <text-input
                        v-model="form.password"
                        placeholder="Введите новый пароль"
                        :error="form.errors.password"
                        class="w-full"
                        type="password"
                        autocomplete="new-password"
                    />
                </form-field>
                <form-field label="Подтверждение пароля">
                    <text-input
                        v-model="form.password_confirmation"
                        placeholder="Введите новый пароль ещё раз"
                        :error="form.errors.password_confirmation"
                        class="w-full"
                        type="password"
                        autocomplete="new-password"
                    />
                </form-field>

                <primary-button type="submit" class="mt-4">Сохранить</primary-button>
            </form>
        </card-block>
    </authenticated-layout>
</template>

<script setup>
import {useForm, usePage} from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CardBlock from "@/Components/CardBlock.vue";
import FormField from "@/Components/Form/FormField.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import PageTitle from "@/Components/PageTitle.vue";
import {useToast} from "vue-toastification";

const form = useForm({
    name: usePage().props.value.auth.user.name,
    group_name: usePage().props.value.auth.user.group_name,
    password: '',
    password_confirmation: '',
});

function onSubmit() {
    form.put(route('user.profile.edit.save'), {
        onProgress: () => form.reset('password', 'password_confirmation'),
        onSuccess: () => {
            form.reset('password', 'password_confirmation');
            useToast().success('Профиль успешно обновлён');
        },
    });
}

</script>
