<script setup>
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()

const qrCode = computed(() => {
    const value = route.query.qr
    return value ? decodeURIComponent(String(value)) : 'QR Code'
})

const backHome = () => {
    router.push({ name: 'home' })
}
</script>

<template>
    <div class="d-flex flex-column w-100 h-100 justify-content-center align-items-center px-3">
        <div class="bg-white rounded-4 shadow-sm p-4 text-center" style="max-width: 420px; width: 100%;">
            <div class="mb-3">
                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 72px; height: 72px; font-size: 2rem;">
                    ✓
                </div>
                <h3 class="mb-2 text-dark">Absensi Berhasil</h3>
                <p class="text-muted mb-3">Anda sudah tercatat hadir.</p>
            </div>

            <div class="bg-light rounded-3 p-3 mb-3 text-start">
                <small class="text-muted d-block mb-1">Kode QR</small>
                <strong class="text-dark small">{{ qrCode }}</strong>
            </div>

            <button class="btn btn-dark w-100 rounded-pill" @click="backHome">
                Kembali ke Home
            </button>
        </div>
    </div>
</template>
