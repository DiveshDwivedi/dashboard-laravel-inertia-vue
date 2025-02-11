<script setup>
import Container from "../../Components/Container.vue";
import Title from "../../Components/Title.vue";
import InputField from "../../Components/InputField.vue";
import TextArea from "../../Components/TextArea.vue";
import FileUpload from "../../Components/FileUpload.vue";
import ErrorMessages from "../../Components/ErrorMessage.vue";
import SessionMessage from "../../Components/SessionMessages.vue";
import SubmitBtn from "../../Components/SubmitBtn.vue";
import { useForm } from "@inertiajs/vue3";

const props = defineProps({ listing: Object, message: String });

const form = useForm({
  title: props.listing.title,
  desc: props.listing.desc,
  tags: props.listing.tags,
  email: props.listing.email,
  link: props.listing.link,
  image: null,
  _method: "PUT", // overriding post method 
});
</script>

<template>
  <Head title="- Edit Listing" />

  <Container>
    <div class="mb-6">
      <Title>Edit your listing</Title>
    </div>

    <ErrorMessages :errors="form.errors" />
    <SessionMessage :status="message" />

    <form
      @submit.prevent="form.post(route('listing.update', listing.id))"
      class="grid grid-cols-2 gap-6"
    >
      <div class="space-y-6">
        <InputField
          label="Title"
          icon="heading"
          placeholder="My new listing"
          v-model="form.title"
        />

        <InputField
          label="Tags (separate with comma)"
          icon="tags"
          placeholder="one, two, three"
          v-model="form.tags"
        />

        <TextArea
          label="Description"
          icon="newspaper"
          placeholder="This is my listing description"
          v-model="form.desc"
        />
      </div>

      <div class="space-y-6">
        <InputField
          label="Email"
          icon="at"
          placeholder="example@email.com"
          v-model="form.email"
        />

        <InputField
          label="External Link"
          icon="up-right-from-square"
          placeholder="https://example.com"
          v-model="form.link"
        />

        <FileUpload @image="(e) => (form.image = e)" :listingImage="listing.image" />
      </div>
      <div>
        <SubmitBtn :disabled="form.processing">Update</SubmitBtn>
      </div>
    </form>
  </Container>
</template>
