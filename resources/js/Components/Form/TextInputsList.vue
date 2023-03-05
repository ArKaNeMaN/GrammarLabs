<script setup>
import {computed} from "vue";
import {isEmpty} from "lodash";
import TextInput from "@/Components/Form/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    modelValue: {
        type: Array,
        required: true,
    },
    error: {
        type: Boolean,
        required: false,
        default: false,
    },
    inputClass: {
        type: String,
        required: false,
        default: '',
    },
    defaultNew: {
        type: String,
        required: false,
        default: '',
    },
    separator: {
        type: String,
        required: false,
        default: ', '
    },
});

const emit = defineEmits(['update:modelValue']);

const valueProxy = computed({
    get: () => {
        if (isEmpty(props.modelValue)) {
            return [''];
        }
        return props.modelValue;
    },
    set: (val) => {
        emit('update:modelValue', val);
    },
});

function removeArrayItem(arr, index) {
    let res = [...arr];
    res.splice(index, 1);
    return res;
}

</script>

<template>
    <div
        class="flex flex-wrap items-center"
        v-bind="{...$props, ...$attrs}"
    >
        <template v-for="(str, i) in valueProxy" :key="i">
            <span class="m-1 flex">
                <text-input
                    :value="str"
                    @input="valueProxy[i] = $event.target.value"
                    class="rounded-r-none border-r-0"
                    :class="inputClass"
                />
                <secondary-button
                    class="rounded-l-none"
                    @click="valueProxy = removeArrayItem(valueProxy, i)"
                    type="button"
                >-</secondary-button>
            </span>
            <span v-if="i + 1 < valueProxy.length">{{ separator }}</span>
        </template>
        <secondary-button
            class="m-1"
            @click="valueProxy = [...valueProxy, defaultNew]"
            type="button"
        >+</secondary-button>
    </div>
    <p v-if="!isEmpty(error)" class="text-sm text-red-600 mt-0.5">{{ error }}</p>
</template>
