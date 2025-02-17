<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextArea from '@/Components/TextArea.vue';

const props = defineProps({
    assignment: Object,
    subjects: Array,
    classes: Array
});

const form = useForm({
    title: props.assignment.title,
    description: props.assignment.description,
    subject_id: props.assignment.subject_id,
    class_id: props.assignment.class_id,
    due_date: props.assignment.due_date,
    max_score: props.assignment.max_score
});

const submit = () => {
    form.put(route('assignments.update', props.assignment.id));
};
</script>

<template>
    <AppLayout title="Edit Assignment">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Assignment
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <!-- Same form fields as Create.vue -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-2">
                                    <InputLabel for="title" value="Title" />
                                    <TextInput
                                        id="title"
                                        v-model="form.title"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.title" class="mt-2" />
                                </div>

                                <div class="col-span-2">
                                    <InputLabel for="description" value="Description" />
                                    <TextArea
                                        id="description"
                                        v-model="form.description"
                                        class="mt-1 block w-full"
                                        rows="4"
                                        required
                                    />
                                    <InputError :message="form.errors.description" class="mt-2" />
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
                                    <InputLabel for="class_id" value="Class" />
                                    <SelectInput
                                        id="class_id"
                                        v-model="form.class_id"
                                        class="mt-1 block w-full"
                                        required
                                    >
                                        <option value="">Select a class</option>
                                        <option v-for="class_room in classes" :key="class_room.id" :value="class_room.id">
                                            {{ class_room.name }}
                                        </option>
                                    </SelectInput>
                                    <InputError :message="form.errors.class_id" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="due_date" value="Due Date" />
                                    <TextInput
                                        id="due_date"
                                        v-model="form.due_date"
                                        type="date"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.due_date" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="max_score" value="Maximum Score" />
                                    <TextInput
                                        id="max_score"
                                        v-model="form.max_score"
                                        type="number"
                                        min="0"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.max_score" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <PrimaryButton
                                    class="ml-4"
                                    :disabled="form.processing"
                                >
                                    Update Assignment
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 