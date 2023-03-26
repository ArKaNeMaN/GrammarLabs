<script setup>
import TableTextRow from "@/Components/Table/TableTextRow.vue";
import TableLayout from "@/Components/Table/TableLayout.vue";
import CardBlock from "@/Components/Card/CardBlock.vue";
import CardHeader from "@/Components/Card/CardHeader.vue";
import {taskTypeFormat} from "@/utils";

const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <card-block class="mt-4">
        <card-header>Задание</card-header>
        <div class="grid md:grid-cols-2 grid-cols-1 w-full gap-4">
            <div>
                <table-layout class="w-full">
                    <tbody>
                    <tr>
                        <td class="font-semibold">Название</td>
                        <td>{{ task.name }}</td>
                    </tr>
                    <tr>
                        <td class="font-semibold">Тип</td>
                        <td>{{ taskTypeFormat(task.type) }}</td>
                    </tr>
                    </tbody>
                </table-layout>
            </div>
            <div>
                <h4 class="font-semibold">Описание</h4>
                <div v-if="task.type === 'reverse'">
                    <p>Для выполнения задания требуется составить такую грамматику, под которую будут подходить указанные ниже цепочки.</p>
                    <table-layout class="w-full mt-4">
                        <tbody>
                        <tr>
                            <td class="font-semibold">Цепочки</td>
                            <td class="break-words">{{ task.params.input_strings.join(', ') }}</td>
                        </tr>
                        </tbody>
                    </table-layout>

                </div>
                <div v-else-if="task.type === 'generate'">
                    <p>Для выполнения задания требуется вывести из заданной ниже грамматики указанное количество цепочек.</p>
                    <table-layout class="w-full mt-4">
                        <tbody>
                        <tr>
                            <td class="font-semibold">Требуемое кол-во цепочек</td>
                            <td>{{ task.params.required_str_count }}</td>
                        </tr>
                        <table-text-row class="font-semibold text-center">Грамматика</table-text-row>
                        <tr>
                            <td class="font-semibold">Терминалы</td>
                            <td>{{ task.params.grammar.terms }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold">Нетерминалы</td>
                            <td>{{ task.params.grammar.non_terms }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold">Стартовый нетерминал</td>
                            <td>{{ task.params.grammar.root_term }}</td>
                        </tr>
                        <table-text-row class="italic text-center">Правила</table-text-row>
                        <table-text-row
                            v-for="rule in task.params.grammar.rules"
                        >
                            {{ rule.left }} -> {{ rule.rights.join(' | ') }}
                        </table-text-row>
                        </tbody>
                    </table-layout>
                </div>
            </div>
        </div>
    </card-block>
</template>
