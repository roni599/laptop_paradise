<template>
  <div class="container">
    <div class="card mt-4 mb-2">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span class="text-muted h5"> /
          Expense Category</span>
      </div>
    </div>
    <button class="btn shadow-sm btn-primary mb-2" @click="openCreateCategoryModal()">Expense Category Create</button>

    <div class="modal fade" id="createCategoryModal" tabindex="-1" aria-labelledby="createCategoryLabel"
      aria-hidden="true">
      <div class="modal-dialog full-width-modal mt-4">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-muted" id="createCategoryModal">
              Creste Expence
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
                    <form @submit.prevent="category_create" enctype="multipart/form-data">
                      <div class="row mb-1">
                        <div class="col-md-12 mb-2">
                          <div class="form-floating mb-3 mb-md-0">
                            <input class="form-control" id="inputCategoryName" type="text" v-model="form.ecname" />
                            <small class="text-danger" v-if="errors.ecname">{{
                              errors.ecname[0]
                            }}</small>
                            <label for="inputName">Expense Category Name</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-md-12">
                          <div class="form-floating mb-2">
                            <select class="form-select" readonly aria-label="Default select example"
                              v-model="form.user_id">
                              <option :value="users.id">
                                {{ users.user_name }}
                              </option>
                            </select>
                            <small class="text-danger" v-if="errors.user_id">{{
                              errors.user_id[0]
                            }}</small>
                            <label for="inputAddress">Users Name</label>
                          </div>
                        </div>
                      </div>
                      <div class="row mb-1">
                        <div class="col-md-10">
                          <div class="form-floating mb-2 mb-md-0">
                            <input class="form-control p-3 px-4" id="inputFile" type="file" @change="onFileSelect" />
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
                            <span v-if="loading" class="spinner-border spinner-border-sm me-2" role="status"
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
import { inject } from 'vue';
export default {
  name: "Expance_create",
  data() {
    const userName = inject('userName');
    const profile_img = inject('profile_img');
    return {
      form: {
        ecname: null,
        user_id: null,
        image: '/backend/assets/img/pic.jpeg',
      },
      userName,
      profile_img,
      users: [],
      errors: {},
      loading: false
    }
  },
  methods: {
    async category_create() {
      await axios.get("/api/expensecategory")
        .then((res) => {
          console.log(res)
        })
        .catch((error) => {
          this.errors = error.response.data.errors
        })
    },
    openCreateCategoryModal() {
      let myModal = new bootstrap.Modal(
        document.getElementById("createCategoryModal"),
        {}
      );
      myModal.show();
    },
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
  },
  created() {
    this.fetchUsers();
  }
}
</script>

<style>
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
  height: 68vh;
  margin: auto;
}
</style>