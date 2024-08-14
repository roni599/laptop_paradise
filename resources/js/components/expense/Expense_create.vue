<template>
    <div class="container">
        <div class="card mt-4">
            <div class="card-header border-bottom-0 p-3">
                <router-link class="text-decoration-none" to="/home">Dashboard</router-link><span class="text-muted"> /
                    Expense-Create</span>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-12">
                <div class="card rounded-lg mt-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="icon_text d-flex gap-2 mt-3">
                            <p><i class="fa-solid fa-chart-line"></i></p>
                            <p class="text-black font-bold">Expense Insert</p>
                        </div>
                        <div class="code">
                            <router-link class="btn btn-sm btn-success" to="/all_expense">All Expense</router-link>
                        </div>
                    </div>
                    <div class="card-body">
                        <form @submit.prevent="expense_create" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputCategoryName" type="textarea"
                                            placeholder="Enter your name" v-model="form.details" />
                                        <small class="text-danger" v-if="errors.details">{{
                                            errors.details[0]
                                        }}</small>
                                        <label for="inputName">Details</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <div class="form-floating mb-3 mb-md-0">
                                        <input class="form-control" id="inputCategoryName" type="text"
                                            placeholder="Enter your name" v-model="form.amount" />
                                        <small class="text-danger" v-if="errors.amount">{{
                                            errors.amount[0]
                                        }}</small>
                                        <label for="inputName">Amount</label>
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
export default {
    name: "Expense_create",
    mounted() {
        if (!User.loggedIn()) {
            this.$router.push({ name: "LoginForm" });
        }
    },
    data() {
        return {
            form: {
                details: null,
                amount: null
            },
            errors: {},
        };
    },
    methods: {
        async expense_create() {
            await axios
                .post("/api/expenses/store", this.form)
                .then((res) => {
                    this.form = "";
                    Toast.fire({
                        icon: "success",
                        title: res.data.message,
                    });
                    this.$router.push({ name: "All_expense" });
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                });
        },
    },
}
</script>

<style></style>