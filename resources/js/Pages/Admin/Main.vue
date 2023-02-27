<script setup>
import PageTitle from "@/Components/PageTitle.vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import CardBlock from "@/Components/CardBlock.vue";

</script>

<template>
    <page-title title="Админка"/>

    <admin-layout header="Админка">
        <card-block class="mt-4">
            <p>Тут ничего нет :)</p>
        </card-block>
    </admin-layout>
</template>
