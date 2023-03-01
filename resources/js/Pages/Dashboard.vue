<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PageTitle from "@/Components/PageTitle.vue";
import CardBlock from "@/Components/CardBlock.vue";
</script>

<template>
    <page-title title="Главная страница" />

    <authenticated-layout header="Главная страница">
        <card-block class="my-4">
            Главная страница
        </card-block>
    </authenticated-layout>
</template>
