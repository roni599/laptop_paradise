<template>
  <div class="container-fluid px-4">
    <div class="card mt-4">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span class="text-muted h5"> /
          Overview</span>
      </div>
    </div>
    <div class="row mt-4">
      <div class="col-xl-3 col-md-6">
        <div class="card bg-primary text-white mb-4">
          <div class="card-body">Primary Card</div>
          <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#">View Details</a>
            <div class="small text-white">
              <i class="fas fa-angle-right"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card bg-warning text-white mb-4">
          <div class="card-body">Warning Card</div>
          <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#">View Details</a>
            <div class="small text-white">
              <i class="fas fa-angle-right"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card bg-success text-white mb-4">
          <div class="card-body">Success Card</div>
          <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#">View Details</a>
            <div class="small text-white">
              <i class="fas fa-angle-right"></i>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-md-6">
        <div class="card bg-danger text-white mb-4">
          <div class="card-body">Danger Card</div>
          <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="#">View Details</a>
            <div class="small text-white">
              <i class="fas fa-angle-right"></i>
            </div>
          </div>
        </div>
      </div>
      <p>{{ nnn }}</p>
    </div>
  </div>
</template>

<script>
export default {
  name: "Home-vue",
  // mounted() {
  //   if (!User.loggedIn()) {
  //     this.$router.push({ name: "LoginForm" });
  //   }
  // },
  data() {
    return {
      nnn:''
    };
  },
  mounted(){
    let name=localStorage.getItem('user');
    this.nnn=name;
  }
};
</script>

<style></style>