<script setup>
defineProps({
    modelValue: {
        type: [String, Number, Array],
        default: ''
    },
    multiple: {
        type: Boolean,
        default: false
    }
});

defineEmits(['update:modelValue']);
</script>

<template>
    <select
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
        :multiple="multiple"
    >
        <slot></slot>
    </select>
</template> 