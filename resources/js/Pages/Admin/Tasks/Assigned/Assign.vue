<template>
    <page-title title="Назначение задания"/>

    <admin-layout>
        <form @submit.prevent="onSubmit">
            <card-block class="mt-4 space-y-4">
                <form-field label="Студент" hint="Студент, которому будет выдано задание">
                    <select-input v-model="form.user_id" required>
                        <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }} ({{ user.group_name }})</option>
                    </select-input>
                </form-field>

                <form-field label="Задание" hint="Выдаваемое задание">
                    <select-input v-model="form.task_id" required>
                        <option v-for="task in tasks" :key="task.id" :value="task.id">{{ task.name }} ({{ formatTaskType(task.type) }})</option>
                    </select-input>
                </form-field>
            </card-block>
            <card-block class="flex justify-between mt-2">
                <label class="space-x-2 flex items-center">
                    <checkbox v-model:checked="form.preserve_page" />
                    <span>Остаться на этой странице</span>
                </label>
                <primary-button type="submit">Выдать</primary-button>
            </card-block>
        </form>
    </admin-layout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import CardBlock from "@/Components/CardBlock.vue";
import FormField from "@/Components/Form/FormField.vue";
import SelectInput from "@/Components/Form/SelectInput.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Checkbox from "@/Components/Form/Checkbox.vue";

const props = defineProps({
    users: {
        type: Array,
        required: true,
    },
    tasks: {
        type: Array,
        required: true,
    },
});

function formatTaskType(type) {
    return {
        generate: 'Генерация',
        reverse: 'Реверс',
        null: '?',
    }[type ?? 'null'];
}

const form = useForm({
    user_id: null,
    task_id: null,
    preserve_page: true,
});

function onSubmit() {
    form.post(route('admin.assigned-tasks.assign.show'));
}
</script>
