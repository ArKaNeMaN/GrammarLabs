<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import CardBlock from "@/Components/Card/CardBlock.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import Pagination from "@/Components/Navigation/Pagination.vue";
import {Inertia} from "@inertiajs/inertia";
import {isEmpty} from "lodash";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Ln from "@/Components/Navigation/ln.vue";
import {dateFormat} from "@/utils";
import CardHeader from "@/Components/Card/CardHeader.vue";

const props = defineProps({
    assignedTasks: {
        type: Object,
        required: true,
    },
});

function formatStatus(status) {
    return {
        'draft': 'Черновик',
        'auto-rejected': 'Отклонено валидацией',
        'sent': 'Сдано',
        'accepted': 'Принято',
        'rejected': 'Отклонено',
        // 'null': 'Не сдано',
    }[status] ?? 'Не сдано';
}

function getTaskStatus(assignedTask) {
    if (!assignedTask.answers?.length) {
        return null;
    }

    return assignedTask.answers[assignedTask.answers.length - 1]?.status ?? null;
}

function cancelTask(assignedTask) {
    if (!confirm(`Вы действительно хотите отменить задание '${assignedTask.task.name}' для студента '${assignedTask.user.name}'?`)) {
        return;
    }

    Inertia.delete(route('admin.assigned-tasks.list.cancel-task', assignedTask.id));
}

</script>

<template>
    <page-title title="Список выданных заданий"/>

    <admin-layout>
        <card-block class="mt-4">
            <card-header>
                Список выданных заданий
                <template #right>
                    <ln :href="route('admin.assigned-tasks.assign.show')">
                        <primary-button>Выдать новое задание</primary-button>
                    </ln>
                </template>
            </card-header>

            <div class="overflow-auto">
                <table class="table w-full mt-2">
                    <thead>
                    <tr>
                        <td>Пользователь</td>
                        <td>Задание</td>
<!--                        <td>Кол-во решений</td>-->
                        <td title="Статус последнего решения">Статус</td>
                        <td>Дата выдачи</td>
                        <td>Действия</td>
                    </tr>
                    </thead>
                    <tbody v-if="!isEmpty(assignedTasks.data)">
                    <tr v-for="task in assignedTasks.data" :key="task.id">
                        <td>{{ task.user.name }}</td>
                        <td>{{ task.task.name }}</td>
<!--                        <td>{{ task.answers.length }}</td>-->
                        <td>{{ formatStatus(getTaskStatus(task)) }}</td>
                        <td>{{ dateFormat(task.created_at) }}</td>
                        <td class="flex">
                            <danger-button @click="cancelTask(task)">Отменить</danger-button>
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
