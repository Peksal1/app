<template>
  <div>
    <Navbar />
    <div class="container">
      <div class="row">
        <div class="col-md-3" v-for="order in orders" :key="order.id">
          <div class="card">
            <div class="card-body">
              <div class="product-image">
                <img :src="`/portfolio/${order.file_path}`" alt="" />
              </div>
              <div class="title">{{ order.work_name }}</div>
              <div class="title">{{ order.category }}</div>
              <div class="title">{{ order.description }}</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
export default {
  data() {
    return {
      orders: [],
      pagination: {},
    };
  },
  components: {
    Navbar,
  },
  methods: {
    getAllOrders() {
      axios.get("/api/portfolio").then((res) => {
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