<script setup>
import Container from "../../../Components/Container.vue";
import Title from "../../../Components/Title.vue";
import InputField from "../../../Components/InputField.vue";
import SubmitBtn from "../../../Components/SubmitBtn.vue";
import SessionMessages from "../../../Components/SessionMessages.vue";
import ErrorMessage from "../../../Components/ErrorMessage.vue";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps({
  user: Object,
  status: String,
});

const form = useForm({
  name: props?.user?.name,
  email: props?.user?.email,
});

const submit = () => {
  form.patch(route("profile.info"));
};

// manual visit inertia
const resendEmail = (e) => {
  router.post(
    route("verification.send"), // route to send
    {}, // data to send
    {
      onStart: () => (e.target.disabled = true), // actions
      onFinish: () => (e.target.disabled = false),
    }
  );
};
</script>

<template>
  <Container class="mb-6">
    <div class="mb-6">
      <Title> Update User Info</Title>
      <p>Update your account's profile information and email address</p>
    </div>
    <ErrorMessage :errors="form.errors" />
    <SessionMessages :status="status" />
    <form class="space-y-6" @submit.prevent="submit">
      <InputField label="Name" icon="id-badge" class="w-1/2" v-model="form.name" />
      <InputField
        label="Email"
        icon="at"
        type="email"
        class="w-1/2"
        v-model="form.email"
      />

      <div v-if="user.email_verified_at === null" class="flex items-center gap-2">
        <p>your email address is unverified?</p>

        <button
          @click="resendEmail"
          class="text-indigo-500 font-medium dark:text-indigo-400 disabled:text-slate-400 disabled:cursor-wait"
        >
          Click here to re-send the email verifications
        </button>
      </div>

      <SubmitBtn :disabled="form.processing">Update</SubmitBtn>
    </form>
  </Container>
</template>
