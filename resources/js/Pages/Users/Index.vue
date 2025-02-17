<template>
  <AppLayout title="Users">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Users
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <!-- Search -->
          <div class="mb-6">
            <SearchInput
              v-model="search"
              class="w-full md:w-1/3"
              placeholder="Search users..."
            />
          </div>

          <!-- Users Table -->
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-6 py-3 bg-gray-50 text-left">
                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Photo</span>
                  </th>
                  <th class="px-6 py-3 bg-gray-50 text-left">
                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Name</span>
                  </th>
                  <th class="px-6 py-3 bg-gray-50 text-left">
                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Email</span>
                  </th>
                  <th class="px-6 py-3 bg-gray-50 text-left">
                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Actions</span>
                  </th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="user in users.data" :key="user.id">
                  <td class="px-6 py-4 whitespace-no-wrap">
                    <img :src="user.profile_photo_url" class="h-10 w-10 rounded-full" />
                  </td>
                  <td class="px-6 py-4 whitespace-no-wrap">{{ user.name }}</td>
                  <td class="px-6 py-4 whitespace-no-wrap">{{ user.email }}</td>
                  <td class="px-6 py-4 whitespace-no-wrap">
                    <Link :href="route('users.show', user.id)" class="text-indigo-600 hover:text-indigo-900">View</Link>
                    <Link :href="route('users.edit', user.id)" class="ml-4 text-indigo-600 hover:text-indigo-900">Edit</Link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <Pagination :links="users.links" class="mt-6" />
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref, watch } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'
import SearchInput from '@/Components/SearchInput.vue'
import Pagination from '@/Components/Pagination.vue'

const props = defineProps({
  users: Object,
  filters: Object
})

const search = ref(props.filters.search)

watch(search, value => {
  router.get(route('users.index'), { search: value }, {
    preserveState: true,
    preserveScroll: true
  })
})
</script> 