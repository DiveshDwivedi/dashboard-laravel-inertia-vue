<script setup>
import Container from '../../Components/Container.vue';
import SubmitBtn from '../../Components/SubmitBtn.vue';
import SessionMessages from '../../Components/SessionMessages.vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({});

defineProps({
    status: String,
})

const submit = () => {
    form.post(route('verification.send'))
}
</script>
<template>
    <Head title="- Email Verification" />

    <Container class="w-1/2">
        <div class="mb-8">
            <p>
                Thanks for registering you account, Before getting started, could 
                you please verify your email address by clicking 
                link we just emailed to you?
                <br>
                If you didn't receive yet, we will gladly send you another.
                Please click on below button to resend.
            </p>
        </div>

        <SessionMessages :status="status" />
        <form @submit.prevent="submit">
            <SubmitBtn :disabled="form.processing">Send Verification Email</SubmitBtn>
        </form>

    </Container>
</template>