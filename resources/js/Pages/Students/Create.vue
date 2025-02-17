<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';

const props = defineProps({
    classes: Array,
    parents: Array
});

const form = useForm({
    name: '',
    email: '',
    phone: '',
    parent_id: '',
    class_id: '',
    gender: '',
    date_of_birth: ''
});

const submit = () => {
    form.post(route('students.store'));
};
</script>

<template>
    <AppLayout title="Create Student">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Student
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
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
                                    <InputLabel for="phone" value="Phone" />
                                    <TextInput
                                        id="phone"
                                        v-model="form.phone"
                                        type="text"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.phone" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="parent_id" value="Parent" />
                                    <SelectInput
                                        id="parent_id"
                                        v-model="form.parent_id"
                                        class="mt-1 block w-full"
                                    >
                                        <option value="">Select Parent</option>
                                        <option v-for="parent in parents" :key="parent.id" :value="parent.id">
                                            {{ parent.user.name }}
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
                                    >
                                        <option value="">Select Class</option>
                                        <option v-for="class_room in classes" :key="class_room.id" :value="class_room.id">
                                            {{ class_room.name }}
                                        </option>
                                    </SelectInput>
                                    <InputError :message="form.errors.class_id" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="gender" value="Gender" />
                                    <SelectInput
                                        id="gender"
                                        v-model="form.gender"
                                        class="mt-1 block w-full"
                                        required
                                    >
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </SelectInput>
                                    <InputError :message="form.errors.gender" class="mt-2" />
                                </div>

                                <div>
                                    <InputLabel for="date_of_birth" value="Date of Birth" />
                                    <TextInput
                                        id="date_of_birth"
                                        v-model="form.date_of_birth"
                                        type="date"
                                        class="mt-1 block w-full"
                                        required
                                    />
                                    <InputError :message="form.errors.date_of_birth" class="mt-2" />
                                </div>
                            </div>

                            <div class="flex items-center justify-end mt-6">
                                <PrimaryButton
                                    class="ml-4"
                                    :disabled="form.processing"
                                >
                                    Create Student
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 