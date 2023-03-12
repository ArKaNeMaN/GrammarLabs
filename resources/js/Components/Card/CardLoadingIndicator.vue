<script setup>
defineProps({
    loading: {
        type: Boolean,
        required: false,
        default: true,
    },
});
</script>

<template>
    <div
        v-if="loading"
        class="absolute top-0 bottom-0 left-0 right-0 bg-gray-500/20 z-[9999] flex flex-col items-center justify-center"
        style="margin: 0;"
    >
        <div class="flex items-center flex-col p-4 space-y-2 rounded-lg bg-black/10">
            <span>Загрузка</span>
            <svg
                class="w-8 fill-black/80 animate-spin"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 512 512"
            >
                <path
                    d="M304 48c0-26.5-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48zm0 416c0-26.5-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48zM48 304c26.5 0 48-21.5 48-48s-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48zm464-48c0-26.5-21.5-48-48-48s-48 21.5-48 48s21.5 48 48 48s48-21.5 48-48zM142.9 437c18.7-18.7 18.7-49.1 0-67.9s-49.1-18.7-67.9 0s-18.7 49.1 0 67.9s49.1 18.7 67.9 0zm0-294.2c18.7-18.7 18.7-49.1 0-67.9S93.7 56.2 75 75s-18.7 49.1 0 67.9s49.1 18.7 67.9 0zM369.1 437c18.7 18.7 49.1 18.7 67.9 0s18.7-49.1 0-67.9s-49.1-18.7-67.9 0s-18.7 49.1 0 67.9z"
                />
            </svg>
        </div>
    </div>
</template>
