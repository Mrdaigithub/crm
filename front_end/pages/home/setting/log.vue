<template>
  <div class="log">
    <h2>行为日志</h2>
    <el-card class="box-card">
      <el-table :data="logData.data" style="width: 100%" border>
        <el-table-column prop="id" label="id" width="60"></el-table-column>
        <el-table-column prop="username" label="用户名"></el-table-column>
        <el-table-column prop="ip" label="ip"></el-table-column>
        <el-table-column prop="description" label="操作详情"></el-table-column>
        <el-table-column prop="method" label="请求方法"></el-table-column>
        <el-table-column prop="path" label="路径"></el-table-column>
        <el-table-column prop="data" label="数据"></el-table-column>
      </el-table>
      <el-pagination layout="prev, pager, next" :total="logData.total" :current-page="currentPage" :page-size="20"
                     @current-change="changePage" class="pagination"></el-pagination>
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
