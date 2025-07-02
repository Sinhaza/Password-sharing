<template>
    <div>
        <button @click="revealPassword">Show Password</button>
        <div v-if="showPassword && password">
            Password: {{ password }}
        </div>
        <div v-if="error">
            {{ error }}
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
        error.value = err.response?.data?.error || 'The password you are trying to access is either expired or has never existed in the first place'
    }
}

function revealPassword() {
    showPassword.value = true
}
</script>