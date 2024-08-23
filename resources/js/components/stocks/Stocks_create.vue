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
            <form @submit.prevent="handleSubmit" v-show="visible">
              <label for="quantity">Enter Quantity:</label>
              <input v-model.number="quantity" type="number" id="quantity" min="1" required />
              <button type="submit">Submit</button>
            </form>

            <div v-if="rows.length > 0">
              <form @submit.prevent="handleDynamicSubmit">
                <div v-for="(row, index) in rows" :key="index" class="form-row d-flex">
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
</template>

<script>
export default {
  name: "Stocks_create",
  data() {
    return {
      quantity: 1,
      rows: [],
      visible:true
    };
  },
  methods: {
    handleSubmit() {
      this.rows = [];
      this.visible=false
      for (let i = 0; i < this.quantity; i++) {
        this.rows.push({
          sl_no: '',
          image: '/backend/assets/img/pic.jpeg',
          name: '',
          errors:{}
        });
      }
    },
    handleImageUpload(index, event) {
      let file = event.target.files[0];
      if (file.size > 1048576) {
        Toast.fire({
          icon: "warning",
          title: "Image must be less than 1 MB!"
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
  },

}
</script>

<style></style>
