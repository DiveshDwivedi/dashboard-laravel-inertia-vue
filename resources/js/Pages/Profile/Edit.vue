<script setup>
import UpdateInfo from "./Partials/UpdateInfo.vue";

defineProps({
  status: String,
  user: Object,
});

</script>
<template>
  <Head title="- Profile" />
  <UpdateInfo :user="user" :status="status" />
</template>
