<template>
    <div class="d-flex flex-row bg bg-subtle-primary w-100 align-items-center ps-6"
        style="height: 15%;border-radius: 0 0 40px 40px;">
        <!-- <h3>Topbar</h3> -->
        <div class="rounded-circle bg bg-accent hid" style="width: 50px; height: 50px;" :style="{ opacity: profileOpacity, transition: 'opacity .4s ease'}"></div>
        <div class="d-flex flex-column ms-4 hid"  :style="{ opacity: profileOpacity, transition: 'opacity .4s ease'}">
            <h5>Selamat datang</h5>
            <h4>Budi!</h4>
        </div>
    </div>
</template>

<script setup>
defineProps({
    profileOpacity: {
        type: Number,
        default: 1
    }
})
</script>