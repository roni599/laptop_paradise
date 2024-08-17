<template>
    <div class="container">
        <div class="card mt-4 mb-2">
            <div class="card-header border-bottom-0 p-4">
                <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span
                    class="text-muted h5"> /
                    Brands</span>
            </div>
        </div>
        <button class="btn shadow-sm btn-primary mb-2" @click="openCreateBrandModal()">Add Brand</button>

        <div class="card mb-4 tt">
            <div class="card-header d-flex justify-content-between">
                <div class="employee_table fw-bold text-muted">
                    <i class="fas fa-table me-1"></i>
                    Roles
                </div>
            </div>
            <div class="card-body">
                <table class="table text-muted">
                    <thead>
                        <tr>
                            <th scope="col">#ID</th>
                            <th scope="col">Brand Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="createBrandModal" tabindex="-1" aria-labelledby="createRoleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-4">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-muted" id="createBrandModal">
                            Add Role
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
                                            <p class="text-muted font-bold">Add Role</p>
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
import axios from 'axios';

export default {
    name: "Brand-vue",
    data() {
        return {
            form: {
                brand_name: null,
                image: '/backend/assets/img/pic.jpeg',
            },
            loading: false,
            errors: {}
        }
    },
    methods: {
        onFileSelect(event) {
            let file = event.target.files[0]
            if (file.size > 1048576) {
                Toast.fire({
                    icon: "warning",
                    title: "image must be less then 1 mb!"
                });
            }
            else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.form.image = event.target.result;
                }
                reader.readAsDataURL(file);
            }
        },

        openCreateBrandModal() {
            let myModal = new bootstrap.Modal(
                document.getElementById("createBrandModal"),
                {}
            );
            myModal.show();
        },
        async brand_create() {
            this.loading = true
            await axios.post('/api/brands/store', this.form)
                .then((res) => {
                    console.log(res);
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
                .finally(() => {
                    this.loading = false
                })
        }
    }
}
</script>

<style></style>