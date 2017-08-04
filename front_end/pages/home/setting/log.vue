<template>
  <div class="log">
    <h2>Log</h2>
    <el-card class="box-card">
      <el-pagination layout="prev, pager, next" :total="logData.total" :current-page="currentPage" :page-size="20"
                     @current-change="changePage"></el-pagination>
      <el-table :data="logData.data" style="width: 100%" border>
        <el-table-column prop="id" label="id" width="60"></el-table-column>
        <el-table-column prop="username" label="username" width="100"></el-table-column>
        <el-table-column prop="ip" label="ip"></el-table-column>
        <el-table-column prop="description" label="description"></el-table-column>
        <el-table-column prop="method" label="method"></el-table-column>
        <el-table-column prop="path" label="path"></el-table-column>
        <el-table-column prop="data" label="data"></el-table-column>
      </el-table>
    </el-card>
  </div>
</template>

<script>
  import axios from '../../../config/axios'

  export default {
    name: 'log',
    data () {
      return {
        currentPage: 1,
        logData: {}
      }
    },
    methods: {
      changePage (currentPage) {
        this.currentPage = currentPage
        this.fetchPatients()
      },
      fetchPatients () {
        let self = this
        !(async function () {
          self.$store.state.loading = true
          self.logData = await axios.get(`/log?page=${self.currentPage}`)
          self.$store.state.loading = false
        }())
      }
    },
    mounted () {
      this.currentPage = 1
      this.fetchPatients()
    }
  }
</script>

<style scoped lang="scss"></style>
