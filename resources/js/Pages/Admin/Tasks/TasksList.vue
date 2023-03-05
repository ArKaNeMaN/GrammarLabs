<script setup>
import PageTitle from "@/Components/PageTitle.vue";
import CardBlock from "@/Components/CardBlock.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Ln from "@/Components/Navigation/ln.vue";
import {Inertia} from "@inertiajs/inertia";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import {dateFormat} from "@/utils";

const props = defineProps({
    tasks: {
        type: Array,
        required: false,
        default: [],
    },
});

function onTaskRemove(task) {
    if (!confirm(`Вы действительно хотите удалить задание ${task.name} (#${task.id})`)) {
        return;
    }

    Inertia.delete(route('admin.tasks.remove', task.id), {
        preserveScroll: true,
        preserveState: true,
    });
}

function formatTaskType(type) {
    return {
        generate: 'Генерация',
        reverse: 'Реверс',
        null: '?',
    }[type ?? 'null'];
}

</script>

<template>
    <page-title title="Список грамматик"/>

    <admin-layout header="Список грамматик">
        <card-block class="my-4">
            <div class="flex sm:flex-row flex-col">
                <h3 class="text-lg font-semibold mb-2">Список вариантов заданий</h3>
                <div class="flex-grow"></div>
                <ln :href="route('admin.tasks.create')">
                    <primary-button>Создать</primary-button>
                </ln>
            </div>
            <div class="overflow-auto">
                <table class="table min-w-full">
                <thead>
                <tr>
                    <td>№</td>
                    <td>Название</td>
                    <td>Тип</td>
                    <td>Дата создания</td>
                    <td>Дата обновления</td>
                    <td>Действия</td>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="task in tasks"
                    :key="task.id"
                >
                    <td>{{ task.id }}</td>
                    <td>{{ task.name }}</td>
                    <td>{{ formatTaskType(task.type) }}</td>
                    <td>{{ dateFormat(task.created_at) }}</td>
                    <td>{{ dateFormat(task.updated_at) }}</td>
                    <td class="space-x-2 flex">
                        <ln :href="route('admin.tasks.edit', task.id)">
                            <secondary-button type="button">Изменить</secondary-button>
                        </ln>
                        <danger-button type="button" @click="onTaskRemove(task)">Удалить</danger-button>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>
        </card-block>
    </admin-layout>
</template>
