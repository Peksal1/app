<template>
  <div>
  <div class="row justify-content-center" >
  <div class="col-md-6">
<div class="card">
  <div class="card-header">
    Register
  </div>
  <div class="card-body">
    <form action="#" @submit.prevent="updateuser">
    <div class="form-group">
      <label for="">name</label>
      <input type="text" class="form-control" name="name"  v-model="name">     
    </div>
    <div class="form-group">
      <label for="">email</label>
      <input type="text" class="form-control" name="email"  v-model="email">     
    </div>
    <div class="form-group">
      <label for="">role</label>
      <input type="text" class="form-control" name="role"  v-model="role">     
    </div>
     <div class="form-group">
      <label for="">password</label>
      <input type="text" class="form-control" name="password"  v-model="password">     
    </div>
    <div class="row">
      <div class="col-md-6">
        <button type="submit"  class="btn btn-primary">Update</button>
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
import axios from "axios";
export default {
  data() {
    return {   
        name:'',
        email:'',
        role:'',
        password:'',
      token: localStorage.getItem("token"),
     
    };
  },
 
  methods:{
   updateuser(){
    axios.put('/api/users/'+ this.$route.params.id,{
      name:this.name,
      email:this.email,
      role:this.cons,
      password:this.password,
 
    },{
      headers: {
      Authorization: "Bearer " + this.token,
      }
     
    }).then(response=>{
      console.log(response)
        Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'The user info was changed successfully!',
  showConfirmButton: false,
  timer: 1500
})
       this.$router.push('/users')
    }).catch(error =>{
      console.log(error)
    })
   },
  
  }, 
  ///here we mounted when activity start 
  mounted(){
    axios.get('/api/users/'+ this.$route.params.id, {
      headers: {
      Authorization: "Bearer " + this.token,
      }
    }).then(response=>{
      const user=response.data
      this.name=user.name
      this.email=user.email
      this.role=user.role
      this.password=user.password
    

    }).catch(error =>{
      console.log(error)
    })
  }
  
  
}
</script>

<style>
</style>