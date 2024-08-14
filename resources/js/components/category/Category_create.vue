<template>
    <div class="container">
        <div class="card mt-4">
            <div class="card-header border-bottom-0 p-4">
                <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span
                    class="text-muted h5"> /
                    Category-Create</span>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card rounded-lg mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="icon_text d-flex gap-2 mt-3">
                            <p><i class="fa-solid fa-chart-line"></i></p>
                            <p class="text-black font-bold">Category Insert</p>
                        </div>
                        <div class="code">
                            <router-link class="btn btn-sm btn-success" to="/all_category">All Category</router-link>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="category_create" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputCategoryName" type="text"
                                            placeholder="Enter your name" v-model="form.categoryName" />
                                        <small class="text-danger" v-if="errors.categoryName">{{
                                            errors.categoryName[0]
                                        }}</small>
                                        <label for="inputName">Category Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 mb-0">
                                <div class="d-grid">
                                    <button class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";

export default {
    name: "Category_create",
    mounted() {
        if (!User.loggedIn()) {
            this.$router.push({ name: "LoginForm" });
        }
    },
    data() {
        return {
            form: {
                categoryName: null,
            },
            errors: {},
        };
    },
    methods: {
        async category_create() {
            await axios
                .post("/api/categories/store", this.form)
                .then((res) => {
                    this.form = "";
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                    this.$router.push({ name: "All_category" });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
    },
};
</script>

<style scoped></style>