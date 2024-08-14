<template>
    <div class="container">
        <div class="card mt-4 mb-3">
            <div class="card-header border-bottom-0 p-3">
                <router-link class="text-decoration-none" to="/home">Dashboard</router-link><span class="text-muted"> /
                    All Product</span>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div class="employee_table">
                    <i class="fas fa-table me-1"></i>
                    Product Table
                </div>
                <div class="addNew">
                    <router-link to="/product_create" class="btn btn-sm btn-success">Add New</router-link>
                </div>
            </div>
            <div class="card-body">
                <input type="text" id="searchInput" v-model="searchProducts" placeholder="Search for ID.." />
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Product Code</th>
                            <th scope="col">Root</th>
                            <th scope="col">Buying Price</th>
                            <th scope="col">Selling Price</th>
                            <th scope="col">Buying Date</th>
                            <th scope="col">Quentity</th>
                            <th scope="col">Image</th>
                            <th scope="col">Category</th>
                            <th scope="col">Supplier</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="product in filteredProducts" :key="product.id">
                            <th scope="row">{{ product.id }}</th>
                            <td>{{ product.product_name }}</td>
                            <td>{{ product.product_code }}</td>
                            <td>{{ product.root }}</td>
                            <td>{{ product.buying_price }}</td>
                            <td>{{ product.selling_price }}</td>
                            <td>{{ product.buying_date }}</td>
                            <td>{{ product.product_quantity }}</td>
                            <td>
                                <img :src="`/backend/images/product/${product.image}`" alt="Employee Image" width="55"
                                height="55" />
                            </td>
                            <td>{{ product.category.category_name }}</td>
                            <td>{{ product.supplier.name }}</td>
                            <td>
                                <div class="buttonGroup py-2">
                                    <button type="button" class="btn btn-sm btn-success"
                                        @click="openEditModal(product)">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger mx-2" @click="deleteProduct(product.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-3">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProductModalLabel">
                            Edit Product
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mt-1">
                            <div class="col-lg-12">
                                <div class="card rounded-lg">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div class="icon_text d-flex gap-2 mt-3">
                                            <p><i class="fa-solid fa-chart-line"></i></p>
                                            <p class="text-black font-bold">Edit Product</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="updateProduct" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputProductName" type="text"
                                                            placeholder="Enter product name"
                                                            v-model="form.product_name" />
                                                        <small class="text-danger" v-if="errors.product_name">{{
                                                            errors.product_name[0]
                                                        }}</small>
                                                        <label for="inputProductName">Product Name</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputProductCode" type="text"
                                                            placeholder="Product Code" v-model="form.product_code" />
                                                        <small class="text-danger" v-if="errors.product_code">{{
                                                            errors.product_code[0]
                                                        }}</small>
                                                        <label for="inputEmail">Product Code</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputRoot" type="text"
                                                            placeholder="Root" v-model="form.root" />
                                                        <small class="text-danger" v-if="errors.root">{{
                                                            errors.root[0]
                                                        }}</small>
                                                        <label for="inputRoot">Root</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputBuyingPrice" type="text"
                                                            placeholder="Buying Price" v-model="form.buying_price" />
                                                        <small class="text-danger" v-if="errors.buying_price">{{
                                                            errors.buying_price[0]
                                                        }}</small>
                                                        <label for="Buying Price">Buying Price</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputSellingPrice" type="text"
                                                            placeholder="Selling Price" v-model="form.selling_price" />
                                                        <small class="text-danger" v-if="errors.selling_price">{{
                                                            errors.selling_price[0]
                                                        }}</small>
                                                        <label for="inputSellingPrice">Selling Price</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputBuyingDate" type="date"
                                                            placeholder="Buying Date" v-model="form.buying_date" />
                                                        <small class="text-danger" v-if="errors.buying_date">{{
                                                            errors.buying_date[0]
                                                        }}</small>
                                                        <label for="inputBuyingDate">Buying Date</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-select" aria-label="Default select example"
                                                            v-model="form.category_id">
                                                            <option v-for="category in categories" :key="category.id"
                                                                :value="category.id">
                                                                {{ category.category_name }}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-if="errors.category_id">{{
                                                            errors.category_id[0]
                                                        }}</small>
                                                        <label class="h6 text-black mb-0"
                                                            for="inputCategory">Category</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <select class="form-select" aria-label="Default select example"
                                                            v-model="form.supplier_id">
                                                            <option v-for="supplier in suppliers" :key="supplier.id"
                                                                :value="supplier.id">
                                                                {{ supplier.name }}
                                                            </option>
                                                        </select>
                                                        <small class="text-danger" v-if="errors.supplier_id">{{
                                                            errors.supplier_id[0]
                                                        }}</small>
                                                        <label class="h6 text-black mb-0"
                                                            for="inputSupplier">Supplier</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputProductQuentity"
                                                            type="text" placeholder="Product Quentity"
                                                            v-model="form.product_quantity" />
                                                        <small class="text-danger" v-if="errors.product_quantity">{{
                                                            errors.product_quantity[0]
                                                        }}</small>
                                                        <label for="inputProductQuentity">Product Quentity</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control p-3 px-4" id="inputFile" type="file"
                                                            @change="onFileSelect" />
                                                        <small class="text-danger" v-if="errors.image">{{
                                                            errors.image[0]
                                                        }}</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <img v-if="form.image !== null" :src="getimageSrc()" alt=""
                                                            width="55" height="55" />
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: "AllProduct",
    data() {
        return {
            products: [],
            searchProducts: "",
            form: {
                id: null,
                product_name: null,
                product_code: null,
                root: null,
                buying_price: null,
                selling_price: null,
                buying_date: null,
                product_quantity: null,
                category_id: null,
                supplier_id: null,
                image: "/backend/assets/img/pic.jpeg",
            },
            errors: {},
            categories: [],
            suppliers: [],
        };
    },
    created() {
        this.fetchProducts()
        axios.get("/api/categories").then((res) => {
            this.categories = res.data;
        });
        axios.get("/api/suppliers").then((res) => {
            this.suppliers = res.data;
        });
    },
    computed: {
        filteredProducts() {
            return this.products.filter((product) => {
                return (
                    product.id.toString().includes(this.searchProducts) || product.product_name.toString().includes(this.searchProducts)
                );
            });
        },
    },
    methods: {
        async fetchProducts() {
            await axios.get('/api/products')
                .then((res) => {
                    this.products = res.data;
                }).
                catch((error) => {

                });
        },

        getimageSrc() {
            if (this.form.image) {
                if (this.form.image.startsWith("data")) {
                    return this.form.image;
                } else {
                    return `/backend/images/product/${this.form.image}`;
                }
            }
            return "";
        },
        onFileSelect(event) {
            let file = event.target.files[0];
            if (file.size > 1048576) {
                Toast.fire({
                    icon: "warning",
                    title: "image must be less then 1 mb!",
                });
            } else {
                let reader = new FileReader();
                reader.onload = (event) => {
                    this.form.image = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        },
        openEditModal(product) {
            this.form = { ...product };
            let myModal = new bootstrap.Modal(
                document.getElementById("editProductModal"),
                {}
            );
            myModal.show();
        },
        async updateProduct() {
            await axios
                .put("/api/products/update", this.form)
                .then((res) => {
                    console.log(res)
                    this.fetchProducts();
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("editProductModal")
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
        async deleteProduct(id) {
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
                        .delete("/api/products/delete/" + id)
                        .then((res) => {
                            this.products = this.products.filter((product) => {
                                return product.id != id;
                            });
                        })
                        .catch((error) => {
                            this.$router.push({ name: "All_product" });
                        });
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
                    });
                }
            });
        },
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
    width: 75%;
    height: 93vh;
    margin: auto;
}
</style>
