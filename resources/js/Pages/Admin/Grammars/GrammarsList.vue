<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import CardBlock from "@/Components/CardBlock.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Ln from "@/Components/Navigation/ln.vue";
import {Inertia} from "@inertiajs/inertia";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";

const props = defineProps({
    grammars: {
        type: Array,
        required: false,
        default: [],
    },
});

function onGrammarRemove(grammar) {
    if (!confirm(`Вы действительно хотите удалить грамматику #${grammar.id}`)) {
        return;
    }

    Inertia.delete(route('admin.grammars.remove', grammar.id), {
        preserveScroll: true,
        preserveState: true,
    });
}

</script>

<template>
    <page-title title="Список грамматик"/>

    <admin-layout header="Список грамматик">
        <card-block class="my-4">
            <div class="flex">
                <h3 class="text-lg font-semibold mb-2">Созданные грамматики</h3>
                <div class="flex-grow"></div>
                <ln :href="route('admin.grammars.create')">
                    <primary-button>Создать</primary-button>
                </ln>
            </div>
            <div class="overflow-auto">
                <table class="table min-w-full">
                <thead>
                <tr>
                    <td>№</td>
                    <td>Терминалы</td>
                    <td>Нетерминалы</td>
                    <td>Стартовый нетерминал</td>
                    <td>Кол-во правил</td>
                    <td>Действия</td>
                </tr>
                </thead>
                <tbody>
                <tr
                    v-for="g in grammars"
                    :key="g.id"
                >
                    <td>{{ g.id }}</td>
                    <td>{{ g.terms }}</td>
                    <td>{{ g.non_terms }}</td>
                    <td>{{ g.root_term }}</td>
                    <td>{{ g.rules.reduce((acc, rule) => acc + (rule.rights?.length ?? 0), 0) }}</td>
                    <td class="space-x-2 flex">
                        <ln :href="route('admin.grammars.edit', g.id)">
                            <secondary-button type="button">Изменить</secondary-button>
                        </ln>
                        <danger-button type="button" @click="onGrammarRemove(g)">Удалить</danger-button>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>
        </card-block>
    </admin-layout>
</template>
