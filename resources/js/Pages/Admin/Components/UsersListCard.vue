<template>
    <card-block>
        <form
            v-if="withSearch"
            class="flex items-center"
            @submit.prevent="load"
        >
            <text-input
                v-model.trim="search"
                placeholder="Введите поисковой запрос"
                class="flex-grow rounded-r-none"
            />
            <secondary-button
                v-if="!isEmpty(search)"
                type="button"
                class="rounded-none border-x-0"
                @click="search = ''"
            >x</secondary-button>
            <primary-button
                type="submit"
                class="rounded-l-none"
            >Найти</primary-button>
        </form>

        <div class="overflow-auto mt-2">
            <table class="table w-full">
                <thead>
                <tr>
                    <th>№</th>
                    <th>Имя</th>
                    <th>Логин</th>
                    <th>Роль</th>
                    <th>Дата регистрации</th>
                    <th v-if="withActions">
                        Действия
                    </th>
                </tr>
                </thead>
                <tbody v-if="!isEmpty(users.data)">
                <tr v-for="user in users.data" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.login }}</td>
                    <td>{{ USER_ROLES_MAP[user.role] ?? '???' }}</td>
                    <td>{{ dateFormat(user.created_at) }}</td>
                    <td v-if="withActions" class="flex space-x-2">
                        <secondary-button @click="onUserChangeName(user)">Имя</secondary-button>
                        <secondary-button @click="onUserChangePass(user)">Пароль</secondary-button>
                        <danger-button @click="onUserRemove(user)">Удалить</danger-button>
                    </td>
                </tr>
                </tbody>
                <tr v-else>
                    <td class="text-center" colspan="999">
                        Пользователи не найдены
                    </td>
                </tr>
            </table>
        </div>

        <pagination
            :data="users"
            v-model:page="page"
            class="w-full mt-2"
        />
    </card-block>
</template>

<script setup>
import CardBlock from "@/Components/Card/CardBlock.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import {onMounted, ref, watch} from "vue";
import axios from "axios";
import {dateFormat} from "@/utils";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import {isEmpty} from "lodash";
import Pagination from "@/Components/Navigation/Pagination.vue";
import {useToast} from "vue-toastification";

const props = defineProps({
    withSearch: {
        type: Boolean,
        required: false,
        default: false,
    },
    withActions: {
        type: Boolean,
        required: false,
        default: false,
    },
});
const toast = useToast();

const USER_ROLES_MAP = {
    admin: 'Администратор',
    student: 'Студент',
};

const users = ref({});
onMounted(() => {
    load();
});

const page = ref(1);
const search = ref('');

async function load() {
    users.value = (await axios.get(route('admin.users.list', {
        search: search.value,
        page: page.value,
    }))).data;
}

watch(page, load);

async function onUserRemove(user) {
    if (!confirm(`Вы действительно хотите удалить пользователя '${user.name}' (№${user.id})?`)) {
        return;
    }

    await axios.delete(route('admin.users.list.remove-user', user.id)).then(() => {
        toast.success('Пользователь успешно удалён');
    }).catch(() => {
        toast.success('При удалении пользователя произошла ошибка');
    });

    await load();
}

async function onUserChangePass(user) {
    const password = prompt('Введите новый пароль:');
    if (isEmpty(password)) {
        return;
    }

    await axios.put(route('admin.users.list.change-user-pass', user.id), {password}).then(() => {
        toast.success('Пароль пользователя успешно изменён');
    }).catch(() => {
        toast.success('При изменении пароля пользователя произошла ошибка');
    });
}

async function onUserChangeName(user) {
    const name = prompt('Введите новое имя:', user.name);
    if (isEmpty(name)) {
        return;
    }

    await axios.put(route('admin.users.list.change-user-name', user.id), {name}).then(() => {
        toast.success('Имя пользователя успешно изменено');
    }).catch(() => {
        toast.success('При изменении имени пользователя произошла ошибка');
    });

    await load();
}

</script>
