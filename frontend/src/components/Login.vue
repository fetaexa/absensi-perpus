<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const email = ref('')
const password = ref('')
const errorMessage = ref('')
const isSubmitting = ref(false)

const demoCredential = {
  email: 'siswa@student.stembayo.sch.id',
  password: 'stembayo123'
}

const handleLogin = () => {
  const trimmedEmail = email.value.trim()
  const trimmedPassword = password.value.trim()

  if (!trimmedEmail || !trimmedPassword) {
    errorMessage.value = 'Email dan password wajib diisi.'
    return
  }

  const emailPattern = /^[^\s@]+@student\.stembayo\.sch\.id$/i
  if (!emailPattern.test(trimmedEmail)) {
    errorMessage.value = 'Format email tidak valid. Gunakan format NIS@student.stembayo.sch.id.'
    return
  }

  if (trimmedPassword.length < 6) {
    errorMessage.value = 'Password minimal 6 karakter.'
    return
  }

  if (trimmedEmail !== demoCredential.email || trimmedPassword !== demoCredential.password) {
    errorMessage.value = 'Akun atau password salah. Gunakan demo account: ' + demoCredential.email + ' / ' + demoCredential.password
    return
  }

  isSubmitting.value = true
  localStorage.setItem('isLoggedIn', 'true')
  localStorage.setItem('loggedInUser', trimmedEmail)

  setTimeout(() => {
    router.push({ path: '/home' })
  }, 300)
}
</script>

<template>
    <form class="container d-flex flex-column gap-12 justify-content-center w-100 h-100 align-content-center p-4" @submit.prevent="handleLogin">
        <div class="d-flex justify-content-center flex-column">
            <svg class="fill-current text-white inline-block h-8 w-8 mx-auto mt-1" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 118.4 135" style="enable-background:new 0 0 118.4 135; fill: white;transform: scale(.8) translateY(-50px)" xml:space="preserve">
                <path d="M118.3,98.3l0-62.3l0-0.2c-0.1-1.6-1-3-2.3-3.9c-0.1,0-0.1-0.1-0.2-0.1L61.9,0.8c-1.7-1-3.9-1-5.4-0.1l-54,31.1
                l-0.4,0.2C0.9,33,0.1,34.4,0,36c0,0.1,0,0.2,0,0.3l0,62.4l0,0.3c0.1,1.6,1,3,2.3,3.9c0.1,0.1,0.2,0.1,0.2,0.2l53.9,31.1l0.3,0.2
                c0.8,0.4,1.6,0.6,2.4,0.6c0.8,0,1.5-0.2,2.2-0.5l53.9-31.1c0.3-0.1,0.6-0.3,0.9-0.5c1.2-0.9,2-2.3,2.1-3.7c0-0.1,0-0.3,0-0.4
                C118.4,98.6,118.3,98.5,118.3,98.3z M114.4,98.8c0,0.3-0.2,0.7-0.5,0.9c-0.1,0.1-0.2,0.1-0.2,0.1l-20.6,11.9L59.2,92.1l-33.9,19.6
                L4.6,99.7l0,0l0,0C4.2,99.5,4,99.2,4,98.8l0-62.5l0,0l0-0.1c0-0.4,0.2-0.7,0.5-0.9l20.8-12l33.9,19.6l33.9-19.6l20.6,11.9l0.1,0
                c0.3,0.2,0.5,0.5,0.6,0.9l0,62.3L114.4,98.8L114.4,98.8z M95.3,68.6v39.4L23.1,66.4V26.9L95.3,68.6z"></path>
            </svg>
            <h3 class="text-center text-dark">
            Apus Ganesha
            </h3>
        </div>

        <div class="d-flex flex-column gap-2 px-12">
            <label for="email" class="ps-3">Akun Stembayo Access</label>
            <input id="email" v-model="email" type="email" class="rounded-pill border-0" placeholder="NIS@student.stembayo.sch.id" autocomplete="username">
        </div>

        <div class="d-flex flex-column gap-2 px-12 login-password-field">
            <label for="password" class="ps-3">Password</label>
            <input id="password" v-model="password" type="password" class="rounded-pill border-0" placeholder="Masukkan password..." autocomplete="current-password">
            <Transition name="login-popover">
                <div v-if="errorMessage" class="login-error-popover" role="alert" aria-live="assertive">
                    <span class="login-error-icon" aria-hidden="true">!</span>
                    <span class="login-error-message">{{ errorMessage }}</span>
                    <button type="button" class="login-error-dismiss" aria-label="Tutup pesan error" @click="errorMessage = ''">
                        &times;
                    </button>
                </div>
            </Transition>
        </div>

        <div class="d-flex justify-content-center">
            <button type="submit" class="btn rounded-pill w-25 d-flex justify-content-center border-0" style="background: oklch(64% .22 160); color: white;" :disabled="isSubmitting">
                {{ isSubmitting ? 'Memuat...' : 'Masuk' }}
            </button>
        </div>
    </form>
</template>

<style>
input {
    height: 40px;
    padding: 10px;
}

button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.login-password-field {
    position: relative;
}

.login-error-popover {
    position: relative;
    display: flex;
    align-items: flex-start;
    gap: 10px;
    width: 100%;
    padding: 12px 14px;
    color: #842029;
    text-align: left;
    background: #fff3f3;
    border: 1px solid #f1b8bd;
    border-radius: 14px;
    box-shadow: 0 8px 24px rgb(75 20 25 / 14%);
}

.login-error-popover::before {
    position: absolute;
    top: -7px;
    left: calc(50% - 7px);
    width: 12px;
    height: 12px;
    content: '';
    background: #fff3f3;
    border-top: 1px solid #f1b8bd;
    border-left: 1px solid #f1b8bd;
    transform: rotate(45deg);
}

.login-error-icon {
    display: inline-flex;
    flex: 0 0 20px;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    color: white;
    font-size: 13px;
    font-weight: 700;
    background: #c93745;
    border-radius: 50%;
}

.login-error-message {
    flex: 1;
    font-size: 13px;
    line-height: 1.45;
    overflow-wrap: anywhere;
}

.login-error-dismiss {
    flex: 0 0 auto;
    padding: 0;
    color: #842029;
    font-size: 20px;
    line-height: 1;
    background: transparent;
    border: 0;
    cursor: pointer;
}

.login-popover-enter-active,
.login-popover-leave-active {
    transition: opacity 0.18s ease, transform 0.18s ease;
}

.login-popover-enter-from,
.login-popover-leave-to {
    opacity: 0;
    transform: translateY(-6px);
}
</style>