<template>
    <div>
        <div>
            <div>
                <h2>
                    Reveal Your Password
                </h2>
                <button @click="revealPassword">
                    Show Password
                </button>
            </div>

            <div v-if="showPassword && password">
                <span>Password:</span>
                <span>{{ password }}</span>
                <button @click="copyToClipboard()">{{ buttonText }}</button>
            </div>

            <div v-if="showPassword && error">
                {{ error }}
            </div>

            <router-link to="/">
                <button>
                    Create a new password
                </button>
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