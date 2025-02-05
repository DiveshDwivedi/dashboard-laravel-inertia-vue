<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import TextLink from "../../Components/TextLink.vue";
import InputField from "../../Components/InputField.vue";
import SubmitBtn from "../../Components/SubmitBtn.vue";
import ErrorMessage from "../../Components/ErrorMessage.vue";
import {useForm} from '@inertiajs/vue3';

const props = defineProps({
    token: String,
    email: String,
})

const form = useForm({
  token: props.token,
  email: props.email,
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("password.update"), {
    onFinish: () => form.reset("password", 'password_confirmation'),
  });
};

</script>

<template>
  <Container class="w-1/2">
    <div class="mb-8 text-center">
      <Title>Enter your new password</Title>

    </div>

    <ErrorMessage :errors="form.errors"/>
    
    <form class="space-y-6" @submit.prevent="submit">

      <InputField label="Email" type="email" icon="at" v-model="form.email" />

      <InputField label="Password" type="password" icon="key" v-model="form.password" />
      
      <InputField
        label="Confirm Password"
        type="password"
        icon="key"
        v-model="form.password_confirmation"
      />

      <SubmitBtn :disabled="form.processing">Reset your password</SubmitBtn>
    </form>
  </Container>
</template>
