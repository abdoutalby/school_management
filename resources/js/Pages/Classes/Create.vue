<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';

const props = defineProps({
    teachers: Array
});

const form = useForm({
    name: '',
    grade_level: '',
    teacher_id: '',
    capacity: '',
    academic_year: new Date().getFullYear().toString()
});

const submit = () => {
    form.post(route('classes.store'));
};
</script>

<template>
    <AppLayout title="Create Class">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Class
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="name" value="Class Name" />
                                    <TextInput
                                        id="name"
                                        v-model="form.name"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.name" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="grade_level" value="Grade Level" />
                                    <TextInput
                                        id="grade_level"
                                        v-model="form.grade_level"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.grade_level" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="teacher_id" value="Teacher" />
                                    <SelectInput
                                        id="teacher_id"
                                        v-model="form.teacher_id"
                                        class="mt-1 block w-full"
                                    >
                                        <option value="">Select Teacher</option>
                                        <option v-for="teacher in teachers" :key="teacher.id" :value="teacher.id">
                                            {{ teacher.user.name }}
                                        </option>
                                    </SelectInput>
                                    <InputError :message="form.errors.teacher_id" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="capacity" value="Capacity" />
                                    <TextInput
                                        id="capacity"
                                        v-model="form.capacity"
                                        type="number"
                                        min="1"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.capacity" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="academic_year" value="Academic Year" />
                                    <TextInput
                                        id="academic_year"
                                        v-model="form.academic_year"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.academic_year" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <PrimaryButton
                                    class="ml-4"
                                    :disabled="form.processing"
                                >
                                    Create Class
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 