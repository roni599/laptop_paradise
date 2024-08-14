<template>
    <div class="container">
        <div class="card mt-4 mb-3">
            <div class="card-header border-bottom-0 p-3">
                <router-link class="text-decoration-none" to="/home">Dashboard</router-link><span class="text-muted"> /
                    All Category</span>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div class="employee_table">
                    <i class="fas fa-table me-1"></i>
                    Category Table
                </div>
                <div class="addNew">
                    <router-link to="/category_create" class="btn btn-sm btn-success">Add New</router-link>
                </div>
            </div>
            <div class="card-body">
                <input type="text" id="searchInput" v-model="searchCategory" placeholder="Search for ID.." />
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Category ID</th>
                            <th scope="col">Category Name</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="category in filteredCategories" :key="category.id">
                            <th scope="row">{{ category.id }}</th>
                            <td>{{ category.category_name }}</td>
                            <td>
                                <div class="buttonGroup py-2">
                                    <button type="button" class="btn btn-sm btn-success"
                                        @click="openEditModal(category)">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger mx-2" @click="deleteCategory(category.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="editCategoriesModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoriesModal">
                            Edit Category
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <div class="card rounded-lg">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="icon_text d-flex gap-2 mt-3">
                                            <p><i class="fa-solid fa-chart-line"></i></p>
                                            <p class="text-black font-bold">Edit Category</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="updateSupplier" enctype="multipart/form-data">
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
                                                    <button type="submit" class="btn btn-primary btn-block">
                                                        Update
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
import axios from "axios";

export default {
    name: "AllCategory",

    data() {
        return {
            categories: [],
            searchCategory: "",
            form: {
                id: null,
                categoryName: null,
            },
            errors: {},
        };
    },

    computed: {
        filteredCategories() {
            return this.categories.filter((category) => {
                return (
                    category.id.toString().includes(this.searchCategory) ||
                    category.category_name.toString().includes(this.searchCategory)
                );
            });
        },
    },

    methods: {
        fetchCategories() {
            axios
                .get("/api/categories")
                .then((response) => {
                    this.categories = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },

        openEditModal(category) {
            this.form.id = category.id;
            this.form.categoryName = category.category_name;
            let myModal = new bootstrap.Modal(document.getElementById("editCategoriesModal"),{});
            myModal.show();
        },

        async deleteCategory(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then(async (result) => {
                if (result.isConfirmed) {
                    await axios
                        .delete("/api/categories/delete/" + id)
                        .then((res) => {
                            this.categories = this.categories.filter((category) => {
                                return category.id != id;
                            });
                        })
                        .catch((error) => {
                            this.$router.push({ name: "All_category" });
                        });
                    Swal.fire({
                        title: "Deleted!",
                        text: "Category has been deleted.",
                        icon: "success",
                    });
                }
            });
        },

        async updateSupplier() {
            await axios
                .put("/api/categories/update", this.form)
                .then((res) => {
                    this.fetchCategories();
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("editCategoriesModal")
                    );
                    myModal.hide();
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
    },

    mounted() {
        if (!User.loggedIn()) {
            this.$router.push({ name: "LoginForm" });
        } else {
            this.fetchCategories();
        }
    },
};
</script>

<style scoped>
#searchInput {
    background-image: url("/backend/assets/img/searchicon.png");
    background-position: 10px 12px;
    background-repeat: no-repeat;
    width: 100%;
    font-size: 16px;
    padding: 12px 20px 12px 40px;
    border: 1px solid #ddd;
    margin-bottom: 12px;
}

.full-width-modal {
    max-width: 100%;
    max-height: 100vh;
}

.full-width-modal .modal-content {
    width: 60%;
    height: 50vh;
    margin: auto;
}
</style>