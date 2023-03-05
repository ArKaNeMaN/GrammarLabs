<template>
    <div class="block mb-2">
        <span class="text-sm mb-1 block font-semibold text-gray-500">{{ label }}</span>
        <span class="text-xs mb-1 block font-normal text-gray-500">{{ hint }}</span>
        <slot></slot>
    </div>
</template>

<script setup>

const props = defineProps({
    label: String,
    hint: String,
});

</script>
