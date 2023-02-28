<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed} from "vue";
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

const props = defineProps({
    grammar: {
        type: Object,
        required: false,
        default: null,
    },
});

const form = useForm(props.grammar ?? {
    terms: '',
    non_terms: 'S',
    rules: [
        {
            left: 'S',
            rights: [''],
        },
    ],
    root_term: 'S',
});

const headerText = computed(() => isEmpty(props.grammar) ? 'Создание грамматики' : `Редактирование грамматики №${props.grammar.id}`);

function onSubmit() {
    if (isEmpty(props.grammar)) {
        form.post(route('admin.grammars.create'));
    } else {
        form.put(route('admin.grammars.edit', props.grammar.id));
    }
}

function removeArrayItem(arr, index) {
    let res = [...arr];
    res.splice(index, 1);
    return res;
}
</script>

<template>
    <page-title :title="headerText"/>

    <authenticated-layout :header="headerText">
        <card-block class="mt-4">
            <ln :href="route('admin.grammars.list.show')">
                <secondary-button>← К списку грамматик</secondary-button>
            </ln>
        </card-block>
        <form @submit.prevent="onSubmit">
            <card-block class="mt-4">
                <h3 class="text-lg font-semibold mb-2">Параметры</h3>

                <div class="space-y-4">
                    <form-field label="Терминалы">
                        <text-input
                            class="w-full"
                            v-model.trim="form.terms"
                            :error="form.errors.terms"
                            placeholder="Введите терминальные символы без разделителей"
                            required
                            autofocus
                        />
                    </form-field>

                    <form-field label="Нетерминалы">
                        <text-input
                            class="w-full"
                            v-model.trim="form.non_terms"
                            :error="form.errors.non_terms"
                            placeholder="Введите нетерминальные символы без разделителей"
                            required
                        />
                    </form-field>

                    <form-field label="Стартовый нетерминал">
                        <text-input
                            class="w-full"
                            v-model.trim="form.root_term"
                            :error="form.errors.root_term"
                            placeholder="Введите стартовый нетерминальный символ"
                            required
                            maxlength="1"
                        />
                    </form-field>
                </div>
            </card-block>
            <card-block class="mt-4">
                <h3 class="text-lg font-semibold mb-2">Правила</h3>

                <p class="text-gray-500">Символ <code>-</code> в правой части означает пустую строку</p>

                <div class="space-y-4">
                    <div
                        v-for="(ignored__rule, i) in form.rules"
                        class="flex items-center"
                    >
                        <div class="flex">
                            <secondary-button
                                class="rounded-r-none"
                                @click="form.rules = removeArrayItem(form.rules, i)"
                            >-</secondary-button>
                            <text-input v-model.trim="form.rules[i].left" class="w-32 rounded-l-none border-l-0"/>
                        </div>
                        <code> → </code>
                        <text-inputs-list v-model="form.rules[i].rights" input-class="w-32" separator="|"/>
                    </div>
                    <secondary-button @click="form.rules.push({left: '', rights: ['']})">Добавить</secondary-button>
                </div>

                <p v-if="!isEmpty(form.errors.rules)" class="text-sm text-red-600 mt-0.5">{{ form.errors.rules }}</p>
            </card-block>
            <card-block class="my-4">
                <primary-button type="submit" class="float-right">Сохранить</primary-button>
            </card-block>
        </form>
    </authenticated-layout>
</template>

