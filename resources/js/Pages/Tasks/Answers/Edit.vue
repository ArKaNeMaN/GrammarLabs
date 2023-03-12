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
    ...DEFAULT_GENERATION_ANSWER,
    ...DEFAULT_REVERS_ANSWER,
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
            <card-header>Задание</card-header>
            <table-layout class="lg:w-1/3 sm:w-1/2 w-full">
                <tbody>
                <tr>
                    <td class="font-semibold">Задание</td>
                    <td>{{ assignedTask.task.name }}</td>
                </tr>
                <tr>
                    <td class="font-semibold">Тип</td>
                    <td>{{ taskTypeFormat(assignedTask.task.type) }}</td>
                </tr>
                </tbody>
            </table-layout>


        </card-block>
        <form>
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
                                v-model.trim="form.grammar.terms"
                                :error="form.errors['grammar.terms']"
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
                                v-model.trim="form.grammar.non_terms"
                                :error="form.errors['grammar.non_terms']"
                                placeholder="Введите нетерминальные символы без разделителей"
                                required
                            />
                        </form-field>

                        <form-field label="Стартовый нетерминал">
                            <text-input
                                class="w-full"
                                v-model.trim="form.grammar.root_term"
                                :error="form.errors['grammar.root_term']"
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
                            v-model="form.grammar.rules"
                            :error="form.errors['grammar.rules']"
                            class="w-full"
                        />
                    </form-field>
                </template>
                <template v-if="assignedTask.task.type === 'generate'">
                    <form-field
                        label="Входные строки"
                        hint="Строки, соответствующие заданной грамматике"
                    >
                        <text-inputs-list
                            v-model="form.input_strings"
                            :error="form.errors['input_strings']"
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
