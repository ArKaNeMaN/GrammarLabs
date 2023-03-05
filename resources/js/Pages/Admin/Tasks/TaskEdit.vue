<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed, watch} from "vue";
import {useForm} from "@inertiajs/inertia-vue3";
import {isEmpty} from "lodash";
import CardBlock from "@/Components/CardBlock.vue";
import FormField from "@/Components/Form/FormField.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInputsList from "@/Components/Form/TextInputsList.vue";
import Ln from "@/Components/Navigation/ln.vue";
import PageTitle from "@/Components/PageTitle.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import NumberInput from "@/Components/Form/NumberInput.vue";
import GrammarRulesInput from "@/Components/Form/GrammarRulesInput.vue";

const props = defineProps({
    task: {
        type: Object,
        required: false,
        default: null,
    },
});

const DEFAULT_GENERATION_PARAMS = {
    required_str_count: 5,
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

const DEFAULT_REVERS_PARAMS = {
    input_strings: [],
};

const form = useForm({
    name: 'Вариант №',
    type: 'generate',
    ...props.task,
    params: {
        ...DEFAULT_REVERS_PARAMS,
        ...DEFAULT_GENERATION_PARAMS,
        ...props.task?.params ?? {},
    },
});

watch(form, () => {
    console.log(form)
}, {deep: true});

const headerText = computed(() =>
    isEmpty(props.task)
        ? 'Создание задания'
        : `Редактирование задания '${props.task.name}'`
);

function onSubmit() {
    if (isEmpty(props.task)) {
        form.post(route('admin.tasks.create'));
    } else {
        form.put(route('admin.tasks.edit', props.task.id));
    }
}

const TASK_TYPES = [
    'generate',
    'reverse'
];

function formatTaskType(type) {
    return {
        generate: 'Генерация',
        reverse: 'Реверс',
        null: '?',
    }[type ?? 'null'];
}
</script>

<template>
    <page-title :title="headerText"/>

    <authenticated-layout :header="headerText">
        <card-block class="mt-4">
            <ln :href="route('admin.tasks.list.show')">
                <secondary-button>← К списку заданий</secondary-button>
            </ln>
        </card-block>
        <form @submit.prevent="onSubmit">
            <card-block class="mt-4">
                <form-field label="Название" class="mb-6">
                    <text-input
                        class="w-full"
                        v-model.trim="form.name"
                        :error="form.errors.name"
                        placeholder="Введите название грамматики"
                        required
                        autofocus
                    />
                </form-field>
                <form-field label="Тип задания" class="mb-6">
                    <select-input
                        class="w-full"
                        v-model="form.type"
                        :error="form.errors.name"
                        required
                    >
                        <option
                            v-for="type in TASK_TYPES"
                            :key="type"
                            :value="type"
                        >{{ formatTaskType(type) }}
                        </option>
                    </select-input>
                </form-field>

            </card-block>

            <card-block class="mt-4" v-if="form.type === 'generate'">

                <div class="space-y-4">

                    <form-field
                        label="Кол-во входных строк"
                        hint="Сколько подходящих строк должен будет ввести студент для выполнения задания"
                    >
                        <number-input
                            class="w-full"
                            v-model.n.number="form.params.required_str_count"
                            :error="form.errors['params.required_str_count']"
                            placeholder="Введите количество входных строк"
                            required
                        />
                    </form-field>

                    <hr class="my-4">

                    <form-field
                        label="Терминалы"
                        hint="Без разделителей и пробелов"
                    >
                        <text-input
                            class="w-full"
                            v-model.trim="form.params.grammar.terms"
                            :error="form.errors['params.grammar.terms']"
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
                            v-model.trim="form.params.grammar.non_terms"
                            :error="form.errors['params.grammar.non_terms']"
                            placeholder="Введите нетерминальные символы без разделителей"
                            required
                        />
                    </form-field>

                    <form-field label="Стартовый нетерминал">
                        <text-input
                            class="w-full"
                            v-model.trim="form.params.grammar.root_term"
                            :error="form.errors['params.grammar.root_term']"
                            placeholder="Введите стартовый нетерминальный символ"
                            required
                            maxlength="1"
                        />
                    </form-field>
                </div>

                <hr class="my-4">

                <form-field
                    label="Правила"
                    hint="Символ '-' в правой части означает пустую строку"
                >
                    <grammar-rules-input
                        v-model="form.params.grammar.rules"
                        :error="form.errors['params.grammar.rules']"
                        class="w-full"
                    />
                </form-field>
            </card-block>
            <card-block class="mt-4" v-else-if="form.type === 'reverse'">
                <form-field
                    label="Входные строки"
                    hint="Какие строки должна будет валидировать грамматика, заданная студентом"
                >
                    <text-inputs-list
                        v-model="form.params.input_strings"
                        :error="form.errors['params.input_strings']"
                    />
                </form-field>
            </card-block>

            <card-block class="my-4">
                <primary-button type="submit" class="float-right">Сохранить</primary-button>
            </card-block>
        </form>
    </authenticated-layout>
</template>

