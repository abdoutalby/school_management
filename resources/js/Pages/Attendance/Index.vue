<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import Pagination from '@/Components/Pagination.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    classes: Array,
    subjects: Array,
    attendances: Object,
    filters: Object
});

const showForm = ref(false);
const form = useForm({
    class_id: props.filters.class_id || '',
    subject_id: props.filters.subject_id || '',
    date: props.filters.date || '',
    attendances: []
});

const students = ref([]);
const loading = ref(false);

// For filtering the attendance list
const filters = useForm({
    class_id: props.filters.class_id || '',
    subject_id: props.filters.subject_id || '',
    date: props.filters.date || '',
});

// Watch for class changes
watch(() => filters.class_id, (value) => {
    filters.subject_id = ''; // Reset subject when class changes
    router.get(route('attendances.index'), { 
        class_id: value,
        subject_id: '',
        date: filters.date 
    }, {
        preserveState: true,
        preserveScroll: true,
    });
});

// Watch for subject changes
watch(() => filters.subject_id, (value) => {
    if (filters.class_id) {
        router.get(route('attendances.index'), { 
            class_id: filters.class_id,
            subject_id: value,
            date: filters.date 
        }, {
            preserveState: true,
            preserveScroll: true,
        });
    }
});

// Watch for date changes
watch(() => filters.date, (value) => {
    router.get(route('attendances.index'), { 
        class_id: filters.class_id,
        subject_id: filters.subject_id,
        date: value 
    }, {
        preserveState: true,
        preserveScroll: true,
    });
});

const loadStudents = async () => {
    if (!form.class_id || !form.subject_id || !form.date) return;

    loading.value = true;
    try {
        const response = await axios.get(route('attendances.get-students'), {
            params: {
                class_id: form.class_id,
                subject_id: form.subject_id,
                date: form.date
            }
        });
        
        students.value = response.data.students;
        form.attendances = response.data.students.map(student => ({
            student_id: student.id,
            status: student.status
        }));
    } catch (error) {
        console.error('Error loading students:', error);
    }
    loading.value = false;
};

const submit = () => {
    form.post(route('attendances.store'), {
        onSuccess: () => {
            showForm.value = false;
        },
    });
};

const getStatusColor = (status) => {
    switch (status) {
        case 'present': return 'text-green-600';
        case 'absent': return 'text-red-600';
        case 'late': return 'text-yellow-600';
        default: return 'text-gray-600';
    }
};
</script>

<template>
    <AppLayout title="Attendance">
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Attendance Management
                </h2>
                <button
                    @click="showForm = !showForm"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700"
                >
                    {{ showForm ? 'View Attendance' : 'Take Attendance' }}
                </button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <!-- Attendance Taking Form -->
                <div v-if="showForm" class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-6">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <InputLabel for="class_id" value="Class" />
                                <SelectInput
                                    id="class_id"
                                    v-model="form.class_id"
                                    class="mt-1 block w-full"
                                    required
                                >
                                    <option value="">Select Class</option>
                                    <option v-for="class_room in classes" :key="class_room.id" :value="class_room.id">
                                        {{ class_room.name }}
                                    </option>
                                </SelectInput>
                            </div>

                            <div>
                                <InputLabel for="subject_id" value="Subject" />
                                <SelectInput
                                    id="subject_id"
                                    v-model="form.subject_id"
                                    class="mt-1 block w-full"
                                    required
                                    :disabled="!form.class_id"
                                >
                                    <option value="">Select Subject</option>
                                    <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                        {{ subject.name }}
                                    </option>
                                </SelectInput>
                            </div>

                            <div>
                                <InputLabel for="date" value="Date" />
                                <TextInput
                                    id="date"
                                    v-model="form.date"
                                    type="date"
                                    class="mt-1 block w-full"
                                    required
                                />
                            </div>
                        </div>

                        <div v-if="students.length > 0" class="mt-6">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Student Name
                                        </th>
                                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(student, index) in students" :key="student.id">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ student.name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <SelectInput
                                                v-model="form.attendances[index].status"
                                                class="block w-full"
                                            >
                                                <option value="present">Present</option>
                                                <option value="absent">Absent</option>
                                                <option value="late">Late</option>
                                            </SelectInput>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="mt-6 flex justify-end">
                                <PrimaryButton :disabled="form.processing">
                                    Save Attendance
                                </PrimaryButton>
                            </div>
                        </div>

                        <div v-else-if="loading" class="mt-6 text-center">
                            Loading students...
                        </div>

                        <div v-else-if="form.class_id && form.subject_id && form.date" class="mt-6 text-center text-gray-500">
                            No students found in this class
                        </div>
                    </form>
                </div>

                <!-- Attendance List -->
                <div v-else class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        <div>
                            <InputLabel for="filter_class" value="Filter by Class" />
                            <SelectInput
                                id="filter_class"
                                v-model="filters.class_id"
                                class="mt-1 block w-full"
                            >
                                <option value="">All Classes</option>
                                <option v-for="class_room in classes" :key="class_room.id" :value="class_room.id">
                                    {{ class_room.name }}
                                </option>
                            </SelectInput>
                        </div>

                        <div>
                            <InputLabel for="filter_subject" value="Filter by Subject" />
                            <SelectInput
                                id="filter_subject"
                                v-model="filters.subject_id"
                                class="mt-1 block w-full"
                                :disabled="!filters.class_id"
                            >
                                <option value="">All Subjects</option>
                                <option v-for="subject in subjects" :key="subject.id" :value="subject.id">
                                    {{ subject.name }}
                                </option>
                            </SelectInput>
                        </div>

                        <div>
                            <InputLabel for="filter_date" value="Filter by Date" />
                            <TextInput
                                id="filter_date"
                                v-model="filters.date"
                                type="date"
                                class="mt-1 block w-full"
                            />
                        </div>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Class
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Subject
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Student
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr v-for="attendance in attendances.data" :key="attendance.id">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ attendance.date }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ attendance.student.class_room.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ attendance.subject.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ attendance.student.user.name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span :class="getStatusColor(attendance.status)">
                                        {{ attendance.status.charAt(0).toUpperCase() + attendance.status.slice(1) }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-6">
                        <Pagination :links="attendances.links" />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template> 