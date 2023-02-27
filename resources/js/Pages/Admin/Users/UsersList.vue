<template>
    <page-title title="Список пользователей"/>

    <admin-layout header="Список пользователей">
        <users-list-card
            class="w-full mt-4"
            with-actions
            with-search
        />
    </admin-layout>
</template>

<script setup>

import AdminLayout from "@/Layouts/AdminLayout.vue";
import UsersListCard from "@/Pages/Admin/Components/UsersListCard.vue";
import PageTitle from "@/Components/PageTitle.vue";
</script>
