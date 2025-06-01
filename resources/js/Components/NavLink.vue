<script setup>
// import { switchTheme } from "../theme";

defineProps({
  routeName: String,
  Name: String,
});
</script>

<template>
  <Link 
  :href="route(routeName)" 
  class="px-3 py-3 rounded-lg hover:bg-slate-600"
  :class="{'bg-slate-700' : $page.component === Name}"
    ><slot
  /></Link>
</template>
