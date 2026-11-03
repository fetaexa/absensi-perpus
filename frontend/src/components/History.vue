<script setup>
import { onMounted, ref } from 'vue'

const mockBackendHistory = [
    {
        id: 1,
        date: '2026-10-13T08:00:00.000Z',
        time: '13/10/2026 08:00',
        room: 'Ruang Baca Hening',
        subject: 'Pelajaran KIK',
        status: 'Hadir',
    },
    {
        id: 2,
        date: '2026-10-12T08:15:00.000Z',
        time: '12/10/2026 08:15',
        room: 'Ruang Baca Hening',
        subject: 'Pelajaran KIK',
        status: 'Hadir',
    },
]

const history = ref([])

const fetchAttendanceHistory = () => {
    return new Promise((resolve) => {
        setTimeout(() => {
            const savedHistory = JSON.parse(localStorage.getItem('attendanceHistory') || '[]')
            resolve(savedHistory.length ? savedHistory : mockBackendHistory)
        }, 150)
    })
}

onMounted(async () => {
    history.value = await fetchAttendanceHistory()
})
</script>

<template>
    <div class="d-flex flex-column w-100" style="margin-bottom: 200px;">
        <div class="d-flex justify-content-center w-100">
            <h2>History</h2>
        </div>

        <div v-if="history.length === 0" class="text-center text-muted mt-4">
            Belum ada data absensi.
        </div>

        <div v-for="item in history" :key="item.id || item.qrCode || item.time" class="bg bg-white w-100 fg-black mt-3 rounded-3 p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h4>{{ item.time || new Date(item.date).toLocaleDateString('id-ID', { day: '2-digit', month: 'long', year: 'numeric' }) }}</h4>
                <span class="badge bg-success rounded-pill px-3 py-2">{{ item.status || 'Hadir' }}</span>
            </div>
            <h5 class="mb-1">{{ item.subject || 'Pelajaran KIK' }} di {{ item.room || 'Ruang Baca Hening' }}</h5>
            <small class="text-muted">{{ item.qrCode || 'Kode QR' }}</small>
        </div>
    </div>
</template>