    <template>
  <div>
    <Navbar />
    <section class="section-products">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-lg-6">
            <div class="header">
              <h2>Unpaid orders:</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- Single Product -->
          <div class="col-md-6 col-lg-4 col-xl-3" v-for="(order, index) in orders" :key="index">
            <div id="product-1" class="single-product">
              <div class="part-1">
                <img :src="`/images/${order.file_path}`" alt="{order.text}" style="max-width: 450px" />


              </div>
              <div class="part-2">

                <strong>Price: </strong> {{ order.price }} EUR <br />

                <strong>Size: </strong> {{ order.size.type }}<br />
                <strong>Paint: </strong> {{ order.paint.type }}<br />
                <strong>Canvas: </strong> {{ order.canvas.type }}<br />
                <div class="category">{{ order.text }}</div>
                <div @click="makePayment(order)" class="btn btn-sm btn-danger">
                  Pay now
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row justify-content-center text-center">
          <div class="col-md-8 col-lg-6">
            <div class="header">
              <h2>Paid orders:</h2>
            </div>
          </div>
        </div>
        <div class="row">
          <!-- Single Product -->
          <div class="col-md-6 col-lg-4 col-xl-3" v-for="(paid_order, index) in paid_orders" :key="index">
            <div id="product-1" class="single-product">
              <div class="part-1">
                <img :src="`/images/${paid_order.file_path}`" alt="{order.text}" style="max-width: 450px" />

              </div>
              <div class="part-2">
                <h3 class="product-title">
                  <strong>Order number: </strong>{{ paid_order.uuid }}
                </h3>
                <div class="category"><strong>Purchased on: </strong>{{ paid_order.created_at }}</div>
                <div class="category"><strong>Price: </strong>{{ paid_order.price }} EUR</div>
                <div class="category"><strong>Tracking number: </strong>{{ paid_order.tracking }}</div>
                <div class="btn btn-sm btn-primary" @click="openOrderMessageModal(paid_order.id)">
                  Discuss the order
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal" :class="{ show: showOrderMessageModal }" id="orderMessageModal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-dark" id="exampleModalLabel">
                <strong> Order number: </strong> {{ specificOrder.uuid }}
              </h5>
              <button type="button" class="close text-dark cursor: pointer" data-dismiss="modal" aria-label="Close"
                @click="hideOrderMessageModal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <img :src="`/images/${specificOrder.file_path}`" style="max-width: 465px" />
              <div class="messages" style="overflow:scroll;overflow-x:hidden;max-height:250px;margin-top:10px">
                <div v-for="(order_message, index) in order_messages" :key="index">
                  <br />
                  <div class="message">
                    <strong> {{ order_message.user.name }} {{ order_message.user.surname }} </strong> <br />
                    {{ order_message.message }}
                  </div>
                  <br />
                </div>
              </div>
              <form @submit.prevent="postOrderMessage(currentOrder)">
                <div class="form-group">
                  <label for="">New message</label>
                  <input v-model="formData.message" type="text" class="form-control" />
                </div>
                <div class="form-group">
                  <input type="submit" value="Submit" class="btn btn-primary btn-block"
                    style="max-width:100px;color:white" />
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import axios from "axios";
import Navbar from "../components/Navbar.vue";
export default {
  data: function () {
    return {
      showOrderMessageModal: false,
      orders: [],
      paid_orders: [],
      order_messages: [],
      specificOrder: [],
      currentorder: "",
      formData: {
        message: "",
        user_id: "",
        order_id: "",
      },
      token: localStorage.getItem("token"),
      isLoggedIn: false,
    };
  },
  components: {
    Navbar,
  },

  methods: {
    loadUserOrders() {
      axios
        .get("/api/users_orders/", {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          this.isLoggedIn = false;

          this.orders = response.data.data;
          console.log(response);
        })
        .catch((error) => {
          console.log(error.message);
        });
    },
    loadUserPaidOrders() {
      axios
        .get("/api/users_paid_orders/", {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })
        .then((response) => {
          this.isLoggedIn = false;

          this.paid_orders = response.data.data;
        })
        .catch((error) => {
          console.log(error.message);
        });
    },
    makePayment(order) {
      this.isPaymentLoading = true;
      axios
        .post(
          "/api/order/create-payment-session",
          {
            order: order,
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
      let stripe = Stripe("pk_test_51HrQxvBs1Zza18elihlzjZJ6mZWcTnb6IVL8koLp8zgU4ohLCRAP50PL9KuAALZ9pPRAPTDebP3RrGJOreTQpVbb00K3Ngv7gO");
      stripe
        .redirectToCheckout({
          sessionId: sessionID,
        })
        .then((res) => {
          console.log(res);
        });
    },

    checkLoginStatus() {
      this.loading = true;
      // this.loading = true
      axios
        .get("/api/user", {
          headers: {
            Authorization: "Bearer " + this.token,
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
    openOrderMessageModal(index) {
      this.showOrderMessageModal = true;
      this.currentOrder = index;
      this.getAllOrderMessages(index);
      this.loadSpecificOrder(index);

    },
    hideOrderMessageModal() {
      this.showOrderMessageModal = false;
    },
    postOrderMessage(currentOrder) {
      const messageForm = new FormData();
      messageForm.append("message", this.formData.message);
      messageForm.append("order_id", this.currentOrder);
      messageForm.append("user_id", this.currentUser.id);
      axios
        .post("/api/order_messages/" + this.currentOrder, messageForm, {
          headers: {
            Authorization: "Bearer " + this.token,
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

    loadSpecificOrder(currentOrder) {
      axios
        .get("/api/user/order/" + this.currentOrder, {
          headers: {
            Authorization: "Bearer " + this.token,
          },
        })

        .then((response) => {
          this.specificOrder = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getAllOrderMessages(currentOrder) {
      axios
        .get("/api/order_messages/" + this.currentOrder, {
          headers: {
            Authorization: "Bearer " + this.token,
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
    deleteMessage(index) {
      axios
        .delete("/api/order_messages/" + this.order_messages[index].id)
        .then((res) => {
          if (res.data.status == "success") {
            this.order_messages.splice(index, 1);
          }
        })
        .catch((err) => {
          console.log(err);
        });
    },
  },
  created() { },
  mounted() {
    this.checkLoginStatus();
    this.loadUserPaidOrders();
    this.loadUserOrders();

  },
};
</script>

<style scoped>
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
  color: gray;
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
</style>