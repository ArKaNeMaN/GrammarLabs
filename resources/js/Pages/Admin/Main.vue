<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PageTitle from "@/Components/PageTitle.vue";
import CardBlock from "@/Components/CardBlock.vue";

</script>

<template>
    <page-title title="Админка"/>

    <authenticated-layout header="Админка">
        <card-block class="my-4">
            Админка
        </card-block>
    </authenticated-layout>
</template>
