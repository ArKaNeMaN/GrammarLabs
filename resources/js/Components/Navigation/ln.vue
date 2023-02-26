<template>
    <Link v-bind="{...$attrs, ...$props}"><slot/></Link>
</template>

<script setup>
import {Link} from "@inertiajs/inertia-vue3";

defineProps({
    href: {
        type: String,
        required: true,
    },
});
</script>
