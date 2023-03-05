<template>
  <select
          class="focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm py-1 px-2 border"
          :class="dynClasses"
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
          ref="input"
          v-bind="{...$props, ...$attrs}"
  >
      <slot/>
  </select>
    <p v-if="!isEmpty(error)" class="text-sm text-red-600 mt-0.5">{{ error }}</p>
</template>

<script setup>
import {computed, onMounted, ref} from "vue";
import {isEmpty} from "lodash";

const props = defineProps({
    modelValue: {
        type: String,
        required: false,
        default: '',
    },
    error: {
        type: String,
        required: false,
        default: null,
    },
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });

const dynClasses = computed(() => {
    return isEmpty(props.error)
        ? 'border-gray-300'
        : 'border-red-600 border';
});

</script>
