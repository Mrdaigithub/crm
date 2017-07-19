<template>
  <div class="advisory-managemnet"  v-loading.body="$store.state.loading">
    <el-card class="box-card">
      <h2>Doctors management</h2>
      <el-button type="success" icon="plus" class="add-advisory" @click="addAdvisory"></el-button>
      <el-table style="width: 100%" border :data="advisories">
        <el-table-column prop="id" label="ID" width="180"></el-table-column>
        <el-table-column prop="name" label="name"></el-table-column>
        <el-table-column label="tools">
          <template scope="scope">
            <el-button size="small" icon="edit" @click="editAdvisoryName(scope.$index, scope.row)"></el-button>
            <el-button size="small" type="danger" icon="delete"
                       @click="removeDoctor(scope.$index, scope.row)"></el-button>
          </template>
        </el-table-column>
      </el-table>
    </el-card>
  </div>
</template>

<script>
  import axios from '../../../config/axios'
  import qs from 'qs'

  export default {
    name: 'advisoryManagement',
    data () {
      return {
        advisories: []
      }
    },
    methods: {
      addAdvisory () {
        let self = this
        this.$prompt('Please enter a doctor name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Create',
          inputPlaceholder: 'new doctor name'
        })
          .then(({value}) => {
            axios.get(`/management/advisories/create/${value}`)
              .then(res => {
                self.advisories.push(res.advisory)
              })
          })
      },
      editAdvisoryName (index, row) {
        let self = this
        this.$prompt('Please enter a role name', 'Tips', {
          showCancelButton: false,
          confirmButtonText: 'Submit',
          inputValue: row.name
        })
          .then(({value}) => {
            axios.patch(`/management/advisories/${row.id}`, qs.stringify({name: value}))
              .then(res => {
                self.advisories.splice(index, 1, res.advisory)
              })
          })
      },
      removeDoctor (index, row) {
        let self = this
        axios.delete(`/management/advisories/${row.id}`)
          .then(res => {
            self.advisories.splice(index, 1)
          })
      }
    },
    mounted () {
      let self = this
      axios.get('/management/advisories')
        .then(res => {
          self.advisories = res.advisories
          self.$store.state.loading = false
        })
    }
  }
</script>

<style scoped lang="scss">
  .box-card {
    margin: 15px;
    min-height: 85vh;
    h2 {
      margin-bottom: 5px;
    }
    .add-advisory {
      margin-bottom: 15px;
    }
  }
</style>
