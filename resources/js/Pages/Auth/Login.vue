<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import TextLink from "../../Components/TextLink.vue";
import InputField from "../../Components/InputField.vue";
import SubmitBtn from "../../Components/SubmitBtn.vue";
import CheckBox from "../../Components/CheckBox.vue";
import ErrorMessage from "../../Components/ErrorMessage.vue";
import { router, useForm } from "@inertiajs/vue3";
import SessionMessages from "../../Components/SessionMessages.vue";

const form = useForm({
  email: "",
  password: "",
  remember: null,
});

defineProps({
  status: String,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
  });
};

const ssoLogin = () => {
  alert("login with Google");
  // router.get(route('redirect', {provider: 'google'}))
  window.location.href = route("redirect", { provider: "google" });
};
</script>

<template>
  <Container class="w-1/2">
    <div class="mb-8 text-center">
      <Title>Login to your account</Title>
      <p>Need an account? <TextLink label="Register" routeName="register" /></p>
    </div>

    <ErrorMessage :errors="form.errors" />
    <SessionMessages :status="status" />

    <form class="space-y-6" @submit.prevent="submit">
      <InputField label="Email" type="email" icon="at" v-model="form.email" />

      <InputField label="Password" type="password" icon="key" v-model="form.password" />

      <div class="flex items-center justify-between">
        <CheckBox v-model="form.remember" name="remeber">Remeber me</CheckBox>
        <TextLink routeName="password.request" label="Forgot Password" />
      </div>
      <div class="flex items-center justify-between">
        <SubmitBtn :disabled="form.processing">Login</SubmitBtn>

        <button
          class="px-4 py-2 rounded-lg bg-slate-950 text-white disabled:bg-slate-300 disabled:cursor-wait"
          @click="ssoLogin"
          type="Button"
        >
          <span class="flex items-center gap-1">
            <img
              class="w-7 h-7rounded-full mr-1"
              src="https://cdn-icons-png.flaticon.com/512/720/720255.png"
              alt=""
            />
            Sign in with Google
          </span>
        </button>
      </div>
    </form>
  </Container>
</template>
