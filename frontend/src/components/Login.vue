<template>
    <div class="container d-flex flex-column gap-12 justify-content-center w-100 h-100 align-content-center p-4">
        <div class="d-flex justify-content-center">
            <!-- <h1>LOGO</h1> -->
             <svg class="fill-current text-white inline-block h-8 w-8" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 118.4 135" style="enable-background:new 0 0 118.4 135; fill: white;transform: scale(.8) translateY(-50px)" xml:space="preserve">
                <path d="M118.3,98.3l0-62.3l0-0.2c-0.1-1.6-1-3-2.3-3.9c-0.1,0-0.1-0.1-0.2-0.1L61.9,0.8c-1.7-1-3.9-1-5.4-0.1l-54,31.1
                l-0.4,0.2C0.9,33,0.1,34.4,0,36c0,0.1,0,0.2,0,0.3l0,62.4l0,0.3c0.1,1.6,1,3,2.3,3.9c0.1,0.1,0.2,0.1,0.2,0.2l53.9,31.1l0.3,0.2
                c0.8,0.4,1.6,0.6,2.4,0.6c0.8,0,1.5-0.2,2.2-0.5l53.9-31.1c0.3-0.1,0.6-0.3,0.9-0.5c1.2-0.9,2-2.3,2.1-3.7c0-0.1,0-0.3,0-0.4
                C118.4,98.6,118.3,98.5,118.3,98.3z M114.4,98.8c0,0.3-0.2,0.7-0.5,0.9c-0.1,0.1-0.2,0.1-0.2,0.1l-20.6,11.9L59.2,92.1l-33.9,19.6
                L4.6,99.7l0,0l0,0C4.2,99.5,4,99.2,4,98.8l0-62.5l0,0l0-0.1c0-0.4,0.2-0.7,0.5-0.9l20.8-12l33.9,19.6l33.9-19.6l20.6,11.9l0.1,0
                c0.3,0.2,0.5,0.5,0.6,0.9l0,62.3L114.4,98.8L114.4,98.8z M95.3,68.6v39.4L23.1,66.4V26.9L95.3,68.6z"></path>
         </svg>
        </div>
        <div class="d-flex flex-column gap-2 px-12">
            <label for="" class="ps-3">Akun Stembayo Access</label>
            <input type="email" class="rounded-pill border-0" placeholder="NIS@student.stembayo.sch.id">
        </div>
        <div class="d-flex flex-column gap-2 px-12">
            <label for="" class="ps-3">Password</label>
            <input type="password" class="rounded-pill border-0" placeholder="Masukkan password...">
        </div>
        <div class="d-flex justify-content-center">
            <RouterLink to="/home" class="btn rounded-pill w-25 d-flex justify-content-center" style="background: oklch(64% .22 160);">
                <!-- <button class="btn btn-primary bg-primary rounded-pill w-100">Masuk</button> -->
                 Masuk
            </RouterLink>
        </div>
    </div>
</template>

<style>
input {
    height: 40px;
    padding: 10px;
}
</style>