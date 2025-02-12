<script setup>
import { Link, router, useForm } from "@inertiajs/vue3";
import PaginateLink from "../../Components/PaginateLink.vue";
import RoleSelect from "../../Components/RoleSelect.vue";
import InputField from "../../Components/InputField.vue";
import SesssionMessages from "../../Components/SessionMessages.vue";

const params = route().params; // get all route parameters

const props = defineProps({
  users: Object,
  status: String,
});

const form = useForm({
  search: params.search,
});

const submit = () => {
  router.get(route("index"), {
    search: form.search,
    user_role: params.user_role,
  });
};

const changeRole = (e) => {
  if (e.target.checked) {
    router.get(
      route("index", {
        search: params.search,
        user_role: "suspended",
      })
    );
  } else {
    router.get(
      route("index", {
        search: params.search,
        user_role: null,
      })
    );
  }
};
</script>

<template>
  <Head title="- Admin Dashboard" />
  <!-- Heading -->
  <div class="flex items-end justify-between mb-4">
    <h1>Admin Dashboard<br><small>Users</small></h1>
    
    <div class="flex items-end gap-2">
      <label class="inline-flex items-center me-5 cursor-pointer">
        <input
          type="checkbox"
          id="changeRole"
          class="sr-only peer"
          @input="changeRole"
          :checked="params.user_role"
        />
        <div
          class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-focus:ring-4 peer-focus:ring-red-300
           dark:peer-focus:ring-red-800 dark:bg-gray-600 peer-checked:after:translate-x-full
            rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-['']
            after:absolute after:top-0.5 after:start-[2px] after:bg-white after:border-gray-300
            after:border after:rounded-full after:h-5 after:w-5 after:transition-all
            dark:border-gray-600 peer-checked:bg-red-600
            dark:peer-checked:bg-red-600"
        ></div>
        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300"
          >Suspended Users</span
        >
      </label>

      <form @submit.prevent="submit">
        <InputField
          label=""
          icon="magnifying-glass"
          placeholder="Search..."
          v-model="form.search"
        />
      </form>

      <Link
        class="bg-red-500 p-2 text-white rounded-lg hover:bg-red-700"
        v-if="params.search"
        :href="
          route('index', {
            ...params,
            search: null,
            page: null,
          })
        "
        >Remove</Link
      >
    </div>
  </div>

  <!-- Session message -->
  <SesssionMessages :status="status" />

  <!-- Table -->
  <table
    class="bg-white dark:bg-slate-800 w-full rounded-lg overflow-hidden ring-1 ring-slate-300"
  >
    <thead class="bg-slate-600 text-slate-300 uppercase text-xs text-left">
      <th class="w-3/6 p-3">Name</th>
      <th class="w-2/6 p-3">Role</th>
      <th class="w-1/6 p-3">Listings</th>
      <th class="w-1/6 p-3 text-right">View</th>
    </thead>

    <tbody class="divide-y dive-slate-300 divide-dashed">
      <tr v-for="user in users.data" :key="user.id">
        <td class="w-3/6 py-5 px-3">
          <p class="font-bold mb-1">{{ user.name }}</p>
          <p class="font-light text-xs">{{ user.email }}</p>
        </td>
        <td class="w-2/6 py-5 px-3">
          <RoleSelect :user="user" />
        </td>
        <td class="w-1/6 py-5 px-3">
          <div class="flex items-center gap-3">
            <div class="flex items-center gap-1">
              <p>{{ user.listings.filter((l) => l.status == true).length }}</p>
              <i class="fa-solid fa-circle-check text-green-500"></i>
            </div>
            <div class="flex items-center gap-1">
              <p>{{ user.listings.filter((l) => l.status == false).length }}</p>

              <i class="fa-solid fa-circle-xmark text-red-500"></i>
            </div>
          </div>
        </td>
        <td class="w-1/6 py-5 px-3 text-right">
          <Link :href="route('show', user.id)" class="fa-solid fa-up-right-from-square px-3 text-indigo-400"/>
        </td>
      </tr>
    </tbody>
  </table>

  <div class="mt-6">
    <PaginateLink :paginator="users" />
  </div>
</template>
