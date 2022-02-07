<template>
<div class="container-fuiled">


     <Navbar />
<div class="row justify-content-center" >
  <div class="col-md-6">
<div class="card">
  <div class="card-header">
   New Order! From user {{currentUser.name}}
  </div>
  <div class="card-body">
    <form action="#" @submit.prevent="createmessage">
    <div class="form-group">
      <input type="text" class="form-control" name="text" placeholder="Description" v-model="formData.text">
         <p class="text-danger" v-text="errors.text"></p>
    </div>
    <div class="form-group">
      <input type="text" class="form-control" name="file_path" placeholder="file_path" v-model="formData.file_path">
         <p class="text-danger" v-text="errors.file_path"></p>
    </div>
  <div class="row">
      <div class="col-md-6">
        <button type="submit"  class="btn btn-primary">Send</button>
      </div>
    </div>
      
    </form>
  </div>

</div>

  </div>
</div>

</div>
</template>

<script>
import axios from 'axios'
import Navbar from '../components/Navbar.vue';
export default {
data(){
  return{
    formData:{
      user_id:'',
      text:'',
      file_path:'',
      completion:'0',
      accepted:'0',
        
    },
      currentUser: {},
      token: localStorage.getItem("token"),
    errors:{}
  }
},
   components:{
    Navbar,
    },
methods:{
  createmessage(){
    this.formData.user_id=this.currentUser.id
      axios.post('/api/order',this.formData,{
            headers: {
            Authorization: "Bearer " + this.token,
          },
      }).then((response)=>{
        console.log(response.data)
          this.$router.push('/user/:id')
        this.errors={}   
        this.$toaster.success('Order sent successfully!')
      
      }).catch((errors)=>{
        console.log("erro")
         this.errors=errors.response.data.errors
         console.log(errors.response.data.errors)
      })
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
		  console.log( response.data.name)
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
mounted() {
    //  axios.defaults.headers.common['Authorization'] = `Bearer ${this.token}`
    this.checkLoginStatus();
  },
  updated() {
	  console.log(this.isLoggedIn)
  },
  watch: {
	  $route(to, from) {
		  this.checkLoginStatus();
	  }
  }
};
</script>

<style>
.login {
  margin-left: 25rem;
}
.card-header {
  color:black;
}
</style>