<template>
    <div class=" d-flex flex-row bg bg-subtle-primary w-100 align-items-center ps-6"
        style="height: 15%;border-radius: 40px 40px 0 0;">
        <div class="d-flex flex-row justify-content-between w-100">
            <RouterLink to="/home">
                <div class="d-flex flex-column">
                    <i class="bi bi-house justify-content-center"></i>
                    <h5>Home</h5>
                </div>
            </RouterLink>
            <RouterLink to="/history">
                <div>
                    <i class="bi bi-calendar justify-content-center"></i>
                    <h5>History</h5>
                </div>
            </RouterLink>
            <RouterLink to="/profile">
                <div>
                    <i class="bi bi-person-circle justify-content-center"></i>
                    <h5>Profile</h5>
                </div>
            </RouterLink>
        </div>
    </div>
</template>

<style>
i {
    display: flex;
    font-size: 2rem;
    height: 40px;
}
a{
    color: white;
    text-decoration: none;
    transition: .3s ease;
}
a:hover{
    transform: translateY(5px);
    filter: brightness(.6);
}
/* *{
    text-decoration: none;
    opacity: 1;
} */
</style>