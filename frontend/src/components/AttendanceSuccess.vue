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
        <img id="check" src="https://i.ibb.co.com/938RGQcs/check.png" alt="check" border="0">
        <h3 class="mt-3 mb-2 text-dark">Absensi Berhasil</h3>
        <RouterLink to="/home" class="btn btn-dark w-100 rounded-pill mt-3">
            Home
        </RouterLink>
    </div>
</template>

<style scoped>
    #check{
        animation: check 1.5s ease;
    }
    @keyframes check {
        0% {
            transform: translateY(-478px) rotate(-359deg);
            opacity: 0;
        }
        100% {
            transform: translateY(0px) rotate(0deg);
            opacity: 1;
        }
    }
</style>