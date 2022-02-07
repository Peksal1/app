<template>
<div class="container-fuiled">
     <AdminNavbar />
<div class="row justify-content-center" >
  <div class="col-md-6">
<div class="card">
  <div class="card-header">
   Creation of a new portfolio item
  </div>
  <div class="card-body">
    <form action="#" @submit.prevent="createportfolio">
    <div class="form-group">
      <input type="text" class="form-control" name="work_name" placeholder="Work Name" v-model="formData.work_name">
         <p class="text-danger" v-text="errors.work_name"></p>
    </div>
    <div class="form-group">
      <input type="text" class="form-control" name="file_path" placeholder="File path" v-model="formData.file_path">
         <p class="text-danger" v-text="errors.file_path"></p>
    </div>
    <div class="form-group">
      <input type="text" class="form-control" name="description" placeholder="Description" v-model="formData.description">
         <p class="text-danger" v-text="errors.description"></p>
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
import AdminNavbar from '../components/AdminNavbar.vue';
export default {
data(){
  return{
    formData:{
      work_name:'',
      file_path:'',
      description:'',
        
    },
      currentUser: {},
      token: localStorage.getItem("token"),
    errors:{}
  }
},
   components:{
    AdminNavbar,
    },
methods:{
  createportfolio(){
    this.formData.user_id=this.currentUser.id
      axios.post('/api/portfolio',this.formData,{
            headers: {
            Authorization: "Bearer " + this.token,
          },
      }).then((response)=>{
        console.log(response.data)
          this.$router.push('/adminportfolio')
        this.errors={}   
        this.$toaster.success('Message sent successfully!')
      
      }).catch((errors)=>{
        console.log("error")
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