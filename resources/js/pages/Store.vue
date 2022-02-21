<template>
  <div>
    <AdminNavbar />
    <div class="container d-flex justify-content-center mt-5 p-4">
      <div class="input-group mb-3">
        <input v-model="searchKeyword" type="text" class="form-control" />
        <div class="input-group-append">
          <button @click="getAllItems" class="btn btn-primary">Search</button>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div
          v-if="!isPaymentLoading"
          class="col-md-3"
          v-for="shop in shops"
          :key="shop.id"
        >
          <div class="card">
            <div class="card-body">
              <div class="product-image">
                <img :src="`/sale/${shop.file_path}`" alt="" />
              </div>
              <div class="title">Art name: {{ shop.work_name }}</div>
              <div class="title">Description: {{ shop.description }}</div>
              <div class="title">Category: {{ shop.category }}</div>
              <div class="title">Price: {{ shop.price_in_eur }} EUR</div>

              <div class="buy-btn mt-3">
                <div
                  @click="buyProduct(shop.id)"
                  class="btn btn-block btn-primary"
                >
                  Buy Now
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else>
          <div class="text-center">
            <h2>Payment Page Loading</h2>
          </div>
        </div>
      </div>
      <div class="col-md-12 text-center center-pagination">
        <Pagination
          :pagination="pagination"
          @perPage="getAllItems()"
          @paginate="getAllItems()"
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
      shops: [],
      searchKeyword: "",
      isPaymentLoading: false,
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
    buyProduct(id) {
      this.isPaymentLoading = true;
      axios
        .post(
          "/api/create-payment-session",
          {
            product: id,
          },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        )
        .then((response) => {
          this.redirectToStripe(response.data.session_id);
        })
        .catch((error) => {
          console.log(error);
        })
        .finally(() => {
          this.isPaymentLoading = false;
        });
    },
    redirectToStripe(sessionID) {
      let stripe = Stripe("pk_test_d6aChIuFov53M3i5n00Fn1j200m37XdpTE");
      stripe
        .redirectToCheckout({
          sessionId: sessionID,
        })
        .then((res) => {
          console.log(res);
        });
    },
    getAllItems() {
      axios
        .get(
          `/api/store?page=${this.pagination.current_page}&searchKeyword=${this.searchKeyword}`
        )
        .then((res) => {
          this.shops = res.data.data;
          this.pagination = res.data;
        });
    },
  },
  created() {
    this.getAllItems();
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