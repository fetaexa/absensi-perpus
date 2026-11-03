<template class="w-100 h-100">
    <div class="d-flex flex-column w-100 h-100 justify-content-between py-2">
        <div class="d-flex justify-content-center w-100">
            <h2>Profile</h2>
        </div>
        <div class="form-field bg-4 p-5 rounded hover-lift flex-grow-1 d-flex flex-column justify-content-center my-1">
            <label for="namaSiswa" class="form-label ms-4 mb-1">Nama</label>
            <input id="namaSiswa" type="text" class="form-control bg-white w-100 fg-black rounded-pill p-2 ps-4">
        </div>
        <div class="form-field bg-4 p-5 rounded hover-lift flex-grow-1 d-flex flex-column justify-content-center my-1">
            <label for="nisSiswa" class="form-label ms-4 mb-1">NIS</label>
            <input id="nisSiswa" type="text" class="form-control bg-white w-100 fg-black rounded-pill p-2 ps-4">
        </div>
        <div class="form-field bg-4 p-5 rounded hover-lift flex-grow-1 d-flex flex-column justify-content-center my-1">
            <label for="kelasSiswa" class="form-label ms-4 mb-1">Kelas</label>
            <input id="kelasSiswa" type="text" class="form-control bg-white w-100 fg-black rounded-pill p-2 ps-4">
        </div>
        <div class="form-field bg-4 p-5 rounded hover-lift flex-grow-1 d-flex flex-column justify-content-center my-1">
            <label for="sekolahSiswa" class="form-label ms-4 mb-1">Sekolah</label>
            <input id="sekolahSiswa" type="text" class="form-control bg-white w-100 fg-black rounded-pill p-2 ps-4">
        </div>
        <div class="w-100 fg-black my-2 d-flex justify-content-center">
            <RouterLink to="/login" class="rounded-pill w-25 d-flex justify-content-center">
                <button class="btn-solid theme-danger px-4 py-2 rounded-pill border-0">
                    Logout
                </button>
            </RouterLink>
        </div>
    </div>
</template>