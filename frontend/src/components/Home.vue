<script setup>
defineProps({
    scanResult: String,
    scanError: String
})
</script>
<template>
    <div class="d-flex flex-column w-100 h-100">
        <div class="w-100 h-100 d-flex justify-content-center">
            <div class="d-flex flex-column justify-content-center my-auto" style="width: 350px;">
                <div class="position-relative">
                    <div v-if="scanError" class="alert alert-danger w-100">
                        {{ scanError }}
                    </div>
                    <div v-if="scanResult" class="alert alert-success w-100">
                        {{ scanResult }}
                    </div>
                    <div style="width: 350px;height: 350px;border-style: dashed;border-width:15px;border-color:transparent;"
                        class="box mb-2 position-absolute"></div>
                </div>
                <h3 class="text-center" style="transform: translateY(360px);">Scan kode QR untuk absen</h3>
                
            </div>
        </div>
    </div>
</template>

<style>

.box {
    /* --scan-color: #343430; */
    --scan-color: #ffffff;
    background-color: transparent;
    background-image:
        linear-gradient(to right, var(--scan-color) 100%, transparent 100%),
        linear-gradient(to bottom, var(--scan-color) 100%, transparent 100%),
        linear-gradient(to left, var(--scan-color) 100%, transparent 100%),
        linear-gradient(to bottom, var(--scan-color) 100%, transparent 100%),
        linear-gradient(to right, var(--scan-color) 100%, transparent 100%),
        linear-gradient(to top, var(--scan-color) 100%, transparent 100%),
        linear-gradient(to left, var(--scan-color) 100%, transparent 100%),
        linear-gradient(to top, var(--scan-color) 100%, transparent 100%);
    background-repeat: no-repeat;
    background-position:
        top left, top left,
        top right, top right,
        bottom left, bottom left,
        bottom right, bottom right;
    background-size:
        40px 14px, 14px 40px,
        40px 14px, 14px 40px,
        40px 14px, 14px 40px,
        40px 14px, 14px 40px;
}
</style>