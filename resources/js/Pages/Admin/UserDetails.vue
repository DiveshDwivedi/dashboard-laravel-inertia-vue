<script setup>
import { router, useForm } from "@inertiajs/vue3";
import Title from "../../Components/Title.vue";
import InputField from "../../Components/InputField.vue";
import PaginateLink from "../../Components/PaginateLink.vue";
import SessionMessages from "../../Components/SessionMessages.vue";

const params = route().params;

const props = defineProps({
  user: Object,
  listings: Object,
  status: String,
});

const form = useForm({
  search: params.search,
});

const submit = () => {
  router.get(
    route("show", {
      user: props.user.id,
      search: form.search,
    })
  );
};

const toggleStatus = (e) => {
  if (e.target.checked) {
    router.get(
      route("show", {
        user: props.user.id,
        inactive: true,
        search: form.search,
      })
    );
  } else {
    router.get(
      route("show", {
        user: props.user.id,
        inactive: null,
        search: form.search,
      })
    );
  }
};

const changeStatus = (listing) => {
  const msg = listing.status ? "Inactive" : "Active";
  if (confirm(`Are sure changing status to ${msg} `)) {
    router.put(
      route("status", {
        listing: listing.id,
      })
    );
  }
};
</script>
<template>
  <Head :title="` - ${user.name} Listings`" />
  <SessionMessages :status="status" />
  <!-- Heading -->
  <div class="mb-6">
    <Title> {{ user.name }} Listings</Title>
    <div class="flex items-end justify-between">
      <div class="flex items-start gap-3">
        <form @submit.prevent="submit">
          <InputField
            label=""
            icon="magnifying-glass"
            placeholder="Search..."
            v-model="form.search"
          />
        </form>

        <Link
          class="bg-red-500 p-2 mt-1 text-white rounded-lg hover:bg-red-700"
          v-if="params.search"
          :href="
            route('show', {
              ...params,
              search: null,
              page: null,
            })
          "
          >Remove</Link
        >
      </div>
      <div class="flex items-start justify-between">
        <label class="inline-flex items-center cursor-pointer">
          <input
            type="checkbox"
            @input="toggleStatus"
            :checked="params.inactive"
            class="sr-only peer"
          />
          <div
            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-600 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"
          ></div>
        </label>
        <div class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
          Inactive List
        </div>
      </div>
    </div>
  </div>

  <!-- Table -->
  <table
    class="bg-white dark:bg-slate-800 w-full rounded-lg overflow-hidden ring-1 ring-slate-300"
  >
    <thead>
      <tr class="bg-slate-600 text-slate-300 uppercase text-xs text-left">
        <th class="w-4/6 p-3">Title</th>
        <th class="w-2/6 p-3 text-center">Active</th>
        <th class="w-1/6 p-3 text-right">View</th>
      </tr>
    </thead>

    <tbody class="divide-y divide-slate-300 divide-dashed">
      <tr v-for="listing in listings.data" :key="listing.id">
        <td class="py-5 px-3">{{ listing.title }}</td>

        <td class="py-5 px-3 text-2xl text-center">
          <button @click.prevent="changeStatus(listing)">
            <i
              :class="`fa-solid fa-${
                listing.status
                  ? 'circle-check text-green-400'
                  : 'circle-xmark text-red-400'
              }`"
            ></i>
          </button>
        </td>

        <td class="w-1/6 py-5 px-3 text-right">
          <Link
            :href="route('listing.show', {listing: listing.id})"
            class="fa-solid fa-up-right-from-square px-3 text-indigo-400"
          ></Link>
        </td>
      </tr>
    </tbody>
  </table>

  <PaginateLink :paginator="listings" />
</template>
