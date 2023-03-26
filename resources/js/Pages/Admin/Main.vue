<script setup>
import PageTitle from "@/Components/PageTitle.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CardBlock from "@/Components/Card/CardBlock.vue";
import CardHeader from "@/Components/Card/CardHeader.vue";
import TableLayout from "@/Components/Table/TableLayout.vue";
import TableSimpleHeader from "@/Components/Table/TableSimpleHeader.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import Ln from "@/Components/Navigation/ln.vue";
import {isEmpty} from "lodash";
import TableTextRow from "@/Components/Table/TableTextRow.vue";
import {answerAutoTestResultFormat, taskTypeFormat} from "@/utils";

const props = defineProps({
    sentAnswers: {
        type: Array,
        required: false,
        default: [],
    },
    acceptedAnswers: {
        type: Array,
        required: false,
        default: [],
    },
});
</script>

<template>
    <page-title title="Админка"/>

    <admin-layout header="Админка">
        <card-block class="mt-4">
            <card-header>Задания на проверку</card-header>
            <div class="overflow-auto mt-2">
                <table-layout class="w-full">
                    <table-simple-header :ths="[
                        'Студент',
                        'Задание',
                        '№ решения',
                        'Статус авто-проверки',
                        'Действия',
                    ]"/>
                    <tbody v-if="!isEmpty(sentAnswers)">
                    <tr v-for="answer in sentAnswers" :key="answer.id">
                        <td>{{ answer.assigned_task.user.name }} ({{ answer.assigned_task.user.group_name }})</td>
                        <td>{{ answer.assigned_task.task.name }} ({{ answer.assigned_task.task.type }})</td>
                        <td>{{ answer.id }}</td>
                        <td>{{ answerAutoTestResultFormat(answer.auto_test_result) }}</td>
                        <td>
                            <ln :href="route('admin.answers.show', answer.id)">
                                <primary-button>Перейти</primary-button>
                            </ln>
                        </td>
                    </tr>
                    </tbody>
                    <table-text-row v-else class="text-center text-gray-500">
                        Решения не найдены
                    </table-text-row>
                </table-layout>
            </div>
        </card-block>
        <card-block class="mt-2">
            <card-header>Зачтённые задания</card-header>
            <div class="overflow-auto mt-2">
                <table-layout class="w-full">
                    <table-simple-header :ths="[
                        'Группа',
                        'Студент',
                        'Задание',
                        'Тип задания',
                    ]"/>
                    <tbody v-if="!isEmpty(acceptedAnswers)">
                    <tr v-for="answer in acceptedAnswers" :key="answer.id">
                        <td>{{ answer.assigned_task.user.group_name }}</td>
                        <td>{{ answer.assigned_task.user.name }}</td>
                        <td>{{ answer.assigned_task.task.name }}</td>
                        <td>{{ taskTypeFormat(answer.assigned_task.task.type) }}</td>
                    </tr>
                    </tbody>
                    <table-text-row v-else class="text-center text-gray-500">
                        Решения не найдены
                    </table-text-row>
                </table-layout>
            </div>
        </card-block>
    </admin-layout>
</template>
