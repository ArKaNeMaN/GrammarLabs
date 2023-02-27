<template>
    <authenticated-layout>
        <card-block class="mt-4">
            <h3 class="font-semibold text-lg">Панель управления</h3>

            <div class="mt-2 flex flex-wrap space-x-2">
                <ln
                    v-for="item in ADMIN_MENU_ITEMS"
                    :href="route(item.route)"
                >
                    <primary-button :disabled="route().current(item.route)">
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
import CardBlock from "@/Components/CardBlock.vue";
import UsersListCard from "@/Pages/Admin/Components/UsersListCard.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Ln from "@/Components/Navigation/ln.vue";

const props = defineProps({
    header: {
        type: String,
        required: false,
        default: null,
    }
});

const ADMIN_MENU_ITEMS = [
    {
        title: 'Список пользователей',
        route: 'admin.users.list.show',
    },
    {
        title: 'Список грамматик',
        route: 'admin.grammars.list.show',
    },
];
</script>
