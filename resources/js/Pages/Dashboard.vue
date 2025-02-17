<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    School Management Dashboard
                </h2>
                 
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Students Management -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Students
                                            </dt>
                                            <dd>
                                                <div class="text-lg font-medium text-gray-900">
                                                    <Link :href="route('students.index')" class="text-indigo-600 hover:text-indigo-900">
                                                        Manage Students
                                                    </Link>
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Teachers Management -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Teachers
                                            </dt>
                                            <dd>
                                                <div class="text-lg font-medium text-gray-900">
                                                    <Link :href="route('teachers.index')" class="text-indigo-600 hover:text-indigo-900">
                                                        Manage Teachers
                                                    </Link>
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Classes Management -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="p-5">
                                <div class="flex items-center">
                                    <div class="ml-5 w-0 flex-1">
                                        <dl>
                                            <dt class="text-sm font-medium text-gray-500 truncate">
                                                Classes
                                            </dt>
                                            <dd>
                                                <div class="text-lg font-medium text-gray-900">
                                                    <Link :href="route('classes.index')" class="text-indigo-600 hover:text-indigo-900">
                                                        Manage Classes
                                                    </Link>
                                                </div>
                                            </dd>
                                        </dl>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- More cards for other entities... -->
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
