<template>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="bg-white shadow-xl rounded-2xl px-8 py-10 space-y-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4 text-center">
                    Reveal Your Password
                </h2>
                <button @click="revealPassword"
                    class="w-full flex justify-center items-center gap-2 py-2 px-4 border border-transparent rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 font-semibold">
                    Show Password
                </button>
            </div>

            <div v-if="showPassword && password"
                class="bg-green-50 border border-green-200 text-green-800 rounded-lg p-4 text-center mt-4">
                <span class="font-medium">Password:</span>
                <span class="ml-2 font-mono tracking-wide text-lg">{{ password }}</span>

                <button
                    class="w-full flex justify-center items-center gap-2 py-2 px-4 mt-3 border border-transparent rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 font-semibold"
                    @click="copyToClipboard()">{{ buttonText }}</button>
            </div>

            <div v-if="showPassword && error"
                class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-4 text-center mt-4">
                {{ error }}
            </div>

            <router-link to="/">
                <button
                    class="w-full flex justify-center items-center gap-2 py-2 px-4 border border-transparent rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 font-semibold">
                    Create a new password</button>
            </router-link>

        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const password = ref(null)
const error = ref(null)
const showPassword = ref(false)
const buttonText = ref('Copy to clipboard')

onMounted(async () => {
    await getPassword()
})

async function getPassword() {
    const uuid = route.params.uuid
    try {
        const response = await axios.get(`/api/password/${uuid}`)
        password.value = response.data.password
        error.value = null
    } catch (err) {
        password.value = null
        error.value = err.response?.data?.error || 'The password you are trying to access has either expired or has never existed in the first place'
    }
}

function copyToClipboard() {
    navigator.clipboard.writeText(password.value)
    buttonText.value = 'Copied!'
    setTimeout(() => {
        buttonText.value = 'Copy to clipboard'
    }, 1500)
}

function revealPassword() {
    showPassword.value = true
}
</script>