<template>
    <div class="flex justify-center items-center">
        <p class="text-sm text-gray-500 md:block hidden">Страница {{ data.current_page }}</p>
        <span class="flex-grow"></span>
        <div class="pagination">
            <secondary-button
                @click="emit('update:page', data.current_page - 1)"
                :disabled="data.current_page <= 1">
                ←
            </secondary-button>

            <secondary-button
                @click="emit('update:page', data.current_page - 3)"
                v-if="data.current_page > 3">
                {{ data.current_page - 3 }}
            </secondary-button>
            <secondary-button
                @click="emit('update:page', data.current_page - 2)"
                v-if="data.current_page > 2">
                {{ data.current_page - 2 }}
            </secondary-button>
            <secondary-button
                @click="emit('update:page', data.current_page - 1)"
                v-if="data.current_page > 1">
                {{ data.current_page - 1 }}
            </secondary-button>

            <secondary-button
                @click="emit('update:page', )"
                disabled>
                {{ data.current_page }}
            </secondary-button>

            <secondary-button
                @click="emit('update:page', data.current_page + 1)"
                v-if="data.current_page < data.last_page">
                {{ data.current_page + 1 }}
            </secondary-button>
            <secondary-button
                @click="emit('update:page', data.current_page + 2)"
                v-if="data.current_page < data.last_page - 1">
                {{ data.current_page + 2 }}
            </secondary-button>
            <secondary-button
                @click="emit('update:page', data.current_page + 3)"
                v-if="data.current_page < data.last_page - 2">
                {{ data.current_page + 3 }}
            </secondary-button>

            <secondary-button
                @click="emit('update:page', data.current_page + 1)"
                :disabled="data.current_page >= data.last_page">
                →
            </secondary-button>
        </div>
        <span class="flex-grow"></span>
        <p class="text-sm text-gray-500 md:block hidden">Всего страниц {{ data.last_page }}</p>
    </div>
</template>

<script setup>
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
    page: {
        type: Number,
        required: false,
    },
});

const emit = defineEmits(['update:page']);

</script>
