<template>
  <div>
    <AdminNavbar />

    <div class="container mt-4">
      <div class="col-10 m-auto text-black mt-4">
        <div class="text-center">
          <h2>Congrats! Your order #{{ orderId }} is successfully paid.</h2>
          <p class="m-0">
            You can check your order details in your account dashboard.
          </p>
          <p class="m-0">Thank you for shopping with us!</p>
        </div>

        <div class="form">
          <div class="col-8 m-auto">
            <h3 class="mt-5 mb-4">Shipping Details</h3>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Name</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Surname</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Email</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Phone</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Country</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">City</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="name">Address 1</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Address 2</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Postal Code</label>
                  <input type="text" class="form-control" />
                </div>
              </div>
              <div class="col-md-12 mt-4">
                <div class="form-group">
                  <button class="btn btn-block btn-primary text-white">
                    Save Changes
                  </button>
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
import axios from "axios";
import AdminNavbar from "../components/AdminNavbar.vue";
export default {
  data() {
    return {
      orderId: null,
    };
  },
  components: {
    AdminNavbar,
  },
  methods: {
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
    this.orderId = this.$route.query.order;
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Heebo:wght@500&display=swap");

* {
  color: black;
}
</style>