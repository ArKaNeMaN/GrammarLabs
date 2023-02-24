<template>
    <label class="block mb-2">
        <span class="text-sm mb-1 block font-semibold text-gray-500">{{ label }}</span>
        <slot></slot>
    </label>
</template>

<script setup>

const props = defineProps({
    label: String,
});

</script>
