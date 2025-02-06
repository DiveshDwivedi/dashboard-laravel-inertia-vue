<script setup>
import DeleteAccount from "./Partials/DeleteAccount.vue";
import UpdateInfo from "./Partials/UpdateInfo.vue";
import UpdatePassword from "./Partials/UpdatePassword.vue";

defineProps({
  status: String,
  user: Object,
});

</script>
<template>
  <Head title="- Profile" />
  <UpdateInfo :user="user" :status="status" />
  <UpdatePassword :user="user" />
  <DeleteAccount />
</template>
