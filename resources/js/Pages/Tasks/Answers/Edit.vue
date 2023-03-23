<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed} from "vue";
import {isEmpty} from "lodash";
import PageTitle from "@/Components/PageTitle.vue";
import CardBlock from "@/Components/Card/CardBlock.vue";
import PrimaryButton from "@/Components/Buttons/PrimaryButton.vue";
import FlexGrow from "@/Components/FlexGrow.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import FormField from "@/Components/Form/FormField.vue";
import TextInputsList from "@/Components/Form/TextInputsList.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import GrammarRulesInput from "@/Components/Form/GrammarRulesInput.vue";
import CardHeader from "@/Components/Card/CardHeader.vue";
import CardLoadingIndicator from "@/Components/Card/CardLoadingIndicator.vue";
import TableLayout from "@/Components/Table/TableLayout.vue";
import Ln from "@/Components/Navigation/ln.vue";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import TableTextRow from "@/Components/Table/TableTextRow.vue";

const props = defineProps({
    assignedTask: {
        type: Object,
        required: true,
    },
    answer: {
        type: Object,
        required: false,
        default: null,
    },
});

const title = computed(() => {
    return isEmpty(props.answer)
        ? `Новое решение задания '${props.assignedTask.task.name}'`
        : `Редактирование решения №${props.answer.id} задания '${props.assignedTask.task.name}'`;
});

const DEFAULT_GENERATION_ANSWER = {
    input_strings: [],
};

const DEFAULT_REVERS_ANSWER = {
    grammar: {
        terms: '',
        non_terms: 'S',
        rules: [
            {
                left: 'S',
                rights: [''],
            },
        ],
        root_term: 'S',
    },
};

const form = useForm({
    ...props.answer,
    answer: {
        ...DEFAULT_GENERATION_ANSWER,
        ...DEFAULT_REVERS_ANSWER,
        ...props.answer?.answer,
    },
});

function onSubmit() {
    if (isEmpty(props.answer)) {
        form.post(route('tasks.answers.new', props.assignedTask.id));
    } else {
        form.put(route('tasks.answers.edit', [props.assignedTask.id, props.answer.id]));
    }
}

function taskTypeFormat(type) {
    return {
        generate: 'Генерация',
        reverse: 'Реверс',
    }[type] ?? '?';
}

</script>

<template>
    <page-title :title="title"/>
    <authenticated-layout :header="title">
        <card-block class="mt-4">
            <ln :href="route('dashboard')">
                <secondary-button>← На главную</secondary-button>
            </ln>
        </card-block>

        <card-block class="mt-4">
            <card-header>Задание</card-header>
            <div class="grid md:grid-cols-2 grid-cols-1 w-full gap-4">
                <div>
                    <table-layout class="w-full">
                        <tbody>
                        <tr>
                            <td class="font-semibold">Название</td>
                            <td>{{ assignedTask.task.name }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold">Тип</td>
                            <td>{{ taskTypeFormat(assignedTask.task.type) }}</td>
                        </tr>
                        </tbody>
                    </table-layout>
                </div>
                <div>
                    <h4 class="font-semibold">Описание</h4>
                    <div v-if="assignedTask.task.type === 'reverse'">
                        <p>Для выполнения задания требуется составить такую грамматику, под которую будут подходить указанные ниже цепочки.</p>
                        <table-layout class="w-full mt-4">
                            <tbody>
                            <tr>
                                <td class="font-semibold">Цепочки</td>
                                <td class="break-words">{{ assignedTask.task.params.input_strings.join(', ') }}</td>
                            </tr>
                            </tbody>
                        </table-layout>

                    </div>
                    <div v-else-if="assignedTask.task.type === 'generate'">
                        <p>Для выполнения задания требуется вывести из заданной ниже грамматики указанное количество цепочек.</p>
                        <table-layout class="w-full mt-4">
                            <tbody>
                            <tr>
                                <td class="font-semibold">Требуемое кол-во цепочек</td>
                                <td>{{ assignedTask.task.params.required_str_count }}</td>
                            </tr>
                            <table-text-row class="font-semibold text-center">Грамматика</table-text-row>
                            <tr>
                                <td class="font-semibold">Терминалы</td>
                                <td>{{ assignedTask.task.params.grammar.terms }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Нетерминалы</td>
                                <td>{{ assignedTask.task.params.grammar.non_terms }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold">Стартовые нетерминал</td>
                                <td>{{ assignedTask.task.params.grammar.root_term }}</td>
                            </tr>
                            <table-text-row class="italic text-center">Правила</table-text-row>
                            <table-text-row
                                v-for="rule in assignedTask.task.params.grammar.rules"
                            >
                                {{ rule.left }} -> {{ rule.rights.join(' | ') }}
                            </table-text-row>
                            </tbody>
                        </table-layout>
                    </div>
                </div>
            </div>
        </card-block>


        <form @submit.prevent="onSubmit">
            <card-block class="mt-2 space-y-4">
                <card-header>Решение</card-header>
                <card-loading-indicator :loading="form.processing"/>

                <template v-if="assignedTask.task.type === 'reverse'">
                    <div>
                        <form-field
                            label="Терминалы"
                            hint="Без разделителей и пробелов"
                        >
                            <text-input
                                class="w-full"
                                v-model.trim="form.answer.grammar.terms"
                                :error="form.errors['answer.grammar.terms']"
                                placeholder="Введите терминальные символы без разделителей"
                                required
                            />
                        </form-field>

                        <form-field
                            label="Нетерминалы"
                            hint="Без разделителей и пробелов"
                        >
                            <text-input
                                class="w-full"
                                v-model.trim="form.answer.grammar.non_terms"
                                :error="form.errors['answer.grammar.non_terms']"
                                placeholder="Введите нетерминальные символы без разделителей"
                                required
                            />
                        </form-field>

                        <form-field label="Стартовый нетерминал">
                            <text-input
                                class="w-full"
                                v-model.trim="form.answer.grammar.root_term"
                                :error="form.errors['answer.grammar.root_term']"
                                placeholder="Введите стартовый нетерминальный символ"
                                required
                                maxlength="1"
                            />
                        </form-field>
                    </div>

                    <hr>

                    <form-field
                        label="Правила"
                        hint="Символ '-' в правой части означает пустую строку"
                    >
                        <grammar-rules-input
                            v-model="form.answer.grammar.rules"
                            :error="form.errors['answer.grammar.rules']"
                            class="w-full"
                        />
                    </form-field>
                </template>
                <template v-if="assignedTask.task.type === 'generate'">
                    <form-field
                        label="Выведенные цепочки"
                        hint="Цепочки, соответствующие заданной грамматике"
                    >
                        <text-inputs-list
                            v-model="form.answer.input_strings"
                            :error="form.errors['answer.input_strings']"
                        />
                    </form-field>
                </template>
            </card-block>

            <card-block class="flex space-x-2 mt-2">
                <card-loading-indicator :loading="form.processing"/>
                <flex-grow/>
<!--                <secondary-button-->
<!--                    v-if="!isEmpty(answer)"-->
<!--                    type="button"-->
<!--                    @click="onSaveAndSend"-->
<!--                >Сохранить и отправить</secondary-button>-->
                <primary-button
                    type="submit"
                >Сохранить</primary-button>
            </card-block>
        </form>
    </authenticated-layout>
</template>
