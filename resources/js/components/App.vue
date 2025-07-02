<template>
    <form @submit.prevent="submitForm">
        <input v-model="form.name" type="text" placeholder="Name" required>
        <input v-model="form.email" type="email" placeholder="Email" required>
        <button type="submit">Submit</button>
    </form>
</template>

<script setup>
import { reactive } from 'vue'
import axios from 'axios'

const form = reactive({
    name: '',
    email: ''
})

const submitForm = async () => {
    try {
        await axios.post('/api/users', form)
        // Optionally reset form or show success message
    } catch (error) {
        // Handle validation errors or other issues
    }
}
</script>