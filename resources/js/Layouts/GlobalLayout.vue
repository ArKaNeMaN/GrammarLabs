<script setup>
import {usePage} from "@inertiajs/inertia-vue3";
import {watch} from "vue";
import {isEmpty} from "lodash";
import {useToast} from "vue-toastification";

const pageProps = usePage().props;
const toast = useToast();

watch(pageProps, () => {
    if (isEmpty(pageProps.value.toasts)) {
        return;
    }

    for (const msg of pageProps.value.toasts) {
        // noinspection JSCheckFunctionSignatures
        toast(msg.text, {
            type: msg.type ?? 'default',
        });
    }

    pageProps.value.toasts = [];
}, {deep: true});
</script>

<template>
    <slot/>
</template>
