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
    <section class="section-products">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-lg-6">
            <div class="header">
              <h2>User orders</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <p><strong>Filter by status</strong></p>
            <!-- status filtering -->
            <div class="m-1">
              <div>
                <input type="checkbox" :id="1" class="mycat" v-model="trackingFilter" :value="'Not sent'"
                  checked /><label :for="1" class="btn btn-sm border btn-block">Display all orders</label>
              </div>
            </div>
            <!-- orders -->
          </div>
          <div class="col-md-9">
            <div class="row">
              <!-- Single order -->
              <div class="col-md-6" v-for="(order, index) in orders" :key="index">
                <div id="product-1" class="single-product">
                  <div class="part-1">
                    <img :src="`/images/${order.file_path}`" @click="openOrderModal(order.id)" alt="{order.file_path}"
                      style="cursor: pointer; max-width: 450px" />

                  </div>
                  <div class="part-2">
                    <h3 class="product-title">
                      <strong>Order #{{ order.uuid }}</strong>
                    </h3>
                    <div class="category"><strong>Description: </strong> {{ order.text }}</div>
                    <div class="category"><strong>Size: </strong> {{ order.size.type }}</div>
                    <div class="category"><strong>Paint: </strong> {{ order.paint.type }}</div>
                    <div class="category"><strong>Canvas: </strong> {{ order.canvas.type }}</div>
                    <div class="category"><strong>Orientation: </strong> {{ order.orientation }}</div>
                    <div class="category"> <strong>Shipping: </strong>{{ order.tracking }}</div>
                  </div>
                  <div class="btn btn-sm btn-primary" @click="openOrderMessageModal(order.id)">
                    Discuss the order
                  </div>
                  <div class="btn btn-sm btn-primary" @click="callEditModal(index)">
                    Update order status
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <div class="col-md-12 text-center center-pagination">
          <Pagination :pagination="pagination" @perPage="getAllOrders()" @paginate="getAllOrders()" :offset="6">
          </Pagination>
        </div>
      </div>
    </section>
    <div class="modal" :class="{ show: showOrderMessageModal }" id="sizeModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" v-if="specificOrder != null">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              <strong> Order number: </strong> {{ specificOrder.uuid }}
            </h5>
            <br />
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close"
              @click="hideOrderMessageModal">
              <span aria-hidden="true">&times;</span>
            </button>


          </div>

          <div class="modal-body"> <img :src="`/images/${specificOrder.file_path}`" style="max-width: 465px" />
            <div v-for="(order_message, index) in order_messages" :key="index">

              <strong> {{ order_message.user.name }} </strong> <br />
              {{ order_message.message }}
              <br />
            </div>
          </div>
          <form @submit.prevent="postOrderMessage(currentOrder)">
            <div class="form-group">
              <label for="">New message</label>
              <input v-model="formData.message" type="text" class="form-control" />
            </div>
            <div class="form-group">
              <input type="submit" value="Submit" class="btn btn-primary btn-block" />
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="modal" :class="{ show: showUpdateModal }" id="storeModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              <strong> Update order #{{ updateForm.uuid }}</strong>
            </h5>
            <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close"
              @click="hideUpdateModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form @submit.prevent="updateOrder">



              <div class="relative">
                <label for="attachment">Current order status</label><br />

                <input type="file" accept="image/*" @change="uploadImage($event)" id="file-input" required />
              </div>
              <br />
              <div class="form-group">
                <label for="">Tracking number</label>
                <input v-model="updateForm.tracking" type="text" class="form-control" required />
              </div>
              <div class="form-group">
                <input type="submit" value="Submit" class="btn btn-primary btn-block"
                  style="color:white;max-width:100px" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="modal" :class="{ show: showOrderModal }" id="orderModal" tabindex="-1" role="dialog"
      aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document" v-if="specificOrder != null">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel"><strong>Order #{{ specificOrder.uuid }}</strong>
            </h5>
            <button type="button" class="close text-dark cursor: pointer" data-dismiss="modal" aria-label="Close"
              @click="hideOrderModal">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <img :src="`/images/${specificOrder.file_path}`" alt="{specificOrder.file_path" style="max-width: 465px" />
            <br />
            <strong>Purchased by: </strong>{{ specificOrder.user.name }} {{ specificOrder.user.surname }} <br />
            <strong>Purchased on: </strong>{{ specificOrder.created_at }} <br />

            <strong>Price: </strong> {{ specificOrder.price }} EUR <br />
            <strong>Ship to: </strong> <br />
            <div v-if="specificOrder.shipping">
              {{ specificOrder.shipping.name }} {{ specificOrder.shipping.surname }}, <br />
              {{ specificOrder.shipping.country }}, {{ specificOrder.shipping.city }}, <br />
              {{ specificOrder.shipping.adress1 }}, {{ specificOrder.shipping.adress2 }}, {{
                  specificOrder.shipping.postal_code
              }} <br />
              <strong>E-mail: </strong>{{ specificOrder.shipping.email }} <br />
              <strong>Phone number: </strong> {{ specificOrder.shipping.phone_number }} <br />
              <strong>Tracking number: </strong> {{ specificOrder.tracking }} <br />
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
import Pagination from "../components/Pagination.vue";
export default {
  data() {
    return {
      orders: [],
      searchKeyword: "",
      specificOrder: null,
      trackingFilter: '',
      adminToken: localStorage.getItem("adminToken"),
      pagination: {
        data: [],
        total: 0,
        per_page: 2,
        from: 1,
        to: 0,
        current_page: 1,
      },
      updateForm: {
        id: null,
        file_path: '',
        completion: '',
        orientation: '',
        accepted: '',
        tracking: '',
        uuid: '',
      },
      currentOrder: "",
      formData: {
        message: "",
        user_id: "",
        order_id: "",
      },
      order_messages: [],
      showOrderMessageModal: false,
      showUpdateModal: false,
      showOrderModal: false,
    };
  },
  components: {
    AdminNavbar,
    Pagination,
  },
  methods: {
    updateOrder() {
      let formData = new FormData();
      formData.append("work_name", this.updateForm.completion);
      formData.append("file_path", this.updateForm.file_path);
      formData.append("description", this.updateForm.accepted);
      formData.append("orientation", this.updateForm.orientation);
      formData.append("tracking", this.updateForm.tracking);


      axios
        .post(`/api/orders/${this.updateForm.id}/update`, formData, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
            "Content-Type": "multipart/form-data",
          },
        })
        .then((res) => {
          if (res.data.success) {
            let orderIndex = this.orders.findIndex(item => item.id == this.updateForm.id);
            this.orders[orderIndex] = res.data.order;
            // reset the form
            this.updateForm = {
              work_name: "",
              file_path: "",
              description: "",
            };
            // hide the modal
            this.hideUpdateModal();
            alert("The order was successfully updated!");
          } else {
            alert("STOPPPPPPPPP");
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
    loadSpecificOrder(currentOrder) {
      axios
        .get("/api/admin/order/" + this.currentOrder, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })

        .then((response) => {
          this.specificOrder = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    callEditModal(index) {
      this.updateForm = this.orders[index];
      this.showUpdateModal = true;
    },
    uploadImage(event) {
      const file = event.target.files[0];
      this.updateForm.file_path = file;
    },
    hideUpdateModal() {
      this.showUpdateModal = false;
    },
    openOrderMessageModal(index) {
      this.showOrderMessageModal = true;
      this.currentOrder = index;
      this.getAllOrderMessages(index);
      this.loadSpecificOrder(index);

    },
    hideOrderMessageModal() {
      this.showOrderMessageModal = false;
    },
    openOrderModal(index) {
      this.showOrderModal = true;
      this.currentOrder = index;
      this.loadSpecificOrder(index);

    },
    hideOrderModal() {
      this.showOrderModal = false;
    },
    postOrderMessage(currentOrder) {
      const messageForm = new FormData();
      messageForm.append("message", this.formData.message);
      messageForm.append("order_id", this.currentOrder);
      messageForm.append("user_id", this.currentUser.id);
      axios
        .post("/api/order_messages/" + this.currentOrder, messageForm, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
            "Content-Type": "multipart/form-data",
            boundary: messageForm._boundary,
          },
        })
        .then((response) => {
          alert("Message Sent!");
          this.getAllOrderMessages(currentOrder);

        })
        .catch((errors) => {
          console.log("error");
        });
    },
    getAllOrderMessages(currentOrder) {
      axios
        .get("/api/order_messages/admin/" + this.currentOrder, {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((res) => {
          this.order_messages = res.data;
          console.log(this.order_messages);
        })
        .catch((err) => {
          console.log(err);
        });
    },
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
    checkLoginStatus() {
      this.loading = true;
      // this.loading = true
      axios
        .get("/api/user", {
          headers: {
            Authorization: "Bearer " + this.adminToken,
          },
        })
        .then((response) => {
          this.currentUser = response.data;
          console.log("LOGGED IN");
          this.isLoggedIn = true;
          console.log(this.currentUser.name);
        })
        .catch((errors) => {
          console.log(errors);
          this.isLoggedIn = false;
        })
        .finally(() => {
          this.loading = false;
        });
      // this.loading = false
    },
  },

  created() {
    this.getAllOrders();
  },
  mounted() {
    this.checkLoginStatus();
  },
};
</script>

<style scoped>
input.mycat,
input.mypaint,
input.mysize,
input.mycanvas {
  display: none;
}

input.mycat:checked+label,
input.mypaint:checked+label,
input.mysize:checked+label,
input.mycanvas:checked+label {
  background: green;
  color: white;
  box-shadow: 0px 1px 3px inset;
}

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

@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap");

body {
  font-family: "Poppins", sans-serif;
  color: #444444;
}

a,
a:hover {
  text-decoration: none;
  color: inherit;
}

.section-products {
  padding: 80px 0 54px;
}

.section-products .header {
  margin-bottom: 50px;
}

.section-products .header h3 {
  font-size: 1rem;
  color: #fe302f;
  font-weight: 500;
}

.section-products .header h2 {
  font-size: 2.2rem;
  font-weight: 400;
  color: #444444;
}

.section-products .single-product {
  margin-bottom: 26px;
}

.section-products .single-product .part-1 {
  position: relative;
  height: 290px;
  max-height: 290px;
  margin-bottom: 20px;
  overflow: hidden;
}

.section-products .single-product .part-1::before {
  position: absolute;
  content: "";
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: -1;
  transition: all 0.3s;
}

.section-products .single-product:hover .part-1::before {
  transform: scale(1.2, 1.2) rotate(5deg);
}

.section-products #product-1 .part-1::before {
  background: url("https://i.ibb.co/L8Nrb7p/1.jpg") no-repeat center;
  background-size: cover;
  transition: all 0.3s;
}

.section-products #product-2 .part-1::before {
  background: url("https://i.ibb.co/cLnZjnS/2.jpg") no-repeat center;
  background-size: cover;
}

.section-products #product-3 .part-1::before {
  background: url("https://i.ibb.co/L8Nrb7p/1.jpg") no-repeat center;
  background-size: cover;
}

.section-products #product-4 .part-1::before {
  background: url("https://i.ibb.co/cLnZjnS/2.jpg") no-repeat center;
  background-size: cover;
}

