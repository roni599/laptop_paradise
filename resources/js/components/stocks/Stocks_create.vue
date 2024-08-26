<template>
  <div class="container">
    <div class="card mt-4 mb-2">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link>
        <span class="text-muted h5"> / Stocks-Create</span>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="card rounded-lg mt-2">
          <div class="card-header d-flex justify-content-between align-items-center">
            <div class="icon_text d-flex gap-2 mt-3">
              <p><i class="fa-solid fa-chart-line"></i></p>
              <p class="text-black font-bold">Stocks Create</p>
            </div>
            <div class="code">
              <router-link class="btn btn-sm btn-success" to="/all_stocks">All Stocks</router-link>
            </div>
          </div>
          <div class="card-body">
            <div class="card-body">
              <form @submit.prevent="handleSubmit" v-show="visible">
                <div class="row mb-3">
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <select class="form-select" aria-label="Default select example" v-model="form.product_id">
                        <option v-for="product in products" :key="product.id" :value="product.id">{{
                          product.product_model }}</option>
                      </select>
                      <small class="text-danger" v-if="errors.product_id">{{
                        errors.product_id[0]
                      }}</small>
                      <label for="inputPhone">Product Model</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <select class="form-select" readonly aria-label="Default select example" v-model="form.user_id">
                        <option :value="users.id">
                          {{ users.user_name }}
                        </option>
                      </select>
                      <small class="text-danger" v-if="errors.edit_user_id">{{
                        errors.edit_user_id[0]
                      }}</small>
                      <label for="inputAddress">Users Name</label>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <input class="form-control" id="inputDate" type="date" v-model="form.stock_date" />
                      <small class="text-danger" v-if="errors.stock_date">{{ errors.stock_date[0] }}</small>
                      <label for="inputDate">Stock Date</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <input class="form-control" v-model="form.stock_quantity" type="text" id="inputQuantity"
                        required />
                      <small class="text-danger" v-if="errors.stock_quantity">{{ errors.stock_quantity[0] }}</small>
                      <label for="inputQuantity">Quantity</label>
                    </div>
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <input class="form-control" v-model="form.buying_price" type="text" id="buyingPrice" />
                      <small class="text-danger" v-if="errors.buying_price">{{ errors.buying_price[0] }}</small>
                      <label for="buyingPrice">Buying Price</label>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-floating mb-3 mb-md-0">
                      <input class="form-control" v-model="form.selling_price" type="text" id="sellingPrice" />
                      <small class="text-danger" v-if="errors.selling_price">{{ errors.selling_price[0] }}</small>
                      <label for="sellingPrice">Selling Price</label>
                    </div>
                  </div>
                </div>
                <div class="mt-2 mb-0">
                  <div class="d-grid">
                    <button class="btn btn-primary btn-block">Submit</button>
                  </div>
                </div>
              </form>
              <div v-if="rows.length > 0">
                <form @submit.prevent="handleDynamicSubmit">
                  <div v-for="(row, index) in rows" :key="index" class="form-row d-flex mb-3">
                    <input v-model="row.sl_no" type="number" :placeholder="'Sl No ' + (index + 1)" min="1" required />
                    <input v-model="row.name" type="text" :placeholder="'Name ' + (index + 1)" required />
                    <div class="form-floating mb-3 mb-md-0">
                      <input class="form-control p-3 px-4" type="file" @change="handleImageUpload(index, $event)" />
                      <small class="text-danger" v-if="row.errors.image">{{ row.errors.image[0] }}</small>
                    </div>
                    <div class="col-md-1">
                      <div class="form-floating mb-3 mb-md-0">
                        <img :src="row.image" width="55" height="55" />
                      </div>
                    </div>
                  </div>
                  <button type="submit">Submit All Rows</button>
                </form>
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
import { inject } from 'vue';
export default {
  name: "Stocks_create",
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      form: {
        product_id: null,
        user_id: null,
        stock_date: null,
        stock_quantity: null,
        buying_price: null,
        selling_price: null,
      },
      errors: {},
      users: [],
      products: [],
      rows: [],
      userName,
      profile_img,
      visible: true,
    };
  },
  methods: {
    handleSubmit() {
      console.log(this.form)
      this.rows = [];
      this.visible = false;
      for (let i = 0; i < this.form.stock_quantity; i++) {
        this.rows.push({
          sl_no: "",
          name: "",
          image: "/backend/assets/img/pic.jpeg",
          errors: {},
        });
      }
    },
    handleImageUpload(index, event) {
      let file = event.target.files[0];
      if (file.size > 1048576) {
        Toast.fire({
          icon: "warning",
          title: "Image must be less than 1 MB!",
        });
      } else {
        let reader = new FileReader();
        reader.onload = (e) => {
          this.rows[index].image = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
    handleDynamicSubmit() {
      console.log(this.rows);
    },
    async fetchUsers() {
      const token = localStorage.getItem('token');
      await axios.get("/api/auth/me", {
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
        .then((res) => {
          this.userName = res.data.user_name;
          this.profile_img = res.data.profile_img
          this.users = res.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    async fetch_product() {
      await axios.get("/api/products")
        .then((res) => {
          this.products = res.data;
        })
        .catch((error) => {
          console.log(error);
        })
    },
  },
  created() {
    this.fetchUsers();
    this.fetch_product();
  }
};

</script>

<style></style>
