<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {computed} from "vue";
import {isEmpty} from "lodash";
import PageTitle from "@/Components/PageTitle.vue";
import CardBlock from "@/Components/Card/CardBlock.vue";

const props = defineProps({
    assignedTask: {
        type: String,
        required: true,
    },
    answer: {
        type: String,
        required: false,
        default: null,
    },
});

const title = computed(() => {
    return isEmpty(props.answer)
        ? `Новое решение задания '${props.assignedTask.task.name}'`
        : `Редактирование решения №${props.answer.id} задания '${props.assignedTask.task.name}'`;
});
</script>

<template>
    <page-title :title="title"/>
    <authenticated-layout :header="title">
        <card-block class="mt-4">
            
        </card-block>
    </authenticated-layout>
</template>
