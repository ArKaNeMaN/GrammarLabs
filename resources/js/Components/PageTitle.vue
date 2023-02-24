<template>
    <Head>
        <title>{{ title }}</title>
    </Head>
</template>

<script setup>
import {Head} from '@inertiajs/inertia-vue3';

defineProps({
    title: {
        type: String,
        required: true,
    },
});
</script>
