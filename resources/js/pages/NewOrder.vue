<template>
<div>
     <Navbar />

 <div class="container">

        <div class=" text-center mt-5 ">

            <h1 >New order by {{currentUser.name}} {{currentUser.surname}}</h1> 
            <h2>Total price: {{ customPrice }} EURO</h2>
                <br/>
            
        </div>

    
    <div class="row ">
      <div class="col-lg-7 mx-auto">
        <div class="card mt-2 mx-auto p-4 bg-light">
            <div class="card-body bg-light">
       
            <div class = "container">
                             <form id="order-form" role="form" @submit.prevent="createOrder">

            

            <div class="controls">

                <div class="row">
              
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="form_need">Size</label>
                            <select id="form_need" name="size" class="form-control" required="required" data-error="Please specify your need."
                v-model="formData.size_id">
                                <option value="" selected disabled>Select the size</option>
                              <option
                  v-for="size in sizes"
                  v-bind:key="size.id"
                  :value="size.id"
                >
                  {{ size.type }}
                </option>
                            </select>
                            
                        </div>
                    </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            <label for="form_need">Paint</label>
                            <select id="form_need" name="paint"
                v-model="formData.paint_id" class="form-control" required="required" data-error="Please specify your need."
       >
                                <option value="" selected disabled>Select the paint</option>
                       <option
                  v-for="paint in paints"
                  v-bind:key="paint.id"
                  :value="paint.id"
                >
                  {{ paint.type }}
                </option>
                            </select>
                            
                        </div>
                    </div>
                </div>
                   <div class="row">
                         <div class="col-md-6">
                        <div class="form-group">
                            <label for="form_need">Canvas</label>
                            <select id="form_need"  name="canvas"
                v-model="formData.canvas_id" class="form-control" required="required" data-error="Please specify your need."
       >
                                <option value="" selected disabled>Select the canvas</option>
                       <option
                  v-for="canvas in canvases"
                  v-bind:key="canvas.id"
                  :value="canvas.id"
                >
                  {{ canvas.type }}
                </option>
                            </select>
                            
                        </div>
                    </div>
                         <div class="col-md-6">
                        <div class="form-group">
                            <label for="form_need">Orientation</label>
                            <select id="form_need"  name="orientation"
                v-model="formData.orientation" class="form-control" required="required" data-error="Please specify your need."
       >
                                <option value="" selected disabled>Select the orientation</option>
                     <option value="horizontal">Horizontal</option>
                <option value="vertical">Vertical</option>
                            </select>
                            
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-6">
                         <div class="p-2 w-full">
                <div class="relative">
                  <label
                    for="attachment"
                    class="leading-7 text-sm text-gray-600"
                    >Example</label
                  ><br />
                  <input
                    type="file"
                    accept="image/*"
                    @change="uploadImage($event)"
                    id="file-input"
                  />
                </div>
              </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="form_text">Write a description of the painting</label>
                            <textarea id="form_text" name="text" class="form-control" placeholder="Description" rows="4" required="required" v-model="formData.text"></textarea
                                >
                            </div>

                        </div>


                    <div class="col-md-12">
                        
                        
                  <button type="submit" class="btn btn-primary" style="color:white;background:green">Post the order!</button>
              
                </div>
          
                </div>


        </div>
         </form>
        </div>
            </div>


    </div>
        <!-- /.8 -->

    </div>
    <!-- /.row-->

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
      sizes: {},
      canvases: {},
      paints: {},
      formData: {
        user_id: "",
        text: "",
        file_path: "",
        completion: "0",
        accepted: "0",
        image: "",
        size_id: "",
        canvas_id: "",
        paint_id: "",
        orientation: "",
        price: 0,
      },
      currentUser: {},
      token: localStorage.getItem("token"),
      errors: {},
    };
  },

  components: {
    Navbar,
  },
  methods: {
    afterUploadComplete: async function (response) {
      if (response.status == "success") {
        console.log("upload successful");
        this.sendSuccess = true;
      } else {
        console.log("upload failed");
      }
    },
    uploadImage(event) {
      const file = event.target.files[0];
      this.formData.image = file;
    },

    createOrder() {
      const orderForm = new FormData();
      orderForm.append("text", this.formData.text);
      orderForm.append("file_path", this.formData.file_path);
      orderForm.append("image", this.formData.image);
      orderForm.append("size_id", this.formData.size_id);
      orderForm.append("canvas_id", this.formData.canvas_id);
      orderForm.append("paint_id", this.formData.paint_id);
      orderForm.append("orientation", this.formData.orientation);
      orderForm.append("user_id", this.currentUser.id);
      orderForm.append("price", this.customPrice);

      axios
        .post("/api/neworder", orderForm, {
          headers: {
            Authorization: "Bearer " + this.token,
            "Content-Type": "multipart/form-data",
            boundary: orderForm._boundary,
          },
        })
        .then((response) => {
          alert("Order Sent!");
          this.$router.push({
            name: "userprofile",
            params: { id: this.currentUser.id },
          });
        })
        .catch((errors) => {
          console.log("error");
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
          console.log(response.data.name);
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
    loadSizes() {
      axios.get(`/api/all_sizes`).then((res) => {
        this.sizes = res.data.sizes;
      });
    },
    loadPaints() {
      axios.get(`/api/all_paints`).then((res) => {
        this.paints = res.data.paints;
      });
    },
    loadCanvases() {
      axios.get(`/api/all_canvases`).then((res) => {
        this.canvases = res.data.canvases;
      });
    },
  },
  computed: {
    customPrice() {
      let totalPrice = 0;
      if (this.formData.size_id != "") {
        let sizeIndex = this.sizes.findIndex(
          (size) => size.id == this.formData.size_id
        );
        totalPrice += this.sizes[sizeIndex].price_in_eur;
      }

      if (this.formData.canvas_id != "") {
        let canvasIndex = this.canvases.findIndex(
          (canvas) => canvas.id == this.formData.canvas_id
        );
        totalPrice += this.canvases[canvasIndex].price_in_eur;
      }

      if (this.formData.paint_id != "") {
        let paintIndex = this.paints.findIndex(
          (paint) => paint.id == this.formData.paint_id
        );
        totalPrice += this.paints[paintIndex].price_in_eur;
      }

      return totalPrice;
    },
  },
  mounted() {
    //  axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
    this.checkLoginStatus();
    this.loadSizes();
    this.loadPaints();
    this.loadCanvases();
  },
  updated() {
    console.log(this.isLoggedIn);
  },
  watch: {
    $route(to, from) {
      this.checkLoginStatus();
    },
  },
};
</script>

<style scoped>
body {
    font-family: 'Lato', sans-serif;
}

h1 {
    margin-bottom: 40px;
}

label {
    color: #333;
}

.btn-send {
    font-weight: 300;
    text-transform: uppercase;
    letter-spacing: 0.2em;
    width: 80%;
    margin-left: 3px;
    }
.help-block.with-errors {
    color: #ff5050;
    margin-top: 5px;

}

.card{
	margin-left: 10px;
	margin-right: 10px;
}
</style>
