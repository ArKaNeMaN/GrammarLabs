<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageTitle from "@/Components/PageTitle.vue";
import CardBlock from "@/Components/Card/CardBlock.vue";
import CardHeader from "@/Components/Card/CardHeader.vue";
import TableLayout from "@/Components/Table/TableLayout.vue";
import TableSimpleHeader from "@/Components/Table/TableSimpleHeader.vue";
import {dateFormat} from "@/utils";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Ln from "@/Components/Navigation/ln.vue";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import {Inertia} from "@inertiajs/inertia";
import {isEmpty} from "lodash";
import TableTextRow from "@/Components/Table/TableTextRow.vue";

const props = defineProps({
    assignedTasks: {
        type: Array,
        required: false,
        default: [],
    },
    answers: {
        type: Array,
        required: false,
        default: [],
    },
});

function taskStatusFormat(status) {
    return {
        'draft': 'Черновик',
        'auto-rejected': 'Отклонено валидацией',
        'sent': 'Сдано',
        'accepted': 'Принято',
        'rejected': 'Отклонено',
        // 'null': 'Не сдано',
    }[status] ?? 'Не сдано';
}

function sendAnswer(answer) {
    Inertia.put(route('tasks.answers.send', answer.id));
}

</script>

<template>
    <page-title title="Главная страница" />

    <authenticated-layout header="Главная страница">
        <card-block class="mt-4 space-y-2">
            <card-header>Список активных заданий</card-header>
            <table-layout class="w-full">
                <table-simple-header :ths="[
                    'Задание',
                    'Дата выдачи',
                    'Статус',
                    'Действия',
                ]"/>
                <tbody v-if="!isEmpty(assignedTasks)">
                <tr v-for="assignedTask in assignedTasks">
                    <td>{{ assignedTask.task.name }}</td>
                    <td>{{ dateFormat(assignedTask.created_at) }}</td>
                    <td>{{ taskStatusFormat(assignedTask.lastAnswer?.status ?? null) }}</td>
                    <td class="flex space-x-2">
                        <ln :href="route('tasks.answers.new.show', assignedTask.id)">
                            <secondary-button>Новое решение</secondary-button>
                        </ln>
                    </td>
                </tr>
                </tbody>
                <table-text-row
                    v-else
                    class="text-center text-gray-500"
                >Нет назначенных заданий</table-text-row>
            </table-layout>
        </card-block>
        <card-block class="mt-2 space-y-2">
            <card-header>Сохранённые решения</card-header>
            <table-layout class="w-full">
                <table-simple-header :ths="[
                    '№',
                    'Задание',
                    'Дата обновления',
                    'Статус',
                    'Действия',
                ]"/>
                <tbody v-if="!isEmpty(answers)">
                <tr v-for="answer in answers">
                    <td>{{ answer.id }}</td>
                    <td>{{ answer.assigned_task.task.name }}</td>
                    <td>{{ dateFormat(answer.updated_at) }}</td>
                    <td>{{ taskStatusFormat(answer.status) }}</td>
                    <td class="flex space-x-2">
                        <ln :href="route('tasks.answers.edit.show', [answer.assigned_task.id, answer.id])">
                            <secondary-button>Перейти</secondary-button>
                        </ln>
                        <primary-button
                            v-if="answer.status === 'draft'"
                            @click="sendAnswer(answer)"
                        >Сдать</primary-button>
                    </td>
                </tr>
                </tbody>
                <table-text-row
                    v-else
                    class="text-center text-gray-500"
                >Нет сохранённых решений</table-text-row>
            </table-layout>
        </card-block>
    </authenticated-layout>
</template>
