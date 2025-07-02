<template>

    <div>password UUID: {{ $route.params.uuid }}</div>

    <div>
        <button @click="getPassword">Get Password</button>
        <div v-if="password">
            Password: {{ password }}
        </div>
        <div v-if="error">
            Error: {{ error }}
        </div>
    </div>

</template>

<script setup>
import { ref } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const password = ref(null)
const error = ref(null)

async function getPassword() {
    const uuid = route.params.uuid
    try {
        const response = await axios.get(`/api/password/${uuid}`)
        password.value = response.data.password
        error.value = null
    } catch (err) {
        password.value = null
        error.value = err.response?.data?.error || 'Request failed'
    }
}
</script>