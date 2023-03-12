<script setup>
import {isEmpty} from "lodash";
import SecondaryButton from "@/Components/Buttons/SecondaryButton.vue";
import TextInput from "@/Components/Form/TextInput.vue";
import TextInputsList from "@/Components/Form/TextInputsList.vue";
import {ref, watch} from "vue";

const props = defineProps({
    modelValue: {
        type: Array,
        required: true,
    },
    error: {
        type: String,
        required: false,
        default: null,
    },
});

const emit = defineEmits(['update:modelValue']);

const rules = ref(props.modelValue);
watch(rules, () => emit('update:modelValue', rules.value), {deep: true});

function removeArrayItem(arr, index) {
    let res = [...arr];
    res.splice(index, 1);
    return res;
}

</script>

<template>
    <div
        class="space-y-4 rounded-md border-red-600"
        :class="{'border': !isEmpty(error)}"
        v-bind="{...$props, ...$attrs}"
    >
        <div
            v-for="(ignored__rule, i) in rules"
            class="flex items-center"
        >
            <div class="flex">
                <secondary-button
                    class="rounded-r-none"
                    @click="rules = removeArrayItem(rules, i)"
                    type="button"
                >-
                </secondary-button>
                <text-input
                    v-model="rules[i].left"
                    class="w-32 rounded-l-none border-l-0"
                />
            </div>
            <code> → </code>
            <text-inputs-list
                v-model="rules[i].rights"
                input-class="w-32"
                separator="|"
            />
        </div>
        <secondary-button
            @click="rules.push({left: '', rights: ['']})"
            type="button"
        >
            Добавить правило
        </secondary-button>
    </div>
    <p v-if="!isEmpty(error)" class="text-sm text-red-600 mt-0.5">{{ error }}</p>
</template>
