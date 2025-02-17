<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    parents: Object,
    filters: Object
});

const search = ref(props.filters.search);

function debounce(fn, delay) {
    let timeoutId;
    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => fn(...args), delay);
    };
}

watch(search, debounce((value) => {
    router.get(route('parents.index'), { search: value }, {
        preserveState: true,
        preserveScroll: true,
    });
}, 300));

const deleteParent = (parent) => {
    if (confirm('Are you sure you want to delete this parent?')) {
        router.delete(route('parents.destroy', parent.id));
    }
};
</script>

<template>
    <AppLayout title="Parents">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Parents
                </h2>
                <Link
                    :href="route('parents.create')"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                >
                    Add Parent
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="mb-4">
                            <input
                                v-model="search"
                                type="text"
                                placeholder="Search by name, email or relationship..."
                                class="w-full sm:w-1/3 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            >
                        </div>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Phone
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Address
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Relationship
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Children
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="parent in parents.data" :key="parent.id">
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        {{ parent.user.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        {{ parent.user.email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        {{ parent.user.phone }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        {{ parent.address }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        {{ parent.relationship }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        <div v-for="student in parent.students" :key="student.id" class="text-sm">
                                            {{ student.user.name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                        <Link
                                            :href="route('parents.edit', parent.id)"
                                            class="text-indigo-600 hover:text-indigo-900 mr-3"
                                        >
                                            Edit
                                        </Link>
                                        <button
                                            @click="deleteParent(parent)"
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-6">
                            <Pagination :links="parents.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 