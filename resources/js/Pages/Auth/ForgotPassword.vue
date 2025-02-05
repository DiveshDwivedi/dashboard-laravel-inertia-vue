<script setup>
import Container from "../../Components/Container.vue";
import InputField from "../../Components/InputField.vue";
import SubmitBtn from "../../Components/SubmitBtn.vue";
import ErrorMessage from "../../Components/ErrorMessage.vue";
import SessionMessages from "../../Components/SessionMessages.vue";
import {useForm} from '@inertiajs/vue3';

const form = useForm({
  email: "",
});

defineProps({status: String});

const submit = () => {
  form.post(route("password.email"));
};

</script>

<template>
  <Container class="w-1/2">
    <div class="mb-8 text-center">
        <p> Forgot your Password? 
        Please write your email below to reset password
        </p>
    </div>

    <ErrorMessage :errors="form.errors"/>

    <SessionMessages :status="status"/>
    
    <form class="space-y-6" @submit.prevent="submit">

      <InputField label="Email" type="email" icon="at" v-model="form.email" />

      <SubmitBtn :disabled="form.processing">Rest Password link </SubmitBtn>
    </form>
  </Container>
</template>
