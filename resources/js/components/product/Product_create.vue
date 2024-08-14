<template>
    <div class="container">
        <div class="card mt-4">
            <div class="card-header border-bottom-0 p-3">
                <router-link class="text-decoration-none" to="/home">Dashboard</router-link><span class="text-muted"> /
                    Product-Create</span>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card rounded-lg mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="icon_text d-flex gap-2 mt-3">
                            <p><i class="fa-solid fa-chart-line"></i></p>
                            <p class="text-black font-bold">Employee Insert</p>
                        </div>
                        <div class="code">
                            <router-link class="btn btn-sm btn-success" to="/all_product">All Product</router-link>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="product_create" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputProductName" type="text"
                                            placeholder="Enter product name" v-model="form.product_name" />
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
                                        <input class="form-control" id="inputRoot" type="text" placeholder="Root"
                                            v-model="form.root" />
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
                                        <label class="h6 text-black mb-0" for="inputCategory">Category</label>
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
                                        <label class="h6 text-black mb-0" for="inputSupplier">Supplier</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputProductQuentity" type="text"
                                            placeholder="Product Quentity" v-model="form.product_quantity" />
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
                                        <img :src="form.image" width="55" height="55" />
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
    name: "Product_create",
    data() {
        return {
            form: {
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
            categories: [],
            suppliers: [],
            errors: {},
        };
    },
    created() {
        axios.get("/api/categories").then((res) => {
            this.categories = res.data;
        });
        axios.get("/api/suppliers").then((res) => {
            this.suppliers = res.data;
        });
    },
    methods: {
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
        getimageSrc() {
            if (this.form.image) {
                if (this.form.image.startsWith("data")) {
                    return this.form.image;
                } else {
                    return `/backend/images/employee/${this.form.image}`;
                }
            }
            return "";
        },
        async product_create() {
            await axios.post('/api/products/store', this.form)
                .then((res) => {
                    this.form = ''
                    Toast.fire({
                        icon: "success",
                        title: res.data.message
                    });
                    this.$router.push({ name: 'All_product' })
                })
                .catch((error) => {
                    this.errors = error.response.data.errors
                })
        }
    }

};
</script>

<style></style>
