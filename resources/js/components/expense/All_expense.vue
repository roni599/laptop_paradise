<template>
    <div class="container">
        <div class="card mt-4 mb-3">
            <div class="card-header border-bottom-0 p-3">
                <router-link class="text-decoration-none" to="/home">Dashboard</router-link><span class="text-muted"> /
                    All Expenses</span>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between">
                <div class="employee_table">
                    <i class="fas fa-table me-1"></i>
                    Expeses Table
                </div>
                <div class="addNew">
                    <router-link to="/expense_create" class="btn btn-sm btn-success">Add New</router-link>
                </div>
            </div>
            <div class="card-body">
                <input type="text" id="searchInput" v-model="searchExpenses" placeholder="Search for ID.." />
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Expense ID</th>
                            <th scope="col">Expense Details</th>
                            <th scope="col">Expense Amount</th>
                            <th scope="col">Expense Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="expense in filteredExpenses" :key="expense.id">
                            <th scope="row">{{ expense.id }}</th>
                            <td>{{ expense.details }}</td>
                            <td>{{ expense.amount }}</td>
                            <td>{{ expense.created_at }}</td>
                            <td>
                                <div class="buttonGroup py-2">
                                    <button type="button" class="btn btn-sm btn-success"
                                        @click="openEditModal(expense)">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger mx-2" @click="deleteExpense(expense.id)">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="editExpensesModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog full-width-modal mt-5">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editExpensesModal">
                            Edit Expense
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
                                            <p class="text-black font-bold">Edit Expense</p>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <form @submit.prevent="updateExpenses" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <div class="form-floating mb-3 mb-md-0">
                                                        <input class="form-control" id="inputCategoryName"
                                                            type="textarea" placeholder="Enter your name"
                                                            v-model="form.details" />
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
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "AllExpense",
    data() {
        return {
            expenses: [],
            searchExpenses: "",
            form: {
                id: null,
                details: null,
                amount: null
            },
            errors: {},
        };
    },
    computed: {
        filteredExpenses() {
            return this.expenses.filter((expense) => {
                return (
                    expense.id.toString().includes(this.searchExpenses) || expense.details.toString().includes(this.searchExpenses)
                );
            });
        },
    },
    methods: {
        fetchExpenses() {
            axios
                .get("/api/expenses")
                .then((response) => {
                    this.expenses = response.data;
                })
                .catch((error) => {
                    console.error(error);
                });
        },
        openEditModal(expense) {
            this.form.id = expense.id;
            this.form.details = expense.details;
            this.form.amount = expense.amount;
            let myModal = new bootstrap.Modal(document.getElementById("editExpensesModal"), {});
            myModal.show();
        },
        async updateExpenses() {
            await axios
                .put("/api/expenses/update", this.form)
                .then((res) => {
                    this.fetchExpenses();
                    let myModal = bootstrap.Modal.getInstance(
                        document.getElementById("editExpensesModal")
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
        async deleteExpense(id) {
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
                        .delete("/api/expenses/delete/" + id)
                        .then((res) => {
                            console.log(res)
                            this.expenses = this.expenses.filter((expense) => {
                                return expense.id != id;
                            });
                        })
                        .catch((error) => {
                            this.$router.push({ name: "All_expense" });
                        });
                    Swal.fire({
                        title: "Deleted!",
                        text: "Category has been deleted.",
                        icon: "success",
                    });
                }
            });
        },

    },
    mounted() {
        if (!User.loggedIn()) {
            this.$router.push({ name: "LoginForm" });
        } else {
            this.fetchExpenses();
        }
    },
}
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
    height: 65vh;
    margin: auto;
}
</style>