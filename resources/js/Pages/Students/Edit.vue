<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';

const props = defineProps({
    student: Object,
    classes: Array,
    parents: Array
});

const form = useForm({
    name: props.student.name,
    email: props.student.email,
    parent_id: props.student.parent_id,
    class_id: props.student.class_id,
    admission_number: props.student.admission_number,
    admission_date: props.student.admission_date
});

const submit = () => {
    form.put(route('students.update', props.student.id));
};
</script>

<template>
    <AppLayout title="Edit Student">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Student
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <!-- Same form fields as Create.vue -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="name" value="Name" />
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
                                    <InputLabel for="email" value="Email" />
                                    <TextInput
                                        id="email"
                                        v-model="form.email"
                                        type="email"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.email" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="parent_id" value="Parent" />
                                    <SelectInput
                                        id="parent_id"
                                        v-model="form.parent_id"
                                        class="mt-1 block w-full"
                                        required
                                    >
                                        <option value="">Select a parent</option>
                                        <option v-for="parent in parents" :key="parent.id" :value="parent.id">
                                            {{ parent.name }}
                                        </option>
                                    </SelectInput>
                                    <InputError :message="form.errors.parent_id" class="mt-2" />
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
                                    <InputLabel for="admission_number" value="Admission Number" />
                                    <TextInput
                                        id="admission_number"
                                        v-model="form.admission_number"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.admission_number" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="admission_date" value="Admission Date" />
                                    <TextInput
                                        id="admission_date"
                                        v-model="form.admission_date"
                                        type="date"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.admission_date" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <PrimaryButton
                                    class="ml-4"
                                    :disabled="form.processing"
                                >
                                    Update Student
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 