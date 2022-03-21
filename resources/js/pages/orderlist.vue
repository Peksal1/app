<template>
  <div>
    <AdminNavbar />
    <div class="container d-flex justify-content-center mt-5 p-4">
      <div class="input-group mb-3">
        <input v-model="searchKeyword" type="text" class="form-control" />
        <div class="input-group-append">
          <button @click="getAllOrders" class="btn btn-primary">Search</button>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-md-3" v-for="order in orders" :key="order.id">
          <div class="card">
            <div class="card-body">
              <div class="product-image">
                <img :src="`/images/${order.file_path}`" alt="" />
              </div>
              <div class="title">{{ order.text }}</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12 text-center center-pagination">
        <Pagination
          :pagination="pagination"
          @perPage="getAllOrders()"
          @paginate="getAllOrders()"
          :offset="6"
        >
        </Pagination>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import AdminNavbar from "../components/AdminNavbar.vue";
import Pagination from "../components/Pagination.vue";
export default {
  data() {
    return {
      orders: [],
      searchKeyword: "",
      adminToken: localStorage.getItem("adminToken"),
      pagination: {
        data: [],
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
      },
    };
  },
  components: {
    AdminNavbar,
    Pagination,
  },
  methods: {
    getAllOrders() {
      axios
        .get(
          `/api/orders?page=${this.pagination.current_page}&searchKeyword=${this.searchKeyword}`,
          {
            headers: {
              Authorization: "Bearer " + this.adminToken,
            },
          }
        )
        .then((res) => {
          this.orders = res.data.data;
          this.pagination = res.data;
        });
    },
  },
  created() {
    this.getAllOrders();
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Heebo:wght@500&display=swap");

.form-control {
  border-radius: 7px;
  border: 1.5px solid #e3e6ed;
}

.product-image img {
  max-width: 100%;
  width: 100%;
}

input.form-control:focus {
  box-shadow: none;
  border: 1.5px solid #e3e6ed;
  background-color: #f7f8fd;
  letter-spacing: 1px;
}

.btn-primary {
  background-color: #5878ff !important;
  border-radius: 7px;
}

.btn-primary:focus {
  box-shadow: none;
}
</style>