<script setup>
import TableRowHeader from "@/Components/Table/TableRowHeader.vue";

defineProps({
    ths: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <table-row-header>
        <th v-for="th in ths">{{ th }}</th>
    </table-row-header>
</template>
