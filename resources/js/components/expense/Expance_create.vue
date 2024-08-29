<template>
    <div class="container">
        <div class="card mt-4 mb-2">
            <div class="card-header border-bottom-0 p-4">
                <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span
                    class="text-muted h5"> /
                    Expense_Category</span>
            </div>
        </div>
        <button class="btn shadow-sm btn-primary mb-2" @click="openCreateCategoryModal()">Add Expense_Category</button>

        <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-4">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-muted" id="createCategoryModal">
                            Add Expense_Category
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body mb-2">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card rounded-lg">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="icon_text d-flex gap-2 mt-3">
                                            <p><i class="fa-solid fa-chart-line"></i></p>
                                            <p class="text-muted font-bold">Add Expense_Category</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="brand_create" enctype="multipart/form-data">
                                            <div class="row mb-1">
                                                <div class="col-md-12 mb-2">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputCategoryName" type="text"
                                                            placeholder="Enter your name" v-model="form.brand_name" />
                                                        <small class="text-danger" v-if="errors.brand_name">{{
                                                            errors.brand_name[0]
                                                        }}</small>
                                                        <label for="inputName">Brand Name</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-md-10">
                                                    <div class="form-floating mb-2 mb-md-0">
                                                        <input class="form-control p-3 px-4" id="inputFile" type="file"
                                                            @change="onFileSelect" />
                                                        <small class="text-danger" v-if="errors.image">{{
                                                            errors.image[0] }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <img :src="form.image" width="55" height="55" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3 mb-0">
                                                <div class="d-grid">
                                                    <button class="btn btn-primary w-100 mb-2" :disabled="loading">
                                                        <span v-if="loading"
                                                            class="spinner-border spinner-border-sm me-2" role="status"
                                                            aria-hidden="true"></span>
                                                        <span v-if="!loading">Login</span>
                                                        <span v-if="loading">Logging in...</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Expance_create",
    data() {
        return {
            form: {
                brand_name: null,
                image: '/backend/assets/img/pic.jpeg',
            },
            errors:{}
        }
    },
    methods: {
        openCreateCategoryModal() {
            let myModal = new bootstrap.Modal(
                document.getElementById("createCategoryModal"),
                {}
            );
            myModal.show();
        },
    }
}
</script>

<style></style>