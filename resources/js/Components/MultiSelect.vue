<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: Array,
        default: () => []
    },
    options: {
        type: Array,
        required: true
    },
    label: {
        type: String,
        default: 'name'
    },
    trackBy: {
        type: String,
        default: 'id'
    },
    multiple: {
        type: Boolean,
        default: true
    },
    placeholder: {
        type: String,
        default: 'Select options'
    }
});

const emit = defineEmits(['update:modelValue']);

const isOpen = ref(false);
const selectedOptions = ref(props.modelValue);

watch(selectedOptions, (newVal) => {
    emit('update:modelValue', newVal);
});

const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const toggleOption = (option) => {
    if (props.multiple) {
        const index = selectedOptions.value.findIndex(item => item[props.trackBy] === option[props.trackBy]);
        if (index === -1) {
            selectedOptions.value.push(option);
        } else {
            selectedOptions.value.splice(index, 1);
        }
    } else {
        selectedOptions.value = [option];
        isOpen.value = false;
    }
};

const isSelected = (option) => {
    return selectedOptions.value.some(item => item[props.trackBy] === option[props.trackBy]);
};
</script>

<template>
    <div class="relative">
        <div
            @click="toggleDropdown"
            class="w-full cursor-pointer bg-white border border-gray-300 rounded-md shadow-sm px-4 py-2 text-left focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500"
        >
            <span v-if="selectedOptions.length === 0" class="text-gray-500">
                {{ placeholder }}
            </span>
            <div v-else class="flex flex-wrap gap-1">
                <span
                    v-for="option in selectedOptions"
                    :key="option[trackBy]"
                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800"
                >
                    {{ option[label] }}
                </span>
            </div>
        </div>

        <div
            v-if="isOpen"
            class="absolute z-10 mt-1 w-full bg-white shadow-lg rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto max-h-60"
        >
            <div
                v-for="option in options"
                :key="option[trackBy]"
                @click="toggleOption(option)"
                class="cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-indigo-50"
                :class="{ 'bg-indigo-50': isSelected(option) }"
            >
                <span class="block truncate">
                    {{ option[label] }}
                </span>
                <span
                    v-if="isSelected(option)"
                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600"
                >
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
            </div>
        </div>
    </div>
</template> 