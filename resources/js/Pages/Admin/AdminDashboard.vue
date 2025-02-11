<script setup>
import PaginateLink from '../../Components/PaginateLink.vue'
defineProps({
    users: Object,
})
</script>

<template>
  <Head title="- Admin Dashboard" />
  <!-- Heading -->
  <div>Heading</div>

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
          <p class="font-bold mb-1">{{user.name}}</p>
          <p class="font-light text-xs">{{user.email}}</p>
        </td>
        <td class="w-2/6 py-5 px-3">
            {{user.role}}
        </td>
        <td class="w-1/6 py-5 px-3">
        <div class="flex items-center gap-3">
            <div  class="flex items-center gap-1">
                <p>{{user.listings.filter(l => l.status == true).length}}</p>
                <i class="fa-solid fa-circle-check text-green-500"></i>
            </div>
            <div class="flex items-center gap-1">
               <p>{{user.listings.filter(l => l.status == false).length}}</p> 

                <i class="fa-solid fa-circle-xmark text-red-500"></i>
            </div>
        </div>
            
        </td>
        <td class="w-1/6 py-5 px-3 text-right">
            View link
        </td>
      </tr>
    </tbody>
  </table>

  <div class="mt-6">
    <PaginateLink :paginator="users" />
  </div>
</template>
