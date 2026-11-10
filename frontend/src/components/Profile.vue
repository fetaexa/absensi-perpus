<script setup>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { apiRequest } from '@/services/api'

const router = useRouter()
const token = localStorage.getItem('authToken')
const profileCacheKey = `profile:${localStorage.getItem('loggedInUser') || 'current'}`
const emptyProfile = {
  nama: '',
  nisn: '',
  kelas: '',
  sekolah: '',
}

const readCachedProfile = () => {
  const cachedProfile = localStorage.getItem(profileCacheKey)
  if (!cachedProfile) return { ...emptyProfile }

  try {
    return { ...emptyProfile, ...JSON.parse(cachedProfile) }
  } catch {
    localStorage.removeItem(profileCacheKey)
    return { ...emptyProfile }
  }
}

const profile = ref(readCachedProfile())
const isSaving = ref(false)
const isSyncing = ref(true)
const isDirty = ref(false)
const errorMessage = ref('')
const successMessage = ref('')

const loadProfile = async () => {
  try {
    const response = await apiRequest('/profile', { token })
    if (!isDirty.value) {
      profile.value = { ...emptyProfile, ...response.data }
      localStorage.setItem(profileCacheKey, JSON.stringify(profile.value))
    }
  } catch (error) {
    errorMessage.value = error instanceof Error ? error.message : 'Profil gagal dimuat.'
  } finally {
    isSyncing.value = false
  }
}

const saveProfile = async () => {
  errorMessage.value = ''
  successMessage.value = ''
  isSaving.value = true

  try {
    const response = await apiRequest('/profile', {
      method: 'PUT',
      token,
      body: JSON.stringify(profile.value),
    })
    profile.value = { ...profile.value, ...response.data }
    localStorage.setItem(profileCacheKey, JSON.stringify(profile.value))
    isDirty.value = false
    successMessage.value = 'Profil berhasil disimpan.'
  } catch (error) {
    errorMessage.value = error instanceof Error ? error.message : 'Profil gagal disimpan.'
  } finally {
    isSaving.value = false
  }
}

const handleLogout = async () => {
  errorMessage.value = ''

  try {
    await apiRequest('/logout', { method: 'POST', token })
    localStorage.removeItem('authToken')
    localStorage.removeItem('isLoggedIn')
    localStorage.removeItem('loggedInUser')
    router.push('/login')
  } catch (error) {
    errorMessage.value = error instanceof Error ? error.message : 'Logout gagal. Silakan coba lagi.'
  }
}

onMounted(loadProfile)
</script>

<template>
    <form class="d-flex flex-column w-100 h-100 justify-content-between py-2" @submit.prevent="saveProfile">
        <div class="d-flex justify-content-center w-100">
            <h2>Profile</h2>
            <span v-if="isSyncing" class="visually-hidden" role="status">Memperbarui profil...</span>
        </div>
        <div class="form-field bg-4 p-4 rounded hover-lift flex-grow-1 d-flex flex-column justify-content-center my-1">
            <label for="namaSiswa" class="form-label ms-4 mb-1">Nama</label>
            <input id="namaSiswa" v-model="profile.nama" type="text" class="form-control bg-white w-100 fg-black rounded-pill p-2 ps-4" autocomplete="name" @input="isDirty = true">
        </div>
        <div class="form-field bg-4 p-4 rounded hover-lift flex-grow-1 d-flex flex-column justify-content-center my-1">
            <label for="nisnSiswa" class="form-label ms-4 mb-1">NISN</label>
            <input id="nisnSiswa" v-model="profile.nisn" type="text" class="form-control bg-white w-100 fg-black rounded-pill p-2 ps-4" @input="isDirty = true">
        </div>
        <div class="form-field bg-4 p-4 rounded hover-lift flex-grow-1 d-flex flex-column justify-content-center my-1">
            <label for="kelasSiswa" class="form-label ms-4 mb-1">Kelas</label>
            <input id="kelasSiswa" v-model="profile.kelas" type="text" class="form-control bg-white w-100 fg-black rounded-pill p-2 ps-4" @input="isDirty = true">
        </div>
        <div class="form-field bg-4 p-4 rounded hover-lift flex-grow-1 d-flex flex-column justify-content-center my-1">
            <label for="sekolahSiswa" class="form-label ms-4 mb-1">Sekolah</label>
            <input id="sekolahSiswa" v-model="profile.sekolah" type="text" class="form-control bg-white w-100 fg-black rounded-pill p-2 ps-4" @input="isDirty = true">
        </div>
        <p v-if="errorMessage" class="text-danger text-center small my-1" role="alert">{{ errorMessage }}</p>
        <p v-if="successMessage" class="text-success text-center small my-1" role="status">{{ successMessage }}</p>
        <div class="w-100 fg-black my-2 d-flex justify-content-center gap-3">
            <button type="submit" class="btn-solid px-4 py-2 rounded-pill border-0" :disabled="isSaving">
                {{ isSaving ? 'Menyimpan...' : 'Simpan profil' }}
            </button>
            <button type="button" class="btn-solid theme-danger px-4 py-2 rounded-pill border-0" @click="handleLogout">
                Logout
            </button>
        </div>
    </form>
</template>
