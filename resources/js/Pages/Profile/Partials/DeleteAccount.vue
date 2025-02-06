<script setup>
import Container from "../../../Components/Container.vue";
import InputField from "../../../Components/InputField.vue";
import SubmitBtn from "../../../Components/SubmitBtn.vue";
import ErrorMessage from "../../../Components/ErrorMessage.vue";
import Title from "../../../Components/Title.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const isDelete = ref(false);

const form = useForm({
  password: "",
});

const submit = () => {
  form.delete(route("profile.delete"), {
    onSuccess: () => form.reset(),
    onError: () => form.reset(),
    preserveScroll: true, 
  });
};
</script>

<template>
  <Container>
    <Title> Delete Account </Title>
    <p class="mb-2 text-red-600">
      Once your account is deleted you will lose your data and won't recover
    </p>
    <ErrorMessage :errors="form.errors" />
    <div v-show="isDelete">
      <form class="flex items-end gap-3" @submit.prevent="submit">
        <InputField
          class="w-1/2"
          label="Password"
          type="password"
          icon="key"
          v-model="form.password"
        />

        <SubmitBtn class="bg-red-600" :disabled="form.processing"
          >Delete Account</SubmitBtn
        >

        <button
          @click="isDelete = false"
          type="button"
          class="bg-green-500 text-white px-6 py-2 rounded-lg"
        >
          Cancel
        </button>
      </form>
    </div>

    <button
      v-show="!isDelete"
      @click="isDelete = true"
      type="button"
      class="bg-red-500 text-white px-6 py-2 rounded-lg"
    >
      <i class="fa-solid fa-triangle-exclamation mr-2"></i> Delete Account
    </button>
  </Container>
</template>
