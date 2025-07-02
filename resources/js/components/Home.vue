<template>
    <div>
        <div>
            <form @submit.prevent="submitForm">
                <h2>Create a Password Link</h2>

                <div>
                    <label for="password">Password</label>
                    <input v-model="form.password" id="password" type="text" placeholder="Enter password" required />
                </div>

                <div>
                    <label for="expires_at">Expires In</label>
                    <select v-model="form.expires_at" id="expires_at" required>
                        <option v-for="option in timeOptions" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>

                <div>
                    <label for="visit_limit">Visit Limit</label>
                    <input v-model.number="form.visit_limit" id="visit_limit" type="number" min="1" step="1"
                        placeholder="Enter visit limit" required />
                </div>

                <button type="submit">
                    Submit
                </button>
            </form>

            <div v-if="generatedLink">
                <p>Password created! Here is your link:</p>
                <a :href="generatedLink" target="_blank">{{ generatedLink }}</a>
            </div>

            <div v-if="errorMessage">
                {{ errorMessage }}
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import axios from 'axios'

const generatedLink = ref('')
const errorMessage = ref('')

const form = reactive({
    password: '',
    expires_at: '',
    visit_limit: ''
})

const timeOptions = [
    { label: "In 1 minute", value: 1 },
    { label: "In 15 minutes", value: 15 },
    { label: "In 30 minutes", value: 30 },
    { label: "In an hour", value: 60 },
    { label: "In 2 hours", value: 120 }
];




const submitForm = async () => {
    try {

        const now = new Date();
        const minutesToAdd = parseInt(form.expires_at, 10);
        const futureDate = new Date(now.getTime() + minutesToAdd * 60000);

        const pad = n => String(n).padStart(2, '0');
        const expires_at =
            futureDate.getFullYear() + '-' +
            pad(futureDate.getMonth() + 1) + '-' +
            pad(futureDate.getDate()) + ' ' +
            pad(futureDate.getHours()) + ':' +
            pad(futureDate.getMinutes()) + ':' +
            pad(futureDate.getSeconds());

        const payload = {
            password: form.password,
            expires_at: expires_at,
            visit_limit: form.visit_limit
        };

        const response = await axios.post('api/password', payload);
        generatedLink.value = response.data.link
        errorMessage.value = ''
    } catch (error) {
        this.errorMessage = 'An error occurred';
    }
}
</script>