<template>
  <div class="patient">
    <el-card class="box-card">
      <h2>Doctors management</h2>
      <el-button type="success" icon="plus" class="add-doctor" @click="addDoctor"></el-button>
      <el-table :data="patientData" style="width: 100%" border>
        <el-table-column prop="id" label="id" width="60"></el-table-column>
        <el-table-column prop="name" label="name" width="120"></el-table-column>
        <el-table-column prop="sex" label="sex" width="100"></el-table-column>
        <el-table-column prop="age" label="age" width="80"></el-table-column>
        <el-table-column prop="tel" label="tel" width="140"></el-table-column>
      </el-table>
      <el-pagination
        layout="prev, pager, next"
        :total="50">
      </el-pagination>
    </el-card>
  </div>
</template>

<script>
  import axios from '../config/axiosConfig'
  import qs from 'qs'

  export default {
    name: 'patient',
    data(){
      return {
        patients: []
      }
    },
    computed: {
      patientData(){
        if (!this.patients.data) return [];
        let patientData = this.patients.data.map(patient => {
          patient.sex = patient.sex ? 'man' : 'woman';
          return patient
        })
        return patientData
      }
    },
    methods: {
      addDoctor(){
        let self = this;
        this.$prompt('Please enter a doctor name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Create',
          inputPlaceholder: 'new doctor name'
        })
          .then(({value}) => {
            axios.get(`/management/doctors/create/${value}`)
              .then(res => {
                self.doctors.push(res.doctor);
              })
          });
      },
      editDoctorName(index, row){
        let self = this;
        this.$prompt('Please enter a doctor name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Submit',
          inputValue: row.name
        })
          .then(({value}) => {
            axios.patch(`/management/doctors/${row.id}`, qs.stringify({name: value}))
              .then(res => {
                self.doctors.splice(index, 1, res.doctor);
              })
          });
      },
      toggleDoctorState(index, row){
        axios.patch(`/management/doctors/${row.id}`, qs.stringify({
          state: row.state ? 0 : 1
        }))
          .then(res => {
          })
      },
      removeDoctor(index, row){
        let self = this;
        axios.delete(`/management/doctors/${row.id}`)
          .then(res => {
            self.doctors.splice(index, 1);
          })
      }
    },
    mounted(){
      let self = this;
      axios.get('/patients?page=1')
        .then(res => {
          self.patients = res;
        })
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
  .box-card {
    margin: 15px;
    min-height: 85vh;
    h2 {
      margin-bottom: 5px;
    }
    .add-doctor {
      margin-bottom: 15px;
    }
  }
</style>
