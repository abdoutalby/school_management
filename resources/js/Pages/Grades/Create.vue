<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';

const props = defineProps({
    students: Array,
    subjects: Array
});

const form = useForm({
    student_id: '',
    subject_id: '',
    grade: '',
    term: '',
    academic_year: new Date().getFullYear().toString()
});

const submit = () => {
    form.post(route('grades.store'));
};
</script>

<template>
    <AppLayout title="Add Grade">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Add Grade
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="student_id" value="Student" />
                                    <SelectInput
                                        id="student_id"
                                        v-model="form.student_id"
                                        class="mt-1 block w-full"
                                        required
                                    >
                                        <option value="">Select a student</option>
                                        <option v-for="student in students" :key="student.id" :value="student.id">
                                            {{ student.name }}
                                        </option>
                                    </SelectInput>
                                    <InputError :message="form.errors.student_id" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="subject_id" value="Subject" />
                                    <SelectInput
                                        id="subject_id"
                                        v-model="form.subject_id"
                                        class="mt-1 block w-full"
                                        required
                                    >
                                        <option value="">Select a subject</option>
                                        <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                            {{ subject.name }}
                                        </option>
                                    </SelectInput>
                                    <InputError :message="form.errors.subject_id" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="grade" value="Grade" />
                                    <TextInput
                                        id="grade"
                                        v-model="form.grade"
                                        type="number"
                                        min="0"
                                        max="100"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.grade" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="term" value="Term" />
                                    <SelectInput
                                        id="term"
                                        v-model="form.term"
                                        class="mt-1 block w-full"
                                        required
                                    >
                                        <option value="">Select term</option>
                                        <option value="First">First Term</option>
                                        <option value="Second">Second Term</option>
                                        <option value="Third">Third Term</option>
                                    </SelectInput>
                                    <InputError :message="form.errors.term" class="mt-2" />
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
                                    Record Grade
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 