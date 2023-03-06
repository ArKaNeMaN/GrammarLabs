<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import CardBlock from "@/Components/CardBlock.vue";
import DangerButton from "@/Components/DangerButton.vue";
import Pagination from "@/Components/Navigation/Pagination.vue";
import {Inertia} from "@inertiajs/inertia";
import {isEmpty} from "lodash";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    assignedTasks: {
        type: Object,
        required: true,
    },
});

function formatStatus(status) {
    return {
        'null': '-',
    }[status ?? 'null'];
}

function getTaskStatus(assignedTask) {
    if (!assignedTask.answers?.length) {
        return null;
    }

    return assignedTask.answers[assignedTask.answers.length - 1]?.status ?? null;
}

</script>

<template>
    <page-title title="Список выданных заданий"/>

    <admin-layout>
        <card-block class="mt-4">
            <div class="flex md:flex-row flex-col">
                <h3 class="text-lg font-semibold">Список выданных заданий</h3>
                <div class="flex-grow"></div>
                <primary-button>Выдать новое задание</primary-button>
            </div>

            <div class="overflow-auto">
                <table class="table w-full mt-2">
                    <thead>
                    <tr>
                        <td>Пользователь</td>
                        <td>Задание</td>
                        <td>Кол-во решений</td>
                        <td title="Статус последнего решения">Статус</td>
                        <td>Дата выдачи</td>
                        <td>Действия</td>
                    </tr>
                    </thead>
                    <tbody v-if="!isEmpty(assignedTasks.data)">
                    <tr v-for="task in assignedTasks.data" :key="task.id">
                        <td>{{ task.user.name }}</td>
                        <td>{{ task.task.name }}</td>
                        <td>{{ task.answers.length }}</td>
                        <td>{{ formatStatus(getTaskStatus(task)) }}</td>
                        <td>{{ task.user.name }}</td>
                        <td class="flex">
                            <danger-button>Отменить</danger-button>
                        </td>
                    </tr>
                    </tbody>
                    <tr v-else>
                        <td class="text-center" colspan="999">Выданные задания не найдены</td>
                    </tr>
                </table>
            </div>

            <pagination
                class="mt-2"
                @update:page="Inertia.visit(`?page=${$event}`)"
                :data="assignedTasks"
            />
        </card-block>
    </admin-layout>
</template>
