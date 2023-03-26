<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CardBlock from "@/Components/Card/CardBlock.vue";
import PageTitle from "@/Components/PageTitle.vue";
import {computed} from "vue";
import CardHeader from "@/Components/Card/CardHeader.vue";
import TaskCard from "@/Components/TaskCard.vue";
import TableTextRow from "@/Components/Table/TableTextRow.vue";
import TableLayout from "@/Components/Table/TableLayout.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import DangerButton from "@/Components/Buttons/DangerButton.vue";
import {Inertia} from "@inertiajs/inertia";
import FlexGrow from "@/Components/FlexGrow.vue";

const props = defineProps({
    answer: {
        type: Object,
        required: true,
    },
});

const title = computed(() => {
    return `Решение №${props.answer.id} студента '${props.answer.assigned_task.user.name}'`;
});

function onAccept() {
    if (!confirm('Вы действительно хотите принять это решение? Это действие нельзя будет отменить.')) {
        return;
    }

    Inertia.put(route('admin.answers.accept', [props.answer.id]));
}

function onReject() {
    if (!confirm('Вы действительно хотите отклонить это решение? Это действие нельзя будет отменить.')) {
        return;
    }

    Inertia.put(route('admin.answers.reject', [props.answer.id]));
}
</script>

<template>
    <page-title :title="title"/>
    <admin-layout>
        <task-card class="mt-4" :task="answer.assigned_task.task"/>
        <card-block class="mt-2">
            <card-header>{{ title }}</card-header>
            <div>
                <div v-if="answer.assigned_task.task.type === 'generate'">
                    <table-layout class="w-full mt-4">
                        <tbody>
                        <tr>
                            <td class="font-semibold">Цепочки</td>
                            <td class="break-words">{{ answer.answer.input_strings.join(', ') }}</td>
                        </tr>
                        </tbody>
                    </table-layout>

                </div>
                <div v-else-if="answer.assigned_task.task.type === 'reverse'">
                    <table-layout class="w-full mt-4">
                        <tbody>
                        <tr>
                            <td class="font-semibold">Стартовый нетерминал</td>
                            <td>{{ answer.answer.grammar.root_term }}</td>
                        </tr>
                        <table-text-row class="italic text-center">Правила</table-text-row>
                        <table-text-row
                            v-for="rule in answer.answer.grammar.rules"
                        >
                            {{ rule.left }} -> {{ rule.rights.join(' | ') }}
                        </table-text-row>
                        </tbody>
                    </table-layout>
                </div>
            </div>
        </card-block>
        <card-block class="mt-2">
            <div class="flex space-x-2">
                <danger-button @click="onReject">Отклонить решение</danger-button>
                <flex-grow/>
                <primary-button @click="onAccept">Принять решение</primary-button>
            </div>
        </card-block>
    </admin-layout>
</template>
