<template>
<div class="container-fuiled">
     <AdminNavbar />
  <div class="row justify-content-center" >
  <div class="col-md-6">
<div class="card">
  <div class="card-header">
    Register
  </div>
  <div class="card-body">
    <form action="#" @submit.prevent="updateportfolio">
    <div class="form-group">
      <label for="">work_name</label>
      <input type="text" class="form-control" name="work_name"  v-model="work_name">     
    </div>
    <div class="form-group">
      <label for="">file_path</label>
      <input type="text" class="form-control" name="file_path"  v-model="file_path">     
    </div>
    <div class="form-group">
      <label for="">description</label>
      <input type="text" class="form-control" name="description"  v-model="description">     
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
import AdminNavbar from '../components/AdminNavbar.vue';
export default {
  data() {
    return {   
        work_name:'',
        file_path:'',
        description:'',
      token: localStorage.getItem("token"),
     
    };
  },
         components:{
    AdminNavbar,
    },
  methods:{
   updateportfolio(){
    axios.put('/api/portfolio/'+ this.$route.params.id,{
      work_name:this.work_name,
      file_path:this.file_path,
      description:this.description,
 
    },{
      headers: {
      Authorization: "Bearer " + this.token,
      }
     
    }).then(response=>{
      console.log(response)
        Swal.fire({
  position: 'top-end',
  icon: 'success',
  title: 'The portfolio item was changed successfully!',
  showConfirmButton: false,
  timer: 1500
})
       this.$router.push('/adminportfolio')
    }).catch(error =>{
      console.log(error)
    })
   },
  
  }, 
  ///here we mounted when activity start 
  mounted(){
    axios.get('/api/portfolio/'+ this.$route.params.id, {
      headers: {
      Authorization: "Bearer " + this.token,
      }
    }).then(response=>{
      const user=response.data
      this.work_name=user.work_name
      this.file_path=user.file_path
      this.description=user.description
    

    }).catch(error =>{
      console.log(error)
    })
  }
  
  
}
</script>

<style>
</style>