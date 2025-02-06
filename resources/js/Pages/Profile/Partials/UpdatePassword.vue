<script setup>
import Container from "../../../Components/Container.vue";
import InputField from "../../../Components/InputField.vue";
import SubmitBtn from "../../../Components/SubmitBtn.vue";
import ErrorMessage from "../../../Components/ErrorMessage.vue";
import Title from "../../../Components/Title.vue";
import {useForm} from '@inertiajs/vue3';

const form = useForm({
  password: "",
  current_password: "",
  password_confirmation: "",
});

const submit = () => {
  form.put(route("profile.password"), {
    onSuccess: () => form.reset(),
    onError: () => form.reset(),
    preserveScroll: true, // we won't jump on top after button click 
  });
};

</script>

<template>
  <Container class="mb-6">
   <Title> Update Password </Title> 

    <ErrorMessage :errors="form.errors"/>
    
    <form class="space-y-6" @submit.prevent="submit">
      <InputField class="w-1/2" label="Current Password" type="password" icon="key" v-model="form.current_password" />
      <InputField class="w-1/2" label="New Password" type="password" icon="key" v-model="form.password" />
      <InputField class="w-1/2" label="Confirm New Password" type="password" icon="key" v-model="form.password_confirmation" />
      <p v-if="form.recentlySuccessful" class="text-green-500 font-medium">Password Updated</p>
      <SubmitBtn :disabled="form.processing">Update Password</SubmitBtn>
    </form>
  </Container>
</template>
