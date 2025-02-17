<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';

const props = defineProps({
    teachers: Array,
    classes: Array
});

const form = useForm({
    name: '',
    teacher_id: '',
    class_room_id: ''
});

const submit = () => {
    form.post(route('subjects.store'));
};
</script>

<template>
    <AppLayout title="Create Subject">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Subject
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <InputLabel for="name" value="Subject Name" />
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
                                    <InputLabel for="class_room_id" value="Class" />
                                    <SelectInput
                                        id="class_room_id"
                                        v-model="form.class_room_id"
                                        class="mt-1 block w-full"
                                        required
                                    >
                                        <option value="">Select Class</option>
                                        <option v-for="class_room in classes" :key="class_room.id" :value="class_room.id">
                                            {{ class_room.name }}
                                        </option>
                                    </SelectInput>
                                    <InputError :message="form.errors.class_room_id" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <PrimaryButton
                                    class="ml-4"
                                    :disabled="form.processing"
                                >
                                    Create Subject
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 