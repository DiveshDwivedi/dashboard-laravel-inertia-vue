<script setup>
import Container from "../../Components/Container.vue";
import InputField from "../../Components/InputField.vue";
import SubmitBtn from "../../Components/SubmitBtn.vue";
import ErrorMessage from "../../Components/ErrorMessage.vue";
import {useForm} from '@inertiajs/vue3';

const form = useForm({
  password: "",
});


const submit = () => {
  form.post(route("password.confirm"), {
    onFinish: () => form.reset(),
  });
};

</script>

<template>
  <Container class="w-1/2">
    <div class="mb-8 text-center">
      <p>Please type your password and confirm</p>
    </div>

    <ErrorMessage :errors="form.errors"/>
    
    <form class="space-y-6" @submit.prevent="submit">

      <InputField label="Password" type="password" icon="key" v-model="form.password" />

      <SubmitBtn :disabled="form.processing">Confirm</SubmitBtn>
    </form>
  </Container>
</template>
