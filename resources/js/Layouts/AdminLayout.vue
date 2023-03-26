<template>
    <authenticated-layout>
        <card-block class="mt-4">
            <h3 class="font-semibold text-lg">Панель управления</h3>

            <div class="mt-2 flex flex-wrap">
                <ln
                    v-for="item in ADMIN_MENU_ITEMS"
                    :href="route(item.route)"
                    class="m-1 sm:w-auto w-full"
                >
                    <primary-button
                        :disabled="route().current(item.route)"
                        class="w-full"
                    >
                        {{ item.title }}
                    </primary-button>
                </ln>
            </div>
        </card-block>
        <slot/>
    </authenticated-layout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CardBlock from "@/Components/Card/CardBlock.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Ln from "@/Components/Navigation/ln.vue";

const props = defineProps({
    header: {
        type: String,
        required: false,
        default: null,
    },
});

const ADMIN_MENU_ITEMS = [
    {
        title: 'Главная',
        route: 'admin.main',
    },
    {
        title: 'Пользователи',
        route: 'admin.users.list.show',
    },
    {
        title: 'Варианты заданий',
        route: 'admin.tasks.list.show',
    },
    {
        title: 'Выданные задания',
        route: 'admin.assigned-tasks.list.show',
    },
];
</script>
