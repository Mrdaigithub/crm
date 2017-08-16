<template>
  <div class="doctor-managemnet">
    <h2>医生管理</h2>
    <el-card class="box-card">
      <float-button @click.native="addDoctor"/>
      <el-table style="width: 100%" border :data="doctors">
        <el-table-column prop="id" label="ID" width="180"></el-table-column>
        <el-table-column prop="name" label="医生名称"></el-table-column>
        <el-table-column label="操作">
          <template scope="scope">
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
        doctors: this.$store.state.doctors ? this.$store.state.doctors : []
      }
    },
    watch: {
      doctors (doctors) {
        this.$store.commit('getDoctors', doctors)
      }
    },
    methods: {
      addDoctor () {
        let self = this
        this.$prompt('医生名称', {
          showCancelButton: false,
          confirmButtonText: '创建'
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
        this.$prompt('医生名称', {
          showCancelButton: false,
          confirmButtonText: '更改',
          inputValue: row.name
        })
          .then(({value}) => {
            axios.patch(`/management/doctors/${row.id}`, qs.stringify({name: value}))
              .then(res => {
                self.doctors.splice(index, 1, res.doctor)
              })
          })
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
      !(async function () {
        if (!self.$store.state.doctors) {
          let {doctors} = await axios.get('/management/doctors')
          self.doctors = doctors
        }
        self.$store.state.loading = false
      }())
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss"></style>
