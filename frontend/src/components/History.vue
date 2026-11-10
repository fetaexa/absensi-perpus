<script setup>
import { onMounted, ref } from 'vue'
import { apiRequest } from '@/services/api'

const history = ref([])
const isLoading = ref(true)
const errorMessage = ref('')

const formatDate = (date) => {
    if (!date) return ''

    return new Date(date).toLocaleString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    })
}

onMounted(async () => {
    try {
        const response = await apiRequest('/absensi', {
            token: localStorage.getItem('authToken'),
        })
        history.value = response.data
    } catch (error) {
        errorMessage.value = error instanceof Error ? error.message : 'Riwayat absensi gagal dimuat.'
    } finally {
        isLoading.value = false
    }
})
</script>

<template>
    <div class="d-flex flex-column w-100" style="margin-bottom: 200px;">
        <div class="d-flex justify-content-center w-100">
            <h2>History</h2>
        </div>

        <div v-if="isLoading" class="text-center text-muted mt-4" role="status">
            Memuat riwayat...
        </div>
        <div v-else-if="errorMessage" class="alert alert-danger mt-4" role="alert">
            {{ errorMessage }}
        </div>
        <div v-else-if="history.length === 0" class="text-center text-muted mt-4">
            Belum ada data absensi.
        </div>

        <div v-for="item in history" :key="item.id" class="bg bg-white w-100 fg-black mt-3 rounded-3 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4>{{ formatDate(item.created_at) }}</h4>
                <span class="badge bg-success rounded-pill px-3 py-2">Hadir</span>
            </div>
        </div>
    </div>
</template>
