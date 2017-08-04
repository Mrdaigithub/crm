<template>
  <div class="doctor-managemnet" v-loading.body="$store.state.loading">
    <h2>Doctors management</h2>
    <el-card class="box-card">
      <float-button @click.native="addDoctor"/>
      <el-table style="width: 100%" border :data="doctorData">
        <el-table-column prop="id" label="ID" width="180"></el-table-column>
        <el-table-column prop="name" label="name"></el-table-column>
        <el-table-column label="tools">
          <template scope="scope">
            <el-switch v-model="scope.row.state" on-text="" off-text=""
                       @change="toggleDoctorState(scope.$index, scope.row)"></el-switch>
            <el-button size="small" icon="edit" @click="editDoctorName(scope.$index, scope.row)"></el-button>
            <el-button size="small" type="danger" icon="delete"
                       @click="removeDoctor(scope.$index, scope.row)"></el-button>
          </template>
        </el-table-column>
      </el-table>
    </el-card>
  </div>
</template>

<script>
  import FloatButton from '~components/FloatButton.vue'
  import axios from '../../../config/axios'
  import qs from 'qs'

  export default {
    name: 'doctorsManagement',
    components: {
      FloatButton
    },
    data () {
      return {
        doctors: []
      }
    },
    computed: {
      doctorData () {
        if (!this.doctors) return []
        return this.doctors.map(doctor => {
          doctor.state = !!doctor.state
          return doctor
        })
      }
    },
    methods: {
      addDoctor () {
        let self = this
        this.$prompt('Please enter a doctor name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Create',
          inputPlaceholder: 'new doctor name'
        })
          .then(({value}) => {
            axios.get(`/management/doctors/create/${value}`)
              .then(res => {
                self.doctors.push(res.doctor)
              })
          })
      },
      editDoctorName (index, row) {
        let self = this
        this.$prompt('Please enter a doctor name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Submit',
          inputValue: row.name
        })
          .then(({value}) => {
            axios.patch(`/management/doctors/${row.id}`, qs.stringify({name: value}))
              .then(res => {
                self.doctors.splice(index, 1, res.doctor)
              })
          })
      },
      toggleDoctorState (index, row) {
        axios.patch(`/management/doctors/${row.id}`, qs.stringify({
          state: row.state ? 0 : 1
        }))
          .then(res => {})
      },
      removeDoctor (index, row) {
        let self = this
        axios.delete(`/management/doctors/${row.id}`)
          .then(res => {
            self.doctors.splice(index, 1)
          })
      }
    },
    mounted () {
      let self = this
      axios.get('/management/doctors')
        .then(res => {
          self.doctors = res.doctors
          self.$store.state.loading = false
        })
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss"></style>
