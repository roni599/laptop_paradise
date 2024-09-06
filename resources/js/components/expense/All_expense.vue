<template>
  <div class="container">
    <div class="card mt-4 mb-2">
      <div class="card-header border-bottom-0 p-4">
        <router-link class="text-decoration-none h5" to="/home">Dashboard</router-link><span class="text-muted h5"> /
          Expense List</span>
      </div>
    </div>

    <div class="card mb-4 tt">
      <div class="card-header d-flex justify-content-between">
        <div class="employee_table fw-bold text-muted">
          <i class="fas fa-table me-1"></i>
          Investments
        </div>
      </div>
      <div class="card-body">
        <table class="table text-muted">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Expenser Name</th>
              <th scope="col">Expense Description</th>
              <th scope="col">Expense Amount</th>
              <th scope="col">Cost Type</th>
              <th scope="col">Expense Category</th>
              <th scope="col">Payment Type</th>
              <th scope="col">Assinged By</th>
              <th scope="col">Date</th>
              <th scope="col">Status</th>
              <th scope="col">Image</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="expense in expenses" :key="expense.id">
              <td>{{ expense.id }}</td>
              <td>{{ expense.expenser.user_name }}</td>
              <td>{{ expense.expense_desc }}</td>
              <td>{{ expense.amount }}</td>
              <td v-if="expense.cost_type == 1">Fixed</td>
              <td v-else>Running</td>
              <td>{{ expense.expensecategory.category_name }}</td>
              <td>{{ expense.paymenttype.pt_name }}</td>
              <td>{{ expense.user.user_name }}</td>
              <td>{{ expense.date }}</td>
              <td>{{ expense.status }}</td>
              <td>
                <img :src="`/backend/images/expense/${expense.receipt_img}`" alt="User Image" width="50" height="50" />
              </td>
              <td>
                <div class="buttonGroup py-2">
                  <button type="button" class="btn btn-sm btn-success ms-2 mb-1" @click="openEditModal(expense)">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </button>
                  <button class="btn btn-sm btn-danger mx-2" @click="deleteBrand(expense.id)">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "All_expense",
  data() {
    return {
      expenses: [],
    }
  },
  methods: {
    async fetch_expense() {
      await axios.get("/api/expense")
        .then((res) => {
          this.expenses = res.data;
        })
        .catch((error) => {
          console.log(error.response ? error.response.data : error.message);
        })
    }
  },
  created() {
    this.fetch_expense()
  }
}
</script>

<style></style>