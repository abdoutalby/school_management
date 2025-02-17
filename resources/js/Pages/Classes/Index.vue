<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps({
    classes: Object
});

const search = ref('');

const deleteClass = (classRoom) => {
    if (confirm('Are you sure you want to delete this class?')) {
        router.delete(route('classes.destroy', classRoom.id));
    }
};
</script>

<template>
    <AppLayout title="Classes">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Classes
                </h2>
                <Link
                    :href="route('classes.create')"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                >
                    Add Class
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
                                placeholder="Search classes..."
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
                                        Grade Level
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Teacher
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Capacity
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Academic Year
                                    </th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="class_room in classes.data" :key="class_room.id">
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        {{ class_room.name }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        Grade {{ class_room.grade_level }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        {{ class_room.teacher?.user?.name || 'No Teacher Assigned' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        {{ class_room.capacity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap">
                                        {{ class_room.academic_year }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap text-right text-sm leading-5 font-medium">
                                        <Link
                                            :href="route('classes.edit', class_room.id)"
                                            class="text-indigo-600 hover:text-indigo-900 mr-3"
                                        >
                                            Edit
                                        </Link>
                                        <button
                                            @click="deleteClass(class_room)"
                                            class="text-red-600 hover:text-red-900"
                                        >
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="mt-6" v-if="classes.links">
                            <Pagination :links="classes.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 