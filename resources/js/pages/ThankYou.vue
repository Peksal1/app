<template>
  <div>
    <AdminNavbar />

    <div class="container mt-4">
      <div
        class="col-10 m-auto text-black mt-4"
        v-if="!isLoading && hasError != true"
      >
        <div class="text-center">
          <h2>Congrats! the </h2>
          <p class="m-0">
            You can check your order details in your account dashboard.
          </p>
          <p class="m-0">Thank you for shopping with us!</p>
        </div>
        <form @submit.prevent="createItem">
          <div class="form">
            <div class="col-8 m-auto">
              <h3 class="mt-5 mb-4">Shipping Details</h3>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Name</label>
                    <input
                      type="text"
                      class="form-control"
                      name="name"
                      v-model="formData.name"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Surname</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="formData.surname"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Email</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="formData.email"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Phone</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="formData.phone_number"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Country</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="formData.country"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">City</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="formData.city"
                    />
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="name">Address 1</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="formData.adress1"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Address 2</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="formData.adress2"
                    />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="name">Postal Code</label>
                    <input
                      type="text"
                      class="form-control"
                      v-model="formData.postal_code"
                    />
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
        </form>
      </div>
      <div v-if="hasError">
        <div class="alert alert-danger">
          <p>{{ errorMessgae }}</p>
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
      formData: {
        purchase_id: null,
        name: "",
        surname: "",
        phone_number: "",
        email: "",
        country: "",
        city: "",
        adress1: "",
        adress2: "",
        postal_code: "",
      },
      orderId: null,
      isLoading: false,
      hasError: false,
      errorMessgae: "",
    };
  },
  components: {
    AdminNavbar,
  },
  methods: {
    checkOrder() {
      this.isLoading = true;
      axios
        .get(`/api/check/purchase/${this.orderId}/status`)
        .then((res) => {
          if (res.data.success) {
            this.order = res.data.order;
            if (res.data.isShippingInfoFilled) {
              this.hasError = true;
              this.errorMessgae = "Shipping info already filled";
            }
          } else {
            this.hasError = true;
            this.errorMessgae = "No order found";
          }
        })
        .catch((err) => {
          this.hasError = true;
          this.errorMessgae = "No order found";
        })
        .finally(() => {
          this.isLoading = false;
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

    createItem() {
      const itemForm = new FormData();
      axios
        .post("/api/shipping", this.formData, {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          alert("Item Sent!");
          this.$router.push({
            name: "store",
          });
        })
        .catch((errors) => {
          console.log("error");
        });
    },
  },
  created() {
    this.orderId = this.$route.query.order;
    this.formData.purchase_id = this.$route.query.order;
    this.checkOrder();
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Heebo:wght@500&display=swap");

* {
  color: black;
}
</style>