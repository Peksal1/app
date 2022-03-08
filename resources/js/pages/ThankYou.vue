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
                  <input type="text" class="form-control" name="name" v-model="formData.name"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Surname</label>
                  <input type="text" class="form-control" v-model="formData.surname"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Email</label>
                  <input type="text" class="form-control" v-model="formData.email"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Phone</label>
                  <input type="text" class="form-control" v-model="formData.phone_number"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Country</label>
                  <input type="text" class="form-control" v-model="formData.country"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">City</label>
                  <input type="text" class="form-control" v-model="formData.city"/>
                </div>
              </div>
              <div class="col-md-12">
                <div class="form-group">
                  <label for="name">Address 1</label>
                  <input type="text" class="form-control" v-model="formData.adress1"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Address 2</label>
                  <input type="text" class="form-control" v-model="formData.adress2"/>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="name">Postal Code</label>
                  <input type="text" class="form-control" v-model="formData.postal_code"/>
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
        formData: {
      purchase_id: orderId,
      name: "",
      surname: "",
      phone_number: "",
      email: "",
      country: "",
      city: "",
      adress1: "",
      adress2: "",
      postal_code: "",
        }
    }
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
  
  createItem() {
      const itemForm = new FormData();
      itemForm.append("purchase_id", this.formData.purchase_id);
      itemForm.append("name", this.formData.name);
      itemForm.append("surname", this.formData.surname);
      itemForm.append("phone_number", this.formData.phone_number);
      itemForm.append("email", this.formData.email);
      itemForm.append("country", this.formData.country);
      itemForm.append("city", this.formData.city);
      itemForm.append("adress1", this.formData.adress1);
      itemForm.append("adress2", this.formData.adress2);
      itemForm.append("postal_code", this.formData.postal_code);
      axios
        .post("/api/shipping", itemForm, {
          headers: {
            Authorization: "Bearer " + this.token,
            "Content-Type": "multipart/form-data",
            boundary: itemForm._boundary,
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