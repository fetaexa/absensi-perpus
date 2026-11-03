<script setup>
import { ref, computed } from 'vue'
import { RouterView, useRoute, useRouter } from 'vue-router'
import { QrcodeStream } from 'vue-qrcode-reader'
import TopBar from '@/components/TopBar.vue'
import BottomBar from '@/components/BottomBar.vue'

const route = useRoute()
const router = useRouter()
const isImmersive = computed(() => route.path === '/history' || route.path === '/profile')

const isHome = computed(() => route.path === '/' || route.path === '/home')
const isSuccessRoute = computed(() => route.name === 'absent-success' || route.path.includes('absent-success'))
const result = ref('')
const error = ref('')
const lastScannedCode = ref('')

const normalizeQrPayload = (rawValue) => {
    const value = (rawValue || '').trim()
    const now = new Date()
    const entry = {
        id: Date.now(),
        date: now.toISOString(),
        time: now.toLocaleString('id-ID', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        }),
        room: 'Ruang Baca Hening',
        subject: 'Pelajaran KIK',
        status: 'Hadir',
        qrCode: value,
    }

    if (!value) return entry

    const pairs = value.split(/[;|]/).map((item) => item.trim()).filter(Boolean)

    for (const pair of pairs) {
        const [key, ...rest] = pair.split('=')
        const cleanedKey = (key || '').trim().toLowerCase()
        const cleanedValue = rest.join('=').trim()

        if (!cleanedKey || !cleanedValue) continue

        if (cleanedKey === 'room') entry.room = cleanedValue
        if (cleanedKey === 'subject' || cleanedKey === 'mapel') entry.subject = cleanedValue
        if (cleanedKey === 'kelas') entry.className = cleanedValue
        if (cleanedKey === 'kode') entry.qrCode = cleanedValue
    }

    return entry
}

const saveAttendance = (rawValue) => {
    const attendance = normalizeQrPayload(rawValue)
    const currentHistory = JSON.parse(localStorage.getItem('attendanceHistory') || '[]')
    const nextHistory = [attendance, ...currentHistory].slice(0, 30)

    localStorage.setItem('attendanceHistory', JSON.stringify(nextHistory))
    return attendance
}

const isLikelyUrl = (value) => {
    if (!value || typeof value !== 'string') return false
    return /^https?:\/\//i.test(value) || /^www\./i.test(value)
}

const onDetect = (detectedCodes) => {
    const rawValue = detectedCodes?.[0]?.rawValue

    if (!rawValue) return

    if (lastScannedCode.value && rawValue === lastScannedCode.value && result.value) {
        return
    }

    lastScannedCode.value = rawValue

    if (isLikelyUrl(rawValue)) {
        console.log('QR link detected:', rawValue)
    }

    const attendance = saveAttendance(rawValue)
    result.value = `Berhasil absen: ${attendance.subject} (${attendance.room})`
    error.value = ''

    setTimeout(() => {
        router.push({
            name: 'absent-success',
            query: {
                qr: encodeURIComponent(attendance.qrCode || rawValue),
                source: 'qr-link'
            }
        })
    }, 700)
}

const onError = (err) => {
  if (err.name === 'NotAllowedError') {
    error.value = 'Izin akses kamera ditolak oleh pengguna.'
  } else if (err.name === 'NotFoundError') {
    error.value = 'Tidak ada kamera yang ditemukan di perangkat ini.'
  } else if (err.name === 'NotSupportedError') {
    error.value = 'Konteks tidak aman (harus HTTPS atau localhost).'
  } else {
    error.value = err.message
  }
}
</script>

<style scoped>
main {
    overflow-y: auto;
    overflow-x: hidden;
    
}

html::-webkit-scrollbar,
body::-webkit-scrollbar {
    display: none;
}

.topBarWrapper{
    min-height: 110px;
}

.content-inner {
    min-height: 100%;
    padding-top: 110px;
    padding-bottom: 70px;
    transition: padding 0.4s ease;
}

.content-inner.is-immersive {
    padding-top: 0;
    padding-bottom: 0;
}
</style>

<style>
.page-slide-enter-active,
.page-slide-leave-active {
    transition: transform .45s ease, opacity .45s ease;
}

.page-slide-enter-from {
    transform: translateY(10px) scale(.98);
    opacity: 0;
}

.page-slide-leave-to {
    transform: translateY(-20px) scale(.96);
    opacity: 0;
}

.absent-success-transition-enter-active,
.absent-success-transition-leave-active {
    transition: all 1.55s cubic-bezier(0.22, 1, 0.36, 1);
}

.absent-success-transition-enter-from {
    transform: translateY(278px) scale(.82);
    opacity: 0;
}

.absent-success-transition-leave-to {
    transform: scale(.72);
    opacity: 0;
    filter: blur(2px);
}

</style>

<template>
    <div class="position-relative vh-100 w-100 overflow-hidden">
        <main class="position-absolute top-0 start-0 w-100 h-100 overflow-y-auto overflow-x-hidden mt-12">
            <div class=" content-inner d-flex flex-column align-items-center p-3" :class="{ 'is-immersive' : isImmersive }">
                <div class="position-absolute w-100 d-flex flex-column align-items-center pt-4"
                style="top: 0;left: 0;z-index: 0;pointer-events: none;margin-top: 20%;animation-delay: 2s;" :style="{ opacity: isHome ? 1 : 0, transition: 'opacity .45s ease'}">
                    <div style="width: 350px; height: 350px;overflow: hidden;pointer-events: auto;">
                        <div class="d-flex justify-content-center align-items-center loadingCam" style="background: white;width: 350px;height: 349px;z-index: 12;opacity: 1; position: relative;">
                            <h3 style="color: black;">Loading...</h3>
                        </div>
                        <QrcodeStream @detect="onDetect" @error="onError" style="background: transparent;z-index: 19; transform: translateY(-350px); width: 350px; height: 350px;" />
                        <!-- <h3 style="color: black;transform: translateY(-170px) translateX(38%);z-index: 5;">Loading...</h3> -->
                    </div>
                </div>
                <div class="w-100 h-100" style="z-index: 10;">
                    <RouterView v-slot="{ Component, route }">
                        <Transition :name="isSuccessRoute ? 'absent-success-transition' : 'page-slide'" mode="out-in">
                                <component :is="Component" :key="route.fullPath" :scan-result="result" :scan-error="error" />
                        </Transition>
                    </RouterView>
                </div>
            </div>
        </main>
        
        <TopBar class="position-absolute top-0 start-0 w-100 z-menu" :style="{ transform: isImmersive ? 'translateY(-80px)' : 'translateY(0px)', transition: 'transform 0.4s ease' }" :profile-opacity="isImmersive ? 0 : 1" />
        <BottomBar class="position-absolute bottom-0 start-0 w-100 z-menu" />
    </div>
</template>
