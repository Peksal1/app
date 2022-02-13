<template>
  <div>
    <AdminNavbar />
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
    </div>
  </div>
</template>


<script>
import axios from "axios";
import AdminNavbar from "../components/AdminNavbar.vue";
export default {
  data() {
    return {
      orders: [],
      pagination: {},
    };
  },
  components: {
    AdminNavbar,
  },
  methods: {
    getAllOrders() {
      axios.get("/api/orders").then((res) => {
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


<style  scoped>
.product-image img {
  max-width: 100%;
  width: 100%;
}
</style>