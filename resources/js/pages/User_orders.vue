<template>
  <div>
    <Navbar />

    <div class="d-flex justify-content-center flex-wrap my-5">
      <h1>UNPAID ORDERS</h1>
      <v-card
        v-for="(order, index) in orders"
            :key="index"
        class="mx-auto my-3"
        max-width="15rem"
        min-width="15rem"
      >
      
        <v-img
          class="white--text align-end"
          height="10rem"
          src="https://rb.gy/rnnzki"
        >
          <v-card-title class="d-flex justify-center text-dark">{{
            order.id
          }}</v-card-title>
        </v-img>

        <v-card-subtitle class="pb-0">
          <div>
            Orientation: {{ order.orientation }}
           
          </div>
        </v-card-subtitle>

        <v-card-text class="text--primary">
          <div>paint: {{ order.paint }}</div>
        </v-card-text>
        <v-card-text class="text--primary">
          <div>Total price: {{ order.price }} EUR</div>
        </v-card-text>
        <hr />
        <div @click="makePayment(order)" class="btn btn-sm btn-danger">
          Pay now
        </div>
      </v-card>
    </div>
    <div
      class="modal"
      :class="{ show: showOrderMessageModal }"
      id="sizeModal"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title text-dark" id="exampleModalLabel">
              Add Size
            </h5>
            <button
              type="button"
              class="close text-dark"
              data-dismiss="modal"
              aria-label="Close"
              @click="hideOrderMessageModal"
            >
              <span aria-hidden="true">&times;</span>
            </button>
                 <div
            class="modal-body"
            v-for="(order_message, index) in order_messages"
            :key="index"
          >
         <strong> {{order_message.user.name}} </strong> <br />
          {{order_message.message}}
            <form @submit.prevent="postOrderMessage(index)">
              <div class="form-group">
                <label for="">message</label>
                <input
                  v-model="formData.message"
                  type="text"
                  class="form-control"
                />
              </div>
              <div class="form-group">
                <input
                  type="submit"
                  value="Submit"
                  class="btn btn-primary btn-block"
                />
              </div>
            </form>
          </div>
          </div>
     
        </div>
      </div>
    </div>
    <h1>PAID ORDERS</h1>
    <v-card
    v-for="(paid_order, index) in paid_orders"
            :key="index"
      class="mx-auto my-3"
      max-width="15rem"
      min-width="15rem"
    >
      <v-img
        class="white--text align-end"
        height="10rem"
        src="https://rb.gy/rnnzki"
      >
        <v-card-title class="d-flex justify-center text-dark">{{
          paid_order.id
        }}</v-card-title>
      </v-img>

      <v-card-subtitle class="pb-0">
        <div>
          Orientation:
          {{ paid_order.orientation }}
        </div>
      </v-card-subtitle>

      <v-card-text class="text--primary">
        <div>paint: {{ paid_order.paint }}</div>
      </v-card-text>
      <v-card-text class="text--primary">
        <div>Price: {{ paid_order.price }} EUR</div>
      </v-card-text>
      <hr />
      <div class="btn btn-sm btn-primary" @click="openOrderMessageModal(index)">
        Discuss the order
      </div>
    </v-card>
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
      let stripe = Stripe("pk_test_d6aChIuFov53M3i5n00Fn1j200m37XdpTE");
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
          this.getAllOrderMessages(index);
    },
    hideOrderMessageModal() {
      this.showOrderMessageModal = false;
    },
     postOrderMessage(index) {
      const messageForm = new FormData();
      messageForm.append("message", this.formData.message);
      messageForm.append("order_id", this.paid_orders[index].id);
      messageForm.append("user_id", this.currentUser.id);
      axios
        .post("/api/order_messages", messageForm, {
          headers: {
            Authorization: "Bearer " + this.token,
            "Content-Type": "multipart/form-data",
            boundary: messageForm._boundary,
          },
        })
        .then((response) => {
          alert("Message Sent!");
          this.getAllOrderMessages(index);        
                       
        })
        .catch((errors) => {
          console.log("error");
        });
    },
    getAllOrderMessages(index) {
      axios
        .get("/api/order_messages/" + this.paid_orders[index].id, {
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
  created() {},
  mounted() {
    this.checkLoginStatus();
    this.loadUserPaidOrders();
    this.loadUserOrders();

  },
};
</script>

<style scoped>
</style>