<script setup>
import Title from "../Components/Title.vue";
import PaginateLink from '../Components/PaginateLink.vue';
import SessionMessages from '../Components/SessionMessages.vue';
import { router } from "@inertiajs/vue3";

const props = defineProps({
  listings: Object,
  message: String,
});

const deleteListing = (id) => {
    if (confirm("Are you sure to delete?")) {
        router.delete(route('listing.destroy', id));
    }
}
</script>
<template>
  <Head title="- Dashboard" />
  <div v-if="listings">
    <!-- Heading Section -->
    <SessionMessages :status="message" />
    
    <div v-if="Object.keys(listings.data).length">
      <div class="flex items-center justify-between mb-4">
        <Title>Your Lisiting </Title>
        <div class="flex items-center gap-4">
          <small>Active <i class="fa-solid fa-circle-check text-green-600"></i></small>
          <small>Inactive <i class="fa-solid fa-circle-xmark text-red-600"></i></small>
        </div>
      </div>
    </div>
    <!-- Table Section -->
    <table
      class="w-full table-fixed border-collapse overflow-hidden rounded-md text-sm ring-1 ring-slate-300 dark:ring-slate-600 bg-white shadow-lg"
    >
      <thead
        class="bg-slate-300 text-xs uppercase text-slate-600 dark:bg-slate-900 dark:text-slate-400"
      >
        <tr>
          <th class="3/4 p-3 text-left">Listing Title</th>
          <th class="1/4 py-3 pr-3 text-right">View</th>
          <th class="1/5 py-3 pr-3 text-right">Edit</th>
          <th class="1/5 py-3 pr-3 text-right">Delete</th>
        </tr>
      </thead>
      <tbody>
        <tr
            v-for="listing in listings.data" :key="listing.id"
          class="border-b border-slate-200 hover:bg-slate-100 dark:bg-slate-800 dark:hover:bg-sky-600 dark:border-slate-600"
        >
        <td class="3/4 p-3 text-left">
            <div class="flex items-center gap-2">
                <img :src="listing.image? `/storage/${listing.image}` : '/storage/images/listing/bird.jpeg'" 
                    class="h-10 w-10 rounded-full object-cover object-center"
                >
            </div>
            <h4 class="font-bold">
            {{ listing.title }} 
            <i :class="`fa-solid fa-${listing.status ? 'circle-check text-green-600' : 'circle-xmark text-red-600'}`"></i>
            </h4>
        </td>

        <td class="1/4 py-3 pr-3 text-right text-indigo-400">
            <Link v-if="listing.status" :href="route('listing.show', listing.id)" > View</Link>
        </td>
        <td class="1/5 py-3 pr-3 text-right text-slate-400">
            <Link :href="route('listing.edit', listing.id)" > Edit</Link>
        </td>

        <td class="1/5 py-3 pr-3 text-right text-red-400">
            <button type="button" @click="() => deleteListing(listing.id)"> Delete </button>
        </td>
        </tr>
      </tbody>
    </table>
    <div>
      <PaginateLink :paginator="listings"/>
    </div>
  </div>
  <div v-else>
    Your Account is suspended for a reason please contanct our IT Support Team.
    <h2>Thank you</h2>
  </div>
</template>
