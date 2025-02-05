<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import TextLink from "../../Components/TextLink.vue";
import InputField from "../../Components/InputField.vue";
import SubmitBtn from "../../Components/SubmitBtn.vue";
import ErrorMessage from "../../Components/ErrorMessage.vue";
import {useForm} from '@inertiajs/vue3';

const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset(),
  });
};

</script>

<template>
  <Container class="w-1/2">
    <div class="mb-8 text-center">
      <Title>Register a new account</Title>

      <p>Already have account? <TextLink label="Login" routeName="login" /></p>
    </div>

    <ErrorMessage :errors="form.errors"/>
    
    <form class="space-y-6" @submit.prevent="submit">
      <InputField label="Name" icon="id-badge" v-model="form.name" />

      <InputField label="Email" type="email" icon="at" v-model="form.email" />

      <InputField label="Password" type="password" icon="key" v-model="form.password" />
      
      <InputField
        label="Confirm Password"
        type="password"
        icon="key"
        v-model="form.password_confirmation"
      />

      <p class="text-slate-500 text-sm dark:text-slate-400">
        By Crearting an account, you agree to our Terms of Serices and Privacy Policy.
      </p>

      <SubmitBtn :disabled="form.processing">Register</SubmitBtn>
    </form>
  </Container>
</template>
