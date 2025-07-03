<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <form @submit.prevent="submitForm" class="bg-white shadow-lg rounded-lg px-8 py-10 space-y-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">Create a Password Link</h2>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input v-model="form.password" id="password" type="text" placeholder="Enter password" required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900" />
                </div>

                <div>
                    <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-1">Expires In</label>
                    <select v-model="form.expires_at" id="expires_at" required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
                        <option v-for="option in timeOptions" :key="option.value" :value="option.value">
                            {{ option.label }}
                        </option>
                    </select>
                </div>

                <div>
                    <label for="visit_limit" class="block text-sm font-medium text-gray-700 mb-1">Visit Limit</label>
                    <input v-model.number="form.visit_limit" id="visit_limit" type="number" min="1" step="1"
                        placeholder="Enter visit limit" required
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900" />
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 font-semibold transition">
                    Submit
                </button>
            </form>

            <div v-if="generatedLink"
                class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 mt-4 text-center">
                <p class="font-medium mb-2">Password created! Here is your link:</p>
                <a :href="generatedLink" target="_blank" class="text-blue-700 underline break-all">{{ generatedLink
                    }}</a>
            </div>

            <div v-if="errorMessage"
                class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 mt-4 text-center">
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