.section-products .single-product .part-1 .discount,
.section-products .single-product .part-1 .new {
  position: absolute;
  top: 15px;
  left: 20px;
  color: #ffffff;
  background-color: #fe302f;
  padding: 2px 8px;
  text-transform: uppercase;
  font-size: 0.85rem;
}

.section-products .single-product .part-1 .new {
  left: 0;
  background-color: #444444;
}

.section-products .single-product .part-1 ul {
  position: absolute;
  bottom: -41px;
  left: 20px;
  margin: 0;
  padding: 0;
  list-style: none;
  opacity: 0;
  transition: bottom 0.5s, opacity 0.5s;
}

.section-products .single-product:hover .part-1 ul {
  bottom: 30px;
  opacity: 1;
}

.section-products .single-product .part-1 ul li {
  display: inline-block;
  margin-right: 4px;
}

.section-products .single-product .part-1 ul li a {
  display: inline-block;
  width: 40px;
  height: 40px;
  line-height: 40px;
  background-color: #ffffff;
  color: #444444;
  text-align: center;
  box-shadow: 0 2px 20px rgb(50 50 50 / 10%);
  transition: color 0.2s;
}

.section-products .single-product .part-1 ul li a:hover {
  color: #fe302f;
}

.section-products .single-product .part-2 .product-title {
  font-size: 1rem;
}

.section-products .single-product .part-2 h4 {
  display: inline-block;
  font-size: 1rem;
  color: black;
}

.section-products .single-product .part-2 .product-old-price {
  position: relative;
  padding: 0 7px;
  margin-right: 2px;
  opacity: 0.6;
}

.section-products .single-product .part-2 .product-old-price::after {
  position: absolute;
  content: "";
  top: 50%;
  left: 0;
  width: 100%;
  height: 1px;
  background-color: #444444;
  transform: translateY(-50%);
}

.btn-block {
  width: 100%;
  text-align: left;
}

.mt-4 {
  margin-top: 10px;
}
</style